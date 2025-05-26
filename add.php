<?php
include 'connexion.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et validation des données
    $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
    $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
    $age = filter_input(
        INPUT_POST,
        'age',
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 18, 'max_range' => 70]]
    );

    // Validation des champs
    if (empty($nom) || empty($prenom) || $age === false) {
        $error_message = 'Veuillez remplir tous les champs correctement (âge entre 18 et 70 ans)';
    } else {
        try {
            $query = "INSERT INTO employe (nom, prenom, age) VALUES (:nom, :prenom, :age)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $success_message = 'Employé ajouté avec succès!';
                // Réinitialisation des champs après succès
                $_POST = array();
            }
        } catch (PDOException $e) {
            $error_message = 'Erreur lors de l\'ajout : ' . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Employé</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-container">
        <a href="index.php" class="back-btn">
            <img src="images/back.png" alt="Retour"> Retour à la liste
        </a>

        <h3>Ajouter un Employé</h3>

        <?php if ($error_message): ?>
            <div class="alert error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form method="post" class="employee-form">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom"
                    value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>"
                    placeholder="Nom de l'employé" required
                    minlength="2" maxlength="50">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom"
                    value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>"
                    placeholder="Prénom de l'employé" required
                    minlength="2" maxlength="50">
            </div>

            <div class="form-group">
                <label for="age">Âge *</label>
                <input type="number" name="age" id="age"
                    value="<?php echo htmlspecialchars($_POST['age'] ?? ''); ?>"
                    placeholder="Âge de l'employé" required
                    min="18" max="70">
                <small class="form-hint">Entre 18 et 70 ans</small>
            </div>

            <button type="submit" class="btn-submit">
                Ajouter l'employé
            </button>
        </form>
    </div>
</body>

</html>