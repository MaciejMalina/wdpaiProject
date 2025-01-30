<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../api/projects.php';
require_once __DIR__ . '/../api/users.php';

class DashboardController extends AppController {
    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $user = getUserById($_SESSION['user_id']);

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit();
        }

        $_SESSION['user'] = $user;

        require_once __DIR__ . '/../api/projects.php';
        $projects = getProjects($user['id'], $user['role']);

        $this->render('dashboard', [
            'user' => $user,
            'projects' => $projects
        ]);
    }
}
