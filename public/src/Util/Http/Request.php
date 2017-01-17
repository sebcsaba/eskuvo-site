<?php

namespace Util\Http;

class Request
{
	/**
	 * @var array
	 */
	private $requestVars;


	public static function create($requestVars = null)
	{
		return new self($requestVars ?: $_REQUEST);
	}

	public function __construct(array $requestVars)
	{
		$this->requestVars = $requestVars;
	}

	public function get($param, $defaultValue = null)
	{
		return $this->request($param, $defaultValue);
	}

	public function request($param, $defaultValue = null)
	{
		return isset($this->requestVars[$param])
			? $this->requestVars[$param]
			: $defaultValue;
	}
}
