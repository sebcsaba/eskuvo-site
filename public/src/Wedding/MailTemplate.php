<?php

namespace Wedding;

use Util\PhpTemplate;

class MailTemplate
{
	public static function create($url, $description)
	{
		return new PhpTemplate(function () use ($url, $description) {
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
}
