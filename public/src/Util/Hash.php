<?php

namespace Util;

class Hash
{
	public static function calculate(array $data)
	{
		return substr(sha1(implode('|', $data)), 0, 8);
	}
}
