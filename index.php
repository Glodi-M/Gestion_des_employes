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
            <a href="add.html" class="btn-add"> <img src="images/plus.png" alt=""> Ajouter</a>

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
                    <tr>
                        <td>Mietete</td>
                        <td>Glodi</td>
                        <td>28 ans</td>
                        <td> <a href="update.html"> <img src="images/pen.png" alt=""> </a></td>
                        <td> <a href="#"> <img src="images/trash.png" alt=""> </a></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </main>
</body>

</html>