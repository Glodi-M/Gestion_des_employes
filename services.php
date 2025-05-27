<?php
include 'connexion.php';
$query = "SELECT * FROM employe";
$stmt = $pdo->prepare($query);
$stmt->execute();
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <header>
        <h1>Gestion des Employés</h1>
        <p>Bienvenue dans le système de gestion des employés</p>
    </header>

    <h2 class="dash"> DashBoard</h2>

    <main>
        <div class="container">
            <a href="add.php" class="btn-add"> <img src="images/plus.png" alt=""> Ajouter</a>

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
                        <th>Modifier</th>
                        <th>Supprimer</th>
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
                                <td> <a href="update.php?id=<?= htmlspecialchars($row['id_employe']); ?>">
                                        <img src="images/pen.png" alt=""> </a></td>
                                <td>
                                    <a href="#" onclick="confirmDelete('<?php echo htmlspecialchars($row['id_employe']); ?>'); return false;">
                                        <img src="images/trash.png" alt="Supprimer">
                                    </a>
                                </td>

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