<?php
// profile.php
require_once '../src/api/users.php';
$user = getCurrentUser(); // Pobranie danych aktualnie zalogowanego użytkownika
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
    <div class="header">
        <button onclick="history.back()" class="back-button">Back</button>
        <h1>Your Profile</h1>
    </div>
    <div class="content">
        <div class="profile-card">
            <h2>Personal Information</h2>
            <div class="profile-row">
                <strong>Name:</strong>
                <span><?= htmlspecialchars($user['name']) ?></span>
                <button class="edit-button">Edit</button>
            </div>
            <div class="profile-row">
                <strong>Email:</strong>
                <span><?= htmlspecialchars($user['email']) ?></span>
                <button class="edit-button">Edit</button>
            </div>
            <div class="profile-row">
                <strong>Phone:</strong>
                <span><?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></span>
                <button class="edit-button">Edit</button>
            </div>
            <div class="profile-row">
                <strong>Address:</strong>
                <span><?= htmlspecialchars($user['address'] ?? 'Not provided') ?></span>
                <button class="edit-button">Edit</button>
            </div>
            <div class="profile-row">
                <strong>Position:</strong>
                <span><?= htmlspecialchars($user['position'] ?? 'Not provided') ?></span>
                <button class="edit-button">Edit</button>
            </div>
            <div class="profile-row">
                <strong>Department:</strong>
                <span><?= htmlspecialchars($user['department'] ?? 'Not provided') ?></span>
                <button class="edit-button">Edit</button>
            </div>
        </div>
    </div>
</body>
</html>
