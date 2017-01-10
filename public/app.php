<?php

use Eskuvo\Application;

require_once __DIR__.'/vendor/autoload.php';

(new Application())->run(new \Silex\Application());
