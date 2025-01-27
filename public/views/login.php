<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamit - Logowanie</title>
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
                <input type="email" id="email" name="email" placeholder="email" required>
                <input type="password" id="password" name="password" placeholder="password" required>
                <button type="submit" class="login-button">Login</button>
            </form>
            <p class="register-text">
                Don't have an account? <a href="/register" class="register-link">Register!</a>
            </p>
        </div>
    </div>
</body>
</html>
