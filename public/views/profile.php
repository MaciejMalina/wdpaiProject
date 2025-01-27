<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="/css/profile.css">
    <script>
        function enableEdit(fieldId, valueId, inputId, saveButtonId) {
            // Ukryj pole z aktualną wartością
            document.getElementById(valueId).style.display = "none";
            
            // Pokaż pole input
            document.getElementById(inputId).style.display = "inline-block";
            document.getElementById(inputId).focus();

            // Pokaż przycisk "Save"
            document.getElementById(saveButtonId).style.display = "inline-block";
        }

        function submitEdit(fieldId, valueId, inputId, saveButtonId) {
            // Pobierz nową wartość z pola input
            const newValue = document.getElementById(inputId).value;

            // Wyślij zmiany do serwera (AJAX lub pełne przesłanie formularza)
            document.getElementById("field").value = fieldId;
            document.getElementById("value").value = newValue;
            document.getElementById("editForm").submit();

            // Opcjonalnie: Aktualizacja lokalna bez reloadu (odkomentuj, jeśli korzystasz z AJAX)
            // document.getElementById(valueId).innerText = newValue;
            // document.getElementById(valueId).style.display = "inline-block";
            // document.getElementById(inputId).style.display = "none";
            // document.getElementById(saveButtonId).style.display = "none";
        }
    </script>
</head>
<body>
    <div class="header">
        <button onclick="history.back()" class="back-button">Back</button>
        <h1>Your Profile</h1>
    </div>
    <div class="content">
        <div class="profile-card">
            <h2>Personal Information</h2>
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
        </div>
    </div>
</body>
</html>