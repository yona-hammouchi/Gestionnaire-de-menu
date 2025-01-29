<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'Gestionnaire-de-menu'; // Assurez-vous que cette base existe
$username = 'root'; // Par défaut pour phpMyAdmin
$password = 'root'; // Mot de passe local (changez-le si nécessaire)

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.<br>";

    // Commande SQL pour créer la table `users`
    $sql_users = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";

    // Exécution de la commande SQL pour `users`
    $pdo->exec($sql_users);
    // echo "Table `users` créée avec succès (si elle n'existait pas déjà).<br>";
} catch (PDOException $e) {
    // Gestion des erreurs de connexion ou d'exécution SQL
    die("Erreur : " . $e->getMessage());
}
