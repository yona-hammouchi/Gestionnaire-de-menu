<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'Gestionnaire-de-menu'; // Assurez-vous que cette base existe
$username = 'root'; // Par défaut pour phpMyAdmin
$password = 'root'; // Mot de passe local (changez-le si nécessaire)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion réussie !';
} catch (PDOException $host) {
    echo 'Une erreur est survenue : ' . $host->getMessage();
}

$uploadDir = __DIR__ . "/../assets/image_recettes/"; // Chemin correct
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Crée le dossier si nécessaire
}
// Dossier de téléchargement des images 
$imagePath = NULL;
if (!empty($_FILES["image"]["name"])) {
    $imageName = time() . '_' . basename($_FILES["image"]["name"]);
    $imagePath = "assets/image_recettes/" . $imageName; // Chemin relatif

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir . $imageName)) {
        die("Erreur : Impossible d'uploader l'image.");
    }
}
