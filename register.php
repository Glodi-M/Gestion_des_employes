<?php
include 'connexion.php';

// Initialize variables
$error_message = '';
$success_message = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve and sanitize form data
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');

        // Validate data
        $errors = [];
        if (empty($username)) {
            $errors[] = "Le nom d'utilisateur est requis.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            $errors[] = "Le nom d'utilisateur doit contenir 3 à 20 caractères alphanumériques ou '_'.";
        }
        if (empty($email)) {
            $errors[] = "L'email est requis.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format d'email invalide.";
        }
        if (empty($password)) {
            $errors[] = "Le mot de passe est requis.";
        } elseif (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        if (empty($confirm_password)) {
            $errors[] = "La confirmation du mot de passe est requise.";
        } elseif ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        if (count($errors) > 0) {
            $error_message = implode(", ", $errors);
        } else {
            // Check if user exists
            $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $query->execute(['username' => $username, 'email' => $email]);
            if ($query->fetchColumn() > 0) {
                $error_message = "Le nom d'utilisateur ou l'email existe déjà.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $query = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                $query->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashed_password
                ]);

                $success_message = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
            }
        }
    } catch (PDOException $e) {
        $error_message = "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="register-container">
        <h1>Créer un compte</h1>
        <form action="register.php" method="post" class="employee-form">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <small>Minimum 8 caractères</small>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="register-btn">S'inscrire</button>
        </form>
        <?php if ($error_message): ?>
            <script>
                showErrorAlert('<?php echo htmlspecialchars($error_message); ?>');
            </script>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <script>
                showSuccessAlert('<?php echo htmlspecialchars($success_message); ?>', 'login.php');
            </script>
        <?php endif; ?>
        <p class="login-link">Déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
    </div>
</body>

</html>