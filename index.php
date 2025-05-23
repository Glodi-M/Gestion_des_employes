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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <div class="container">
            <a href="add.php" class="btn-add"> <img src="images/plus.png" alt=""> Ajouter</a>

            <table>
                <thead>
                    <tr id="items">
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Age</th>
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
                                <td> <a href="update.php?id=<?= $row['id_employe']; ?>"> <img src="images/pen.png" alt=""> </a></td>
                                <td> <a href="delete.php?id=<?= $row['id_employe']; ?>"> <img src="images/trash.png" alt=""> </a></td>
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
</body>

</html>