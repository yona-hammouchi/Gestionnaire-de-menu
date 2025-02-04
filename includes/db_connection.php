<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'gestionnaire_de_menu'; // Assurez-vous que cette base existe
$username = 'root'; // Par défaut pour phpMyAdmin
$password = 'root'; // Mot de passe local (changez-le si nécessaire)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion réussie !';
} catch (PDOException $host) {
    echo 'Une erreur est survenue : ' . $host->getMessage();
}

// Récupérer les plats
$plats = $pdo->query("
    SELECT plats.*, Categories.Nom as categorie_nom 
    FROM plats 
    INNER JOIN Categories ON plats.id_categorie = Categories.id 
    ORDER BY 
        FIELD(Categories.Nom, 'Entrée', 'Plat', 'Dessert'), 
        plats.titre
")->fetchAll();

// FICHIER PROFILE POUR AJOUTER LES ACTIONS : SUPPRIMER ET AJOUTER


if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);
} else {
    $username = 'Invité';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont remplis
    if (!empty($_POST['action']) && $_POST['action'] == 'delete' && !empty($_POST['plat_id'])) {
        $plat_id = $_POST['plat_id'];

        try {
            // Supprimer le plat
            $sql = "DELETE FROM plats WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $plat_id);
            $stmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}

// Récupérer les plats
$plats = $pdo->query("
    SELECT plats.*, Categories.Nom as categorie_nom 
    FROM plats 
    INNER JOIN Categories ON plats.id_categorie = Categories.id 
    ORDER BY 
        FIELD(Categories.Nom, 'Entrée', 'Plat', 'Dessert'), 
        plats.titre
")->fetchAll();
