<?php

namespace Wedding;

use Util\PhpTemplate;

class MailTemplate extends PhpTemplate
{
	public static function create($url, $description)
	{
		return new MailTemplate(function () use ($url, $description) {
			?>
			<html>
			<body>
			<h1><?= $description ?></h1>
			this is the url: <?= $url ?>
			</body>
			</html>
			<?php
		});
	}

	public function getFrom()
	{
		return 'Bogi és Csaba <no-reply@maxer.hu>';
	}

	public function getReplyTo()
	{
		return 'Sebestyén Csaba <sebcsaba@gmail.com>';
	}

	public function getSubject()
	{
		return 'Nászajándék';
	}

}
