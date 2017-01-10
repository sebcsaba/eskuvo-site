<?php

namespace Wedding;

use PDO;
use Silex\Application as SilexApplication;

class Application
{
    /**
     * @var Factory
     */
    private $factory;


    public static function create()
    {
        return new self(new Factory());
    }

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function run(SilexApplication $app)
    {
        $app['debug'] = getenv('APPLICATION_ENV') === 'development';

        $app->get('/wish', $this->wishList());

        $app->run();
    }

    /**
     * @return callable
     */
    private function wishList()
    {
        return function () {
            return json_encode($this->factory->createDao()->getWishes());
        };
    }
}
