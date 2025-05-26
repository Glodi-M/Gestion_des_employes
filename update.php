<?php
include 'connexion.php';

// Initialiser les variables
$error_message = '';
$success_message = '';
$employee = null;

// Vérifier si l’ID est passé dans l’URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error_message = "ID de l’employé non spécifié.";
} else {
    try {
        // Récupérer les données de l’employé
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT id_employe, nom, prenom, age, date_naissance, email, telephone, adresse FROM employe WHERE id_employe = :id");
        $stmt->execute(['id' => $id]);
        $employee = $stmt->fetch();

        if (!$employee) {
            $error_message = "Aucun employé trouvé avec cet ID.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la récupération des données : " . $e->getMessage();
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupérer les données
        $id = $_POST['id'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $age = $_POST['age'] ?? '';
        $date_naissance = $_POST['date_naissance'] ?? '';
        $email = $_POST['email'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $adresse = $_POST['adresse'] ?? '';


        // Validations
        if (empty($id)) {
            $error_message = "ID de l’employé manquant.";
        } elseif (empty($nom) || empty($prenom) || empty($age) || empty($date_naissance) || empty($email) || empty($telephone) || empty($adresse)) {
            $error_message = "Tous les champs sont obligatoires.";
        } elseif (!preg_match('/^[A-Za-z\s]+$/', $nom) || !preg_match('/^[A-Za-z\s]+$/', $prenom)) {
            $error_message = "Le nom et le prénom ne doivent contenir que des lettres et des espaces.";
        } elseif ($age < 18) {
            $error_message = "L’âge doit être d’au moins 18 ans.";
        } else {
            // Mettre à jour l’employé
            $query = "UPDATE employe SET nom = :nom, prenom = :prenom, age = :age, date_naissance = :date_naissance, email = :email, telephone = :telephone, adresse = :adresse WHERE id_employe = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':age' => (int)$age,
                ':date_naissance' => $date_naissance,
                ':email' => $email,
                ':telephone' => $telephone,
                ':adresse' => $adresse,
                ':id' => $id
            ]);

            $success_message = "Employé modifié avec succès.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un employé</title>
    <link rel="stylesheet" href="../Styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="form-container">
        <a href="index.php" class="back-btn">
            <img src="images/back.png" alt="Retour"> Retour à la liste
        </a>
        <h3>Modifier un employé</h3>

        <?php if ($error_message): ?>
            <div class="alert error">
                <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '<?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            </script>
        <?php endif; ?>

        <?php if ($employee): ?>
            <form method="post" class="employee-form">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($employee['id_employe'],); ?>">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($employee['nom'],); ?>" required>
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($employee['prenom'],); ?>" required>
                <label for="age">Âge</label>
                <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($employee['age'],); ?>" min="18" required>
                <label for="date_naissance">Date de naissance</label>
                <input type="date" name="date_naissance" id="date_naissance" value="<?php echo htmlspecialchars($employee['date_naissance'],); ?>" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($employee['email'],); ?>" required>
                <label for="telephone">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" value="<?php echo htmlspecialchars($employee['telephone'],); ?>">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="<?php echo htmlspecialchars($employee['adresse'],); ?>" required>
                <input type="submit" value="Modifier" class="btn-add">
            </form>
        <?php else: ?>
            <p>Aucun employé à modifier.</p>
        <?php endif; ?>
    </div>
</body>

</html>