<?php

namespace app\services;

class UserService
{
    public function getUser($userId)
    {
        // Fetch the user from the database using the provided ID
        // This is just a placeholder. Replace this with your actual database query.
        return [
            'id' => $userId,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];
    }
}