<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Styles/login.css">
    <link rel="stylesheet" href="Styles/style.css">
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="../Images/logo.png" alt="Logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-link active">Accueil</a></li>
            <li><a href="services.php" class="nav-link">Services</a></li>
            <li><a href="login.php" class="nav-link">Connexion</a></li>
            <li><a href="register.php" class="nav-btn">Créer un compte</a></li>
        </ul>
    </nav>

    <div class="register-container">
        <h1>Create Account</h1>
        <form action="process_register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <small>Minimum 8 characters</small>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="register-btn">Register</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>
        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>