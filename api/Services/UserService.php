<?php
namespace Api\Services;

use Api\Controllers\UserController;

class UserService {
    private $controller;

    public function __construct() {
        $this->controller = new UserController();
    }

    public function registerUser($data) {
        $jsonData = json_encode($data);
        
        // Set up the request context
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => $jsonData
            ]
        ]);
        
        $response = file_get_contents('http://localhost/HabitaNet/public/api/register', false, $context);
        return json_decode($response, true);
    }
}
