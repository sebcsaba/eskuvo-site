<?php

namespace Wedding;

use PDO;

class Factory
{
    public function createDb()
    {
        return new PDO(getenv('DB_DSN'), getenv('DB_USER'), getenv('DB_PASS'));
    }

    public function createDao()
    {
        return new Dao($this->createDb());
    }
}
