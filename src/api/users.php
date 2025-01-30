<?php

function getUserById($userId) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare("SELECT id, name, email, role FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserField($userId, $field, $value) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $allowedFields = ['name', 'email', 'phone', 'address', 'position', 'department', 'password'];
    if (!in_array($field, $allowedFields)) {
        return false;
    }

    $stmt = $db->prepare("UPDATE users SET {$field} = :value WHERE id = :id");
    return $stmt->execute([':value' => $value, ':id' => $userId]);
}



