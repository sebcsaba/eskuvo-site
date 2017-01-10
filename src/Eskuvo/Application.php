<?php

namespace Eskuvo;

use Silex\Application as SilexApplication;

class Application
{
    public function run(SilexApplication $app)
    {
        $app->get('/hello', function() { return json_encode([
            'hello' => 'world',
        ]); });

        $app->run();
    }
}
