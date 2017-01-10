<?php

namespace Wedding;

use Exception;
use PDO;

class Dao
{
    /**
     * @var PDO
     */
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getWishes()
    {
        return $this->fetchAll("SELECT id, description FROM wedding_list WHERE email IS NULL ORDER BY description");
    }

    private function fetchAll($query)
    {
        $stmt = $this->db->query($query);
        if (!$stmt) {
            throw new Exception("Failed to run query.");
        }
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
