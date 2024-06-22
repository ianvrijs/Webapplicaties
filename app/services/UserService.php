<?php

namespace app\services;

use app\database\Database;

class UserService
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getUserByUsernameOrEmail($usernameOrEmail)
    {
        $stmt = $this->database->getConnection()->prepare(
            'SELECT * FROM users WHERE username = :usernameOrEmail OR email = :usernameOrEmail'
        );
        $stmt->execute([':usernameOrEmail' => $usernameOrEmail]);

        return $stmt->fetch();
    }

    public function createUser($username, $email, $password)
    {
        $stmt = $this->database->getConnection()->prepare(
            'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
        );
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return $stmt->rowCount() > 0;
    }
}