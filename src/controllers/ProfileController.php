<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../api/users.php';

class ProfileController extends AppController {
    public function profile() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }

        $user = getCurrentUser(); // Funkcja pobiera dane aktualnie zalogowanego użytkownika
        $this->render('profile', ['user' => $user]);
    }
}
