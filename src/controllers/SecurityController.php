<?php

require_once __DIR__ . '/AppController.php';

class SecurityController extends AppController {
    public function register() {
        $error = null;

        if ($this->isPost()) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Sprawdzenie, czy hasła są takie same
            if ($password !== $confirmPassword) {
                $error = "Passwords do not match!";
            } else {
                $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');
                $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
                $stmt->execute(['email' => $email]);

                if ($stmt->fetch()) {
                    $error = "Email already in use!";
                } else {
                    // Zapisanie hasła w formie zwykłego tekstu (plaintext)
                    $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
                    $stmt->execute([
                        'name' => $name,
                        'email' => $email,
                        'password' => $password // Hasło zapisane w formie tekstu
                    ]);
                    header('Location: /login');
                    exit();
                }
            }
        }

        $this->render('register', ['error' => $error]);
    }
    
    public function login() {
        session_start();
        $error = null;
    
        if ($this->isPost()) {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');
            $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && $user['password'] === $password) {
                // Logowanie pomyślne
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                header('Location: /dashboard');
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        }
    
        $this->render('login', ['error' => $error]);
    }    

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
