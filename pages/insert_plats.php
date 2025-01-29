<?php
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont remplis
    if (empty($_POST['titre']) || empty($_POST['prix'])) {
        echo "Erreur : les champs Titre du plat et prix sont obligatoires.";
    } else {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];

        try {
            // Préparer la requête SQL pour l'insertion dans la base de données
            $sql = "INSERT INTO plats (titre, description, prix) VALUES (:titre, :description, :prix)";
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête préparée
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);

            // Exécuter la requête
            $stmt->execute();

            echo "Le plat a été ajouté avec succès !";
        } catch (PDOException $host) {
            echo "Erreur : " . $host->getMessage();
        }
    }
}
?>