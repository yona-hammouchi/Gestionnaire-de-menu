<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=Gestionnaire-de-menu;charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    // Dossier d'enregistrement des images
    $uploadDir = __DIR__ . "/../assets/image_recettes/"; // Chemin correct
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Crée le dossier si nécessaire
    }

    // Gestion de l'upload de l'image
    $imagePath = NULL;
    if (!empty($_FILES["image"]["name"])) {
        $imageName = time() . '_' . basename($_FILES["image"]["name"]);
        $imagePath = "assets/image_recettes/" . $imageName; // Chemin relatif

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir . $imageName)) {
            die("Erreur : Impossible d'uploader l'image.");
        }
    }

    // Requête SQL
    $sql = "INSERT INTO plats (titre, description, image, prix) VALUES (:titre, :description, :image, :prix)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':image' => $imagePath,
        ':prix' => $prix
    ]);

    echo "Plat ajouté avec succès !";
}
