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

	/**
	 * @var array
	 */
	private $headers = [];


	public static function create($subject, $content)
	{
		return new self($subject, $content);
	}

	public function __construct($subject, $content)
	{
		$this->subject = $subject;
		$this->content = $content;
	}

	public function html($charSet = 'UTF-8')
	{
		return $this->addHeader('Content-Type', "text/html; charset=$charSet");
	}

	public function from($email)
	{
		return $this->addHeader('From', $email);
	}

	public function replyTo($email)
	{
		return $this->addHeader('Reply-To', $email);
	}

	public function sendTo(array $recipients)
	{
		$this->addHeader('MIME-Version', '1.0');

		mail(implode(', ', $recipients), $this->subject, $this->content, implode("\r\n", array_map(
			function ($key, $value) { return "$key: $value"; },
			array_keys($this->headers),
			array_values($this->headers)
		)));
	}

	private function addHeader($key, $value)
	{
		$this->headers[$key] = $value;
		return $this;
	}
}
