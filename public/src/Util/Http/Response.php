<?php

namespace Util\Http;

use Util\Json;

class Response
{
	const STATUS_OK = 200;
	const STATUS_INTERNAL_SERVER_ERROR = 500;

	/**
	 * @var array
	 */
	private $headers = [];

	/**
	 * @var string
	 */
	private $charSet;


	public static function create($charSet = 'UTF-8')
	{
		return new self($charSet);
	}

	public function __construct($charSet)
	{
		$this->charSet = $charSet;
	}

	public function header($key, $value)
	{
		$this->headers[$key] = $value;
		return $this;
	}

	public function json($data, $statusCode = self::STATUS_OK)
	{
		$this->header('Content-Type', "application/json;charset={$this->charSet}");
		$this->send(Json::create()->encode($data), $statusCode);
	}

	public function send($content, $statusCode = self::STATUS_OK)
	{
		header("HTTP/1.1 {$statusCode} {$this->statusText($statusCode)}");
		foreach ($this->headers as $key => $value) {
			header("$key: $value");
		}

		echo $content;
	}

	private function statusText($statusCode)
	{
		$texts = [
			self::STATUS_OK => 'OK',
			self::STATUS_INTERNAL_SERVER_ERROR => 'INTERNAL SERVER ERROR',
		];
		if (array_key_exists($statusCode, $texts)) {
			return $texts[$statusCode];
		}
		else {
			return $texts[self::STATUS_INTERNAL_SERVER_ERROR].'(code='.$statusCode.')';
		}
	}
}
