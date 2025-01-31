<?php
require_once 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont remplis
    if (empty($_POST['titre']) || empty($_POST['prix']) || empty($_POST['id_categorie'])) {
        echo "Erreur : les champs Titre, Prix et Catégorie sont obligatoires.";
    } else {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $imageUrl = $_POST['image_url']; // Récupérer l'URL de l'image
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $id_categorie = $_POST['id_categorie'];

        $image_path = './assets/uploads';

        try {
            // Préparer la requête SQL pour l'insertion dans la base de données
            $sql = "INSERT INTO plats (titre, image_url, description, prix, id_categorie) VALUES (:titre, :image_url, :description, :prix, :id_categorie)";
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête préparée
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':image_url', $image_url); // Utiliser l'URL de l'image
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':id_categorie', $id_categorie);
            // Exécuter la requête
            $stmt->execute();
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
