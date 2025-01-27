<?php

require_once __DIR__ . '/AppController.php';

class DashboardController extends AppController {
    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }

        $user = $_SESSION['user'];
        $this->render('dashboard', ['user' => $user]);
    }
}
