<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'Gestionnaire-de-menu'; // Assurez-vous que cette base existe
$username = 'root'; // Par défaut pour phpMyAdmin
$password = ''; // Mot de passe local (changez-le si nécessaire)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $host) {
    echo 'Une erreur est survenue : ' . $host->getMessage();
}
    // Connexion à la base de données avec PDO
