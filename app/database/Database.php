<?php
namespace app\database;
class Database
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = new \PDO('sqlite:data.db');
    }
    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}