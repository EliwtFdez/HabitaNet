<?php
namespace Controllers;

class DefaultController {
    
    public function index() {

        try {
            $data = [
                'title' => 'Welcome to Homepage',
                'content' => 'This is the main page content'
            ];
            
            require_once '../pages/home/home.php';
            
        } catch (Exception $e) {
            error_log($e->getMessage());
            require_once '../pages/NotFound.php';
        }
    }
}

?>