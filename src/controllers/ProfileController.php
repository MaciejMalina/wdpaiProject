<?php
require_once 'AppController.php';
require_once __DIR__. '/../repository/repository.php';

class ProfileController extends AppController {
    public function profile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $db = $database->connect();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $stmt = $db->prepare("SELECT id, name, email, role, phone, address, position, department FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "User data not found.";
            exit();
        }

        $this->render('profile', ['user' => $user]);
    }

    public function updateProfile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $db = $database->connect();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : null;
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $password = isset($_POST['password']) ? trim($_POST['password']) : null;
            $role = isset($_POST['role']) ? trim($_POST['role']) : null;
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
            $address = isset($_POST['address']) ? trim($_POST['address']) : null;
            $position = isset($_POST['position']) ? trim($_POST['position']) : null;
            $department = isset($_POST['department']) ? trim($_POST['department']) : null;
            

            $messages = [];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $messages[] = "Błąd: Nieprawidłowy format adresu e-mail.";
            }

            if (empty($messages)) {
                try {
                    $stmt = $db->prepare("UPDATE users SET name = :name, email = :email, password = :password, role = :role, phone = :phone, address = :address, position = :position, department = :department WHERE id = :id");

                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':role', $role);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':position', $position);
                    $stmt->bindParam(':department', $department);
                    $stmt->bindParam(':id', $user_id);

                    if ($stmt->execute()) {
                        $messages[] = "Dane zostały zaktualizowane.";
                    } else {
                        $messages[] = "Błąd: Wystąpił błąd podczas aktualizacji danych.";
                    }
                } catch (Exception $e) {
                    $messages[] = "Błąd: " . $e->getMessage();
                }
            }

            $this->render('profile', ['messages' => $messages, 'user' => [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'phone' => $phone,
                'address' => $address,
                'position' => $position,
                'department' => $department
            ]]);
        }
    }
}
