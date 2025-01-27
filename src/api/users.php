<?php

function getCurrentUser() {
    if (!isset($_SESSION['user'])) {
        return null;
    }

    $userId = $_SESSION['user']['id'];
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare('SELECT name, email, phone FROM users WHERE id = :id');
    $stmt->execute(['id' => $userId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
