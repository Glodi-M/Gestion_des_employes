<?php
session_start();
include 'connexion.php';

// Initialize variables
$error_message = '';
$is_authenticated = isset($_SESSION['user_id']);
$is_admin = $is_authenticated && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!$is_authenticated) {
    header("Location: login.php?error=" . urlencode("Veuillez vous connecter pour accéder aux services."));
    exit();
}

try {
    $query = "SELECT * FROM employe";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    $error_message = "Erreur : " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Employés</title>
    <link rel="stylesheet" href="../Styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="Images/logo.png" alt="Logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-link">Accueil</a></li>
            <li><a href="services.php" class="nav-link active">Services</a></li>
            <li><a href="logout.php" class="nav-link">Déconnexion</a></li>
            <li><span class="nav-text">Bonjour, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></span></li>
        </ul>
    </nav>

    <header>
        <h1>Gestion des Employés</h1>
        <p>Bienvenue dans le système de gestion des employés</p>
    </header>

    <!-- Dashboard -->
    <h2 class="dash"> Tableau de Bord des Employés</h2>

    <main>
        <div class="container">
            <?php if ($is_admin): ?>
                <a href="add.php" class="btn-add"> <img src="images/plus.png" alt=""> Ajouter</a>
            <?php endif; ?>

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
            <?php if (isset($_GET['success'])): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: '<?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>',
                        confirmButtonText: 'OK'
                    });
                </script>
            <?php endif; ?>

            <table>
                <thead>
                    <tr id="items">
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Age</th>
                        <th>Date de naissance</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <?php if ($is_admin): ?>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employes)): ?>
                        <?php foreach ($employes as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['age']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_naissance']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['telephone']); ?></td>
                                <td><?php echo htmlspecialchars($row['adresse']); ?></td>
                                <?php if ($is_admin): ?>
                                    <td> <a href="update.php?id=<?= htmlspecialchars($row['id_employe']); ?>">
                                            <img src="images/pen.png" alt=""> </a></td>
                                    <td>
                                        <a href="#" onclick="confirmDelete('<?php echo htmlspecialchars($row['id_employe']); ?>'); return false;">
                                            <img src="images/trash.png" alt="Supprimer">
                                        </a>
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Aucun employé trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Gestion des Employés. Tous droits réservés.</p>
    </footer>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Voulez-vous vraiment supprimer cet employé ?',
                text: 'Cette action est irréversible !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete.php?id=' + encodeURIComponent(id);
                }
            });
        }
    </script>
</body>

</html>