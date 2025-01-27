<?php

function getCurrentUser() {
    if (!isset($_SESSION['user'])) {
        return null;
    }

    $userId = $_SESSION['user']['id'];
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare('
        SELECT name, email, phone, address, position, department, password 
        FROM users 
        WHERE id = :id
    ');
    $stmt->execute(['id' => $userId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserField($userId, $field, $value) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    // Przygotowanie zapytania z dynamiczną nazwą kolumny
    $stmt = $db->prepare("UPDATE users SET $field = :value WHERE id = :id");
    $stmt->execute([
        'value' => $value,
        'id' => $userId
    ]);
}
