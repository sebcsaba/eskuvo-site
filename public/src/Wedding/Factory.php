<?php

namespace Wedding;

use PDO;

class Factory
{
    public function createDb()
    {
        $db = new PDO(getenv('DB_DSN'), getenv('DB_USER'), getenv('DB_PASS'));
        $db->exec("SET NAMES utf8");
        return $db;
    }

    public function createDao()
    {
        return new Dao($this->createDb());
    }
}
