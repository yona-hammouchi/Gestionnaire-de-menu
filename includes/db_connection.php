<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'marvin-delansorne_gestionnaire_de_menu'; // Assurez-vous que cette base existe
$username = 'marvin-delansorne'; // Par défaut pour phpMyAdmin
$password = 'K~5q23q4h'; // Mot de passe local (changez-le si nécessaire)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion réussie !';
} catch (PDOException $host) {
    echo 'Une erreur est survenue : ' . $host->getMessage();
}
