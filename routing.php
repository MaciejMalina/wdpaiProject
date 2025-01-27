<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/ProfileController.php';

class Routing {
    public static function run($url) {
        $action = explode("/", $url)[0];
        $controller = null;

        if ($action === 'login') {
            $controller = new SecurityController();
            $controller->login();
        } elseif ($action === 'logout') {
            $controller = new SecurityController();
            $controller->logout();
        } elseif ($action === 'register') {
            $controller = new SecurityController();
            $controller->register(); // Dodaj metodę do obsługi rejestracji
        } elseif ($action === 'dashboard') {
            $controller = new DashboardController();
            $controller->dashboard();
        } elseif ($action === 'profile') {
            $controller = new ProfileController();
            $controller->profile();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
