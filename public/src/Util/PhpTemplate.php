<?php

namespace Util;

use InvalidArgumentException;

class PhpTemplate
{
	/**
	 * @var callable
	 */
	private $template;

	public function __construct($template)
	{
		if (!is_callable($template)) {
			throw new InvalidArgumentException("Template should be callable");
		}
		$this->template = $template;
	}

	/**
	 * @return string
	 */
	public function render()
	{
		ob_start();
		call_user_func($this->template);
		return ob_get_clean();
	}
}
