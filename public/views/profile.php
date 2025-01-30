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
                <p>
                    <strong>Name:</strong>
                    <span id="user-name"><?= htmlspecialchars($user['name'] ?? '') ?></span>
                    <button type="button" onclick="toggleEdit('name')" class="edit-button">Edit</button>
                    <input id="name-input" type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" style="display: none;">
                </p>

                <p>
                    <strong>Email:</strong>
                    <span id="user-email"><?= htmlspecialchars($user['email'] ?? '') ?></span>
                    <button type="button" onclick="toggleEdit('email')" class="edit-button">Edit</button>
                    <input id="email-input" type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" style="display: none;">
                </p>

                <p>
                    <strong>Phone:</strong>
                    <span id="user-phone"><?= htmlspecialchars($user['phone'] ?? '') ?></span>
                    <button type="button" onclick="toggleEdit('phone')" class="edit-button">Edit</button>
                    <input id="phone-input" type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" style="display: none;">
                </p>

                <p>
                    <strong>Address:</strong>
                    <span id="user-address"><?= htmlspecialchars($user['address'] ?? '') ?></span>
                    <button type="button" onclick="toggleEdit('address')" class="edit-button">Edit</button>
                    <input id="address-input" type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" style="display: none;">
                </p>

                <p>
                    <strong>Position:</strong>
                    <span id="user-position"><?= htmlspecialchars($user['position'] ?? '') ?></span>
                    <button type="button" onclick="toggleEdit('position')" class="edit-button">Edit</button>
                    <input id="position-input" type="text" name="position" value="<?= htmlspecialchars($user['position'] ?? '') ?>" style="display: none;">
                </p>

                <p>
                    <strong>Department:</strong>
                    <span id="user-department"><?= htmlspecialchars($user['department'] ?? '') ?></span>
                    <button type="button" onclick="toggleEdit('department')" class="edit-button">Edit</button>
                    <input id="department-input" type="text" name="department" value="<?= htmlspecialchars($user['department'] ?? '') ?>" style="display: none;">
                </p>

                <p>
                    <strong>Password:</strong>
                    <span id="user-password">********</span> <!-- Nie pokazujemy hasła -->
                    <button type="button" onclick="toggleEdit('password')" class="edit-button">Edit</button>
                    <input id="password-input" type="password" name="password" value="" style="display: none;">
                </p>

                <button type="submit" class="save-button">Save Changes</button>
            </form>

        </div>
    </div>
</body>
</html>


<!--
<form id="editForm" method="POST" action="/profile">
                <input type="hidden" name="field" id="field">
                <input type="hidden" name="value" id="value">
                <div class="profile-row">
                    <strong>Name:</strong>
                    <span id="nameValue"><?= htmlspecialchars($user['name']) ?></span>
                    <input type="text" id="nameInput" style="display: none;" value="<?= htmlspecialchars($user['name']) ?>" name="name">
                    <button type="button" class="edit-button" onclick="enableEdit('name', 'nameValue', 'nameInput', 'nameSave')">Edit</button>
                    <button type="button" id="nameSave" class="edit-button" style="display: none;" onclick="submitEdit('name', 'nameValue', 'nameInput', 'nameSave')">Save</button>
                </div>
                <div class="profile-row">
                    <strong>Email:</strong>
                    <span id="emailValue"><?= htmlspecialchars($user['email']) ?></span>
                    <input type="email" id="emailInput" style="display: none;" value="<?= htmlspecialchars($user['email']) ?>" name="email">
                    <button type="button" class="edit-button" onclick="enableEdit('email', 'emailValue', 'emailInput', 'emailSave')">Edit</button>
                    <button type="button" id="emailSave" class="edit-button" style="display: none;" onclick="submitEdit('email', 'emailValue', 'emailInput', 'emailSave')">Save</button>
                </div>
                <div class="profile-row">
                    <strong>Phone:</strong>
                    <span id="phoneValue"><?= htmlspecialchars($user['phone'] ?? '') ?></span>
                    <input type="text" id="phoneInput" style="display: none;" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" name="phone">
                    <button type="button" class="edit-button" onclick="enableEdit('phone', 'phoneValue', 'phoneInput', 'phoneSave')">Edit</button>
                    <button type="button" id="phoneSave" class="edit-button" style="display: none;" onclick="submitEdit('phone', 'phoneValue', 'phoneInput', 'phoneSave')">Save</button>
                </div>
                <div class="profile-row">
                    <strong>Address:</strong>
                    <span id="addressValue"><?= htmlspecialchars($user['address'] ?? '') ?></span>
                    <input type="text" id="addressInput" style="display: none;" value="<?= htmlspecialchars($user['address'] ?? '') ?>" name="address">
                    <button type="button" class="edit-button" onclick="enableEdit('address', 'addressValue', 'addressInput', 'addressSave')">Edit</button>
                    <button type="button" id="addressSave" class="edit-button" style="display: none;" onclick="submitEdit('address', 'addressValue', 'addressInput', 'addressSave')">Save</button>
                </div>
                <h2>Professional details</h2>
                <div class="profile-row">
                    <strong>Position:</strong>
                    <span id="positionValue"><?= htmlspecialchars($user['position'] ?? '') ?></span>
                    <input type="text" id="positionInput" style="display: none;" value="<?= htmlspecialchars($user['position'] ?? '') ?>" name="position">
                    <button type="button" class="edit-button" onclick="enableEdit('position', 'positionValue', 'positionInput', 'positionSave')">Edit</button>
                    <button type="button" id="positionSave" class="edit-button" style="display: none;" onclick="submitEdit('position', 'positionValue', 'positionInput', 'positionSave')">Save</button>
                </div>
                <div class="profile-row">
                    <strong>Department:</strong>
                    <span id="departmentValue"><?= htmlspecialchars($user['department'] ?? '') ?></span>
                    <input type="text" id="departmentInput" style="display: none;" value="<?= htmlspecialchars($user['department'] ?? '') ?>" name="department">
                    <button type="button" class="edit-button" onclick="enableEdit('department', 'departmentValue', 'departmentInput', 'departmentSave')">Edit</button>
                    <button type="button" id="departmentSave" class="edit-button" style="display: none;" onclick="submitEdit('department', 'departmentValue', 'departmentInput', 'departmentSave')">Save</button>
                </div>
                <h2>Password</h2>
                <div class="profile-row">
                    <strong>Password:</strong>
                    <span id="passwordValue"><?= htmlspecialchars($user['password'] ?? '') ?></span>
                    <input type="text" id="passwordInput" style="display: none;" value="<?= htmlspecialchars($user['password'] ?? '') ?>" name="password">
                    <button type="button" class="edit-button" onclick="enableEdit('password', 'passwordValue', 'passwordInput', 'passwordSave')">Edit</button>
                    <button type="button" id="passwordSave" class="edit-button" style="display: none;" onclick="submitEdit('password', 'passwordValue', 'passwordInput', 'passwordSave')">Save</button>
                </div>
            </form>