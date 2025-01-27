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

        $user = getCurrentUser(); // Pobiera dane użytkownika

        if ($user === false) {
            echo "User data not found.";
            exit();
        }

        $this->render('profile', ['user' => $user]); // Przekazuje dane do widoku
    }
}
