<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="form">
        <a href="index.php" class="back-btn"> <img src="images/back.png" alt=""> Retour</a>
        <h1>Ajouter un Employé : </h1>
        <p class="erreur_message">
            Veillez remplir tous les champs !
        </p>

        <form action="" method="post">
            <label for="">Nom</label>
            <input type="text" name="nom" id="" placeholder="Nom de l'employé" required>
            <label for="">Prénom</label>
            <input type="text" name="prenom" id="" placeholder="Prénom de l'employé" required>
            <label for="">Age</label>
            <input type="number" name="age" id="" placeholder="Age de l'employé" required>
            <input type="submit" value="Ajouter" class="btn-add">

        </form>

    </div>
</body>

</html>