<?php

namespace Util;

class Mail
{
	/**
	 * @var string
	 */
	private $subject;

	/**
	 * @var string
	 */
	private $content;

	public static function create($subject, $content)
	{
		return new self($subject, $content);
	}

	public function __construct($subject, $content)
	{
		$this->subject = $subject;
		$this->content = $content;
	}

	public function sendTo(array $recipients)
	{
		mail(implode(', ', $recipients), $this->subject, $this->content);
	}
}
