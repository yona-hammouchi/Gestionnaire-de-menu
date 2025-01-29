<?php
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez que les champs de formulaire existent et ne sont pas vides
    $nom_plat = isset($_POST['nom_plat']) ? $pdo->quote($_POST['nom_plat']) : null;
    $description = isset($_POST['description']) ? $pdo->quote($_POST['description']) : null;
    $prix = isset($_POST['prix']) ? $pdo->quote($_POST['prix']) : null;
    $action = $_POST['action'];

    // Vérifiez que les champs obligatoires ne sont pas null
    if ($nom_plat === null || $prix === null) {
        die("Erreur : Les champs 'Nom de votre plat' et 'Prix' sont obligatoires.");
    }

    switch ($action) {
        case 'Ajouter':
            $sql = "INSERT INTO plats (nom_plat, description, prix) VALUES ($nom_plat, $description, $prix)";
            break;
        case 'Valider':
            // Code pour valider une recette (à définir selon les besoins)
            break;
        case 'Supprimer':
            $sql = "DELETE FROM plats WHERE nom_plat=$nom_plat";
            break;
        case 'Modifier':
            $sql = "UPDATE plats SET description=$description, prix=$prix WHERE nom_plat=$nom_plat";
            break;
        default:
            echo "Action non reconnue.";
            exit();
    }

    try {
        $pdo->exec($sql);
        echo "Action '$action' réalisée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur: " . $sql . "<br>" . $e->getMessage();
    }
}
