<?php

use Wedding\Application;

require_once __DIR__.'/vendor/autoload.php';

Application::create()->run(new \Silex\Application());
