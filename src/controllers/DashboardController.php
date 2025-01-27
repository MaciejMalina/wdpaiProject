<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../api/projects.php';

class DashboardController extends AppController {
    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }

        $user = $_SESSION['user'];
        $projects = getProjects(); // Pobierz projekty

        $this->render('dashboard', [
            'user' => $user,
            'projects' => $projects // Przekaż projekty do widoku
        ]);
    }
}
