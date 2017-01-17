<?php

namespace Wedding;

use Silex\Application as SilexApplication;
use Util\Json;
use Symfony\Component\HttpFoundation\Request;

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

	public function run(SilexApplication $app)
	{
		$app['debug'] = getenv('APPLICATION_ENV') === 'development';

		$app->get('/wish', $this->wishList());
		$app->post('/reserve', $this->reserveItem());
		$app->post('/cancel', $this->cancelItem());

		$app->run();
	}

	/**
	 * @return callable
	 */
	private function wishList()
	{
		return function () {
			return Json::create()->encode($this->factory->createDao()->getWishes());
		};
	}

	/**
	 * @return callable
	 */
	private function reserveItem() {
		return function (Request $request) {
			$id = $request->request->get('id');
			$email = $request->request->get('email');
			$code = substr(sha1($id.'|'.$email.'|'.time()), 0, 8);
			$this->factory->createDao()->reserveWish($id, $email, $code);
			return Json::create()->encode('OK');
		};
	}

	/**
	 * @return callable
	 */
	private function cancelItem() {
		return function (Request $request) {
			$id = $request->request->get('id');
			$email = $request->request->get('email');
			$code = $request->request->get('code');
			$this->factory->createDao()->cancelWish($id, $email, $code);
			return Json::create()->encode('OK');
		};
	}

}
