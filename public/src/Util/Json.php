<?php

namespace Util;

use Exception;

class Json
{
	/**
	 * @var array
	 */
	private $errorMap;

	public static function create()
	{
		$errorMapBase = [
			'JSON_ERROR_DEPTH' => 'The maximum stack depth has been exceeded',
			'JSON_ERROR_STATE_MISMATCH' => 'Invalid or malformed JSON',
			'JSON_ERROR_CTRL_CHAR' => 'Control character error, possibly incorrectly encoded',
			'JSON_ERROR_SYNTAX' => 'Syntax error',
			'JSON_ERROR_UTF8' => 'Malformed UTF-8 characters, possibly incorrectly encoded',
			'JSON_ERROR_RECURSION' => 'One or more recursive references in the value to be encoded',
			'JSON_ERROR_INF_OR_NAN' => 'One or more NAN or INF values in the value to be encoded',
			'JSON_ERROR_UNSUPPORTED_TYPE' => 'A value of a type that cannot be encoded was given',
			'JSON_ERROR_INVALID_PROPERTY_NAME' => 'A property name that cannot be encoded was given',
			'JSON_ERROR_UTF16' => 'Malformed UTF-16 characters, possibly incorrectly encoded',
		];
		$errorMap = [];
		foreach ($errorMapBase as $constant => $message) {
			if (defined($constant)) {
				$errorMap[constant($constant)] = $message;
			}
		}
		return new self($errorMap);
	}

	public function __construct(array $errorMap)
	{
		$this->errorMap = $errorMap;
	}

	public function encode($value, $options = 0)
	{
		$result = json_encode($value, $options);
		$errorCode = json_last_error();
		if (JSON_ERROR_NONE === $errorCode) {
			return $result;
		}

		throw new Exception('json_encode(): ' . $this->getMessage($errorCode));
	}

	public function decode($json, $assoc = false, $depth = 512, $options = 0)
	{
		$result = json_decode($json, $assoc, $depth, $options);
		$errorCode = json_last_error();
		if (JSON_ERROR_NONE === $errorCode) {
			return $result;
		}
		throw new Exception('json_decode(): ' . $this->getMessage($errorCode));
	}

	/**
	 * @param $errorCode
	 * @return mixed|string
	 */
	private function getMessage($errorCode)
	{
		return (isset($this->errorMap[$errorCode]) ? $this->errorMap[$errorCode] : 'Unknown error');
	}

}
