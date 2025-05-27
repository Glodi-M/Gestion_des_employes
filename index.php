<?php
session_start();
include 'connexion.php';

// Initialize variables
$error_message = '';
$success_message = '';

if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
}
if (isset($_GET['success'])) {
    $success_message = htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8');
}

// Check user session
$is_authenticated = isset($_SESSION['user_id']);
$is_admin = $is_authenticated && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés - Accueil</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="Styles/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="images/image (2).jpg" alt="Logo" title="Accueil">
            </a>
        </div>

        <ul class="nav-links">
            <li><a href="index.php" class="nav-link active">Accueil</a></li>
            <li><a href="services.php" class="nav-link">Services</a></li>
            <?php if ($is_authenticated): ?>
                <li><a href="logout.php" class="nav-link">Déconnexion</a></li>
                <li><span class="nav-text">Bonjour, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></span></li>
            <?php else: ?>
                <li><a href="login.php" class="nav-link">Connexion</a></li>
                <li><a href="register.php" class="nav-btn">Créer un compte</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="home-container">
        <h1>Bienvenue dans la Gestion des Employés</h1>
        <p class="hero-text">
            Gérez votre équipe efficacement avec notre application intuitive. Suivez les informations des employés, planifiez les tâches, et assurez une gestion fluide de vos ressources humaines.
        </p>
        <div class="cta-buttons">
            <?php if ($is_admin): ?>
                <a href="services.php" class="cta-btn primary">Gérer les Employés</a>
            <?php elseif ($is_authenticated): ?>
                <a href="services.php" class="cta-btn primary">Voir les Services</a>
            <?php else: ?>
                <a href="login.php" class="cta-btn primary">Se Connecter</a>
                <a href="register.php" class="cta-btn secondary">S’inscrire</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Alerts -->
    <?php if ($error_message): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '<?php echo $error_message; ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '<?php echo $success_message; ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Gestion des Employés. Tous droits réservés.</p>
        <p><a href="contact.php">Contactez-nous</a> | <a href="about.php">À propos</a></p>
    </footer>
</body>

</html>