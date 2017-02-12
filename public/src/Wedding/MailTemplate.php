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
			<p>Kedves Vendégünk!</p>
			<p>Ezt a dolgot foglaltad le: <?= $description ?> Köszönjük szépen, már nagyon vágytunk rá!</p>
			<p>Ha netán valami közbejött, és szeretnéd mondani a foglalásodat, <a href="<?= $url ?>">erre a linkre</a> kattintva megteheted.</p>
			<p>Várunk szeretettel június 17-én!</p>
			<p>Bogi & Csaba</p>
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
