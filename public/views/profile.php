<?php
$isUser = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="/css/profile.css">
    <script>
        function toggleEdit(field) {
            const valueSpan = document.getElementById(`user-${field}`);
            const inputField = document.getElementById(`${field}-input`);

            if (valueSpan.style.display === "none") {
                valueSpan.style.display = "inline";
                inputField.style.display = "none";
            } else {
                valueSpan.style.display = "none";
                inputField.style.display = "inline";
                inputField.focus();
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <button class="back-button" onclick="location.href='/dashboard'">Back</button>
        <h1>Your Profile</h1>
        <div class="nav-links">
            <a href="/logout" class="account">Logout</a>
        </div>
    </div>
    <div class="content">
        <div class="profile-card">
            <h2>Personal Information</h2>
            
            <form id="editForm" method="POST" action="/updateProfile">
                <p class="profile-row">
                    <strong>Name:</strong>
                    <span id="user-name"><?= htmlspecialchars($user['name'] ?? '') ?></span>
                    <input id="name-input" type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                    <button type="button" onclick="toggleEdit('name')" class="edit-button">Edit</button>
                    </div>
                </p>

                <p class="profile-row">
                    <strong>Email:</strong>
                    <span id="user-email"><?= htmlspecialchars($user['email'] ?? '') ?></span>
                    <input id="email-input" type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                    <button type="button" onclick="toggleEdit('email')" class="edit-button">Edit</button>
                    </div>
                </p>
                <p class="profile-row">
                    <strong>Phone:</strong>
                    <span id="user-phone"><?= htmlspecialchars($user['phone'] ?? '') ?></span>
                    <input id="phone-input" type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                        <button type="button" onclick="toggleEdit('phone')" class="edit-button">Edit</button>
                    </div>
                </p>
                <p class="profile-row">
                    <strong>Address:</strong>
                    <span id="user-address"><?= htmlspecialchars($user['address'] ?? '') ?></span>
                    <input id="address-input" type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                        <button type="button" onclick="toggleEdit('address')" class="edit-button">Edit</button>
                    </div>
                </p>
                <p class="profile-row">
                    <strong>Password:</strong>
                    <span id="user-password"><?= htmlspecialchars($user['password'] ?? '') ?></span>
                    <input id="password-input" type="password" name="password" value="<?= htmlspecialchars($user['password'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                        <button type="button" onclick="toggleEdit('password')" class="edit-button">Edit</button>
                    </div>
                </p>
                <h2>Profesional Details</h2>
                <p class="profile-row">
                    <strong>Position:</strong>
                    <span id="user-position"><?= htmlspecialchars($user['position'] ?? '') ?></span>
                    <input id="position-input" type="text" name="position" value="<?= htmlspecialchars($user['position'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                        <button type="button" onclick="toggleEdit('position')" class="edit-button">Edit</button>
                    </div>
                </p>
                <p class="profile-row">
                    <strong>Department:</strong>
                    <span id="user-department"><?= htmlspecialchars($user['department'] ?? '') ?></span>
                    <input id="department-input" type="text" name="department" value="<?= htmlspecialchars($user['department'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                        <button type="button" onclick="toggleEdit('department')" class="edit-button">Edit</button>
                    </div>
                </p>
                <p class="profile-row">
                    <strong>Role:</strong>
                    <span id="user-role"><?= htmlspecialchars($user['role'] ?? '') ?></span>
                    <input id="role-input" type="text" name="role" value="<?= htmlspecialchars($user['role'] ?? '') ?>" style="display: none;">
                    <div class="button-container">
                        <button type="button" onclick="toggleEdit('role')" class="edit-button">Edit</button>
                    </div>
                </p>
                <button type="submit" class="save-button">Save Changes</button>
            </form>

        </div>
    </div>
</body>
</html>