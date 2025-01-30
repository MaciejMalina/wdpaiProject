<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__. '/../repository/repository.php';

class SecurityController extends AppController {
    public function register() {
        $error = null;
        $database = new Database();
        $db = $database->connect();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);

            if ($password !== $confirmPassword) {
                $error = "Passwords do not match!";
            } else {
                $stmt =$db->prepare('SELECT * FROM users WHERE email = :email');
                $stmt->execute(['email' => $email]);

                if ($stmt->fetch()) {
                    $error = "Email already in use!";
                } else {
                    $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
                    $stmt->execute([
                        'name' => $name,
                        'email' => $email,
                        'password' => $password
                    ]);
                    header('Location: /login');
                    exit();
                }
            }
        }

        $this->render('register', ['error' => $error]);
    }
    
        public function login() {
            if (session_status() == PHP_SESSION_NONE) { 
                session_start();
            }

            $database = new Database();
            $db = $database->connect();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($user && $user['password'] === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
        
                    header('Location: /dashboard');
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            }
        
            $this->render('login', ['error' => $error ?? '']);
        }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /login');
        exit();
    }
}