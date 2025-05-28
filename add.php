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
    $date_naissance = trim(htmlspecialchars($_POST['date_naissance'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
    $adresse = trim(htmlspecialchars($_POST['adresse'] ?? ''));

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($date_naissance) || empty($email) || empty($adresse) || $age === false) {
        $error_message = 'Veuillez remplir tous les champs correctement (âge entre 18 et 70 ans)';
    } else {
        try {
            // Préparation de la requête d'insertion
            $query = "INSERT INTO employe (nom, prenom, age, date_naissance,email,telephone,adresse) VALUES (:nom, :prenom, :age, :date_naissance, :email, :telephone, :adresse)";
            $stmt = $pdo->prepare($query);
            // Liaison des paramètres
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            // Exécution de la requête

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
    <link rel="stylesheet" href="../Styles/style.css">
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
            <li><a href="logout.php" class="nav-link">Déconnexion</a></li>
    </nav>

    <!-- Formulaire d'ajout d'employé -->
    <div class="form-container">
        <a href="services.php" class="back-btn">
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
                <label for="nom">Nom <span class="obli">*</span></label>
                <input type="text" name="nom" id="nom"
                    value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>"
                    placeholder="Nom de l'employé" required
                    minlength="2" maxlength="50">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom <span class="obli">*</span></label>
                <input type="text" name="prenom" id="prenom"
                    value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>"
                    placeholder="Prénom de l'employé" required
                    minlength="2" maxlength="50">
            </div>

            <div class="form-group">
                <label for="age">Âge <span class="obli">*</span></label>
                <input type="number" name="age" id="age"
                    value="<?php echo htmlspecialchars($_POST['age'] ?? ''); ?>"
                    placeholder="Âge de l'employé" required
                    min="18" max="70">
                <small class="form-hint">Entre 18 et 70 ans</small>
            </div>
            <div class="form-group">
                <label for="date_naissance">Date de Naissance <span class="obli">*</span></label>
                <input type="date" name="date_naissance" id="date_naissance"
                    value="<?php echo htmlspecialchars($_POST['date_naissance'] ?? ''); ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email <span class="obli">*</span></label>
                <input type="email" name="email" id="email"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    placeholder="Email de l'employé" required
                    minlength="5" maxlength="100">
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone </label>
                <input type="tel" name="telephone" id="telephone"
                    value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>"
                    placeholder="Téléphone de l'employé"
                    pattern="[0-9]{10}" title="10 chiffres requis">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse <span class="obli">*</span></label>
                <input type="text" name="adresse" id="adresse"
                    value="<?php echo htmlspecialchars($_POST['adresse'] ?? ''); ?>"
                    placeholder="Adresse de l'employé" required
                    minlength="5" maxlength="100">
            </div>


            <button type="submit" class="btn-submit">
                Ajouter l'employé
            </button>
        </form>
    </div>
</body>

</html>