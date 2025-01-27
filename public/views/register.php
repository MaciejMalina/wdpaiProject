<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <div class="container">
        <div class="logo-section">
                <img src="logo2.png" alt="Teamit Logo" class="logo">
            </div>
            <div class="login-section">
                <form method="POST">
                    <?php if (isset($error)): ?>
                        <p style="color: red;"><?= $error ?></p>
                    <?php endif; ?>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" class="login-button">Register</button>
        </form>
        <p class="register-text">
            Already have an account? <a href="/login">Login here!</a></p>
        </div>
    </div>
</body>
</html>
