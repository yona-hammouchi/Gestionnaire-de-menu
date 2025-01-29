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

    // Commande SQL pour créer la table `plats`
    $sql_plats = "
        CREATE TABLE IF NOT EXISTS plats (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titre VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            image VARCHAR(255),
            prix DECIMAL(10,2) NOT NULL
        )
    ";

    // Exécution des commandes SQL
    $pdo->exec($sql_users);
    $pdo->exec($sql_plats);

    echo "Tables `users` et `plats` créées avec succès (si elles n'existaient pas déjà).<br>";
} catch (PDOException $e) {
    // Gestion des erreurs de connexion ou d'exécution SQL
    die("Erreur : " . $e->getMessage());
}
