<?php
include 'connexion.php';
session_start();

// Initialize variables
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve and sanitize form data
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validate data
        if (empty($username) || empty($password)) {
            $error_message = "Le nom d'utilisateur et le mot de passe sont requis.";
        } else {
            // Check user credentials
            $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $query->execute(['username' => $username]);
            $user = $query->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'] ?? 'user';
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la connexion : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="Styles/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="images/image (2).jpg" alt="Logo" title="Accueil">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-link">Accueil</a></li>
            <li><a href="services.php" class="nav-link">Services</a></li>
            <li><a href="login.php" class="nav-link active">Connexion</a></li>
            <li><a href="register.php" class="nav-btn">Créer un compte</a></li>
        </ul>
    </nav>
    <div class="login-container">
        <h1>Connexion</h1>
        <form action="login.php" method="post" class="employee-form">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Se connecter</button>
        </form>
        <?php if ($error_message): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '<?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>',
                    confirmButtonText: 'OK'
                });
            </script>
        <?php endif; ?>
        <p class="register-link">Pas de compte ? <a href="register.php">Inscrivez-vous ici</a></p>

    </div>
</body>

</html>