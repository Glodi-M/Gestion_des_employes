<?php

include 'connexion.php';

try {
    // Vérifier si l'ID est défini dans l'URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Erreur : ID non spécifié.");
    }

    $id = (int)$_GET['id'];
    $req = $pdo->prepare("DELETE FROM employe WHERE id_employe = :id");
    $req->execute(['id' => $id]);

    // Vérifier si la suppression a réussi
    if ($req->rowCount() > 0) {
        // Rediriger avec un paramètre de succès
        header("Location: index.php?success=Employé supprimé avec succès");
    } else {
        header("Location: index.php?error=Aucun employé trouvé avec cet ID");
    }
    exit();
} catch (PDOException $e) {
    header("Location: index.php?error=" . urlencode("Erreur lors de la suppression : " . $e->getMessage()));
    exit();
} catch (PDOException $e) {

    die("Erreur lors de la suppression : " . $e->getMessage());
}
