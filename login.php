<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
    <div class="login-container">
        <h1>Login</h1>
        <form action="authenticate.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>

</html>