<?php

namespace Wedding;

use Exception;

use Util\Hash;
use Util\Http\Request;
use Util\Http\Response;
use Util\Mail;

class Application
{
	/**
	 * @var Factory
	 */
	private $factory;


	public static function create()
	{
		return new self(new Factory());
	}

	public function __construct(Factory $factory)
	{
		$this->factory = $factory;
	}

	public function run()
	{
		try {
			foreach ([
						 '/wish' => $this->wishList(),
						 '/reserve' => $this->reserveItem(),
						 '/cancel' => $this->cancelItem(),
					 ] as $route => $action) {
				$matches = [];
				if (!preg_match($this->convert($route), $_SERVER['PATH_INFO'], $matches)) {
					continue;
				}
				$this->execute($action);
				return;
			}
		} catch (Exception $ex) {
			$this->execute($this->handle($ex));
			return;
		}
		$this->execute($this->notFound());
	}

	/**
	 * @return callable
	 */
	private function wishList()
	{
		return function (Request $request, Response $response) {
			$response->json($this->factory->createDao()->getWishes());
		};
	}

	/**
	 * @return callable
	 */
	private function reserveItem()
	{
		return function (Request $request, Response $response) {
			$id = $request->get('id');
			$email = $request->get('email');

			$code = Hash::calculate([$id, $email, time()]);
			$wish = $this->factory->createDao()->reserveWish($id, $email, $code);

			$url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/'. $_SERVER['REQUEST_URI'] . '#' . url_encode("cancel|$id|$email|$code");
			Mail::create(
				'subject',
				MailTemplate::create($url, $wish->description)->render()
			)->sendTo([$email]);

			$response->json('OK');
		};
	}

	/**
	 * @return callable
	 */
	private function cancelItem()
	{
		return function (Request $request, Response $response) {
			$id = $request->get('id');
			$email = $request->get('email');
			$code = $request->get('code');

			$this->factory->createDao()->cancelWish($id, $email, $code);

			$response->json('OK');
		};
	}

	private function notFound()
	{
		return function (Request $request, Response $response) {
			$response->json([]);
		};
	}

	private function convert($route)
	{
		return '/^' . preg_quote($route, '/') . '$/';
	}

	/**
	 * @param $action
	 */
	private function execute($action)
	{
		call_user_func($action, Request::create(), Response::create());
	}

	private function handle(Exception $ex)
	{
		return function (Request $request, Response $response) use ($ex) {
			$response->send('ERROR: '.$ex->getMessage().' '.$ex->getTraceAsString(), Response::STATUS_INTERNAL_SERVER_ERROR);
		};
	}
}
