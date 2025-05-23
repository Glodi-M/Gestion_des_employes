<?php
// paramètres de connexion à la base de données
$dbhost = 'localhost';
$dbname = 'ge-employes';
$dbusername = 'root';
$dbpassword = '';

// connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    // définir le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
