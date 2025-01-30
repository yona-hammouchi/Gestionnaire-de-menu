<?php
require_once 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont remplis
    if (empty($_POST['titre']) || empty($_POST['prix']) || empty($_POST['id_categorie'])) {
        echo "Erreur : les champs Titre, Prix et Catégorie sont obligatoires.";
    } else {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $id_categorie = $_POST['id_categorie'];
        $imageUrl = $_POST['image_url']; // Récupérer l'URL de l'image

        // Fonction pour valider l'URL de l'image
        function validateImageUrl($url)
        {
            // Vérifier si l'URL commence bien par "http://" ou "https://"
            if (filter_var($url, FILTER_VALIDATE_URL) && (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0)) {
                return true;
            }
            return false;
        }

        // Valider l'URL de l'image
        if (validateImageUrl($imageUrl)) {
            // Insérer les données dans la base de données
            $stmt = $pdo->prepare("INSERT INTO plats (titre, description, prix, id_categorie, image_url) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$titre, $description, $prix, $id_categorie, $imageUrl])) {
                echo "Données et image enregistrées avec succès !";
            } else {
                echo "Erreur lors de l'enregistrement dans la base de données.";
            }
        } else {
            echo "URL d'image invalide.";
        }

        try {
            // Préparer la requête SQL pour l'insertion dans la base de données
            $sql = "INSERT INTO plats (titre, description, prix, image_url, id_categorie) VALUES (:titre, :description, :prix, :image_url, :id_categorie)";
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête préparée
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':image_url', $image_url); // Utiliser l'URL de l'image
            $stmt->bindParam(':id_categorie', $id_categorie);

            // Exécuter la requête
            $stmt->execute();

            // Rediriger vers la même page pour afficher les données
            header("Location: insert_plats.php?success=1&titre=" . urlencode($titre) . "&description=" . urlencode($description) . "&prix=" . urlencode($prix) . "&id_categorie=" . urlencode($id_categorie) . "&image_url=" . urlencode($imageUrl));
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/global.css">
    <title>Cook & Share</title>
</head>

<body>
    <header>
        <nav>
            <ul class="navbar">
                <li>
                    <div class="logo_acceuil">
                        <a href="index.php"><img src="assets/img/logo_cook_&_share.png" alt="logo_cook&share" height="100px"></a>
                    </div>
                </li>
                <li>
                    <div class="logo_navbar">
                        <a href="profile.php"><img src="assets/img/logo_profile.png" alt="logo_profile"></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <?php var_dump($_GET); ?> <!-- Debugging -->

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <h1>Le plat a été ajouté avec succès !</h1>
            <p><strong>Titre :</strong> <?php echo htmlspecialchars($_GET['titre']); ?></p>
            <p><strong>Description :</strong> <?php echo htmlspecialchars($_GET['description']); ?></p>
            <p><strong>Prix :</strong> <?php echo htmlspecialchars($_GET['prix']); ?></p>
            <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($_GET['id_categorie']); ?></p>

            <?php if (isset($_GET['image_url']) && !empty($_GET['image_url'])): ?>
                <p><strong>Image :</strong></p>
                <img src="<?php echo htmlspecialchars($_GET['image_url']); ?>" alt="Image du plat" style="max-width: 300px;">
            <?php else: ?>
                <p><strong>Erreur :</strong> L'URL de l'image est vide.</p>
            <?php endif; ?>

        <?php else: ?>
            <h1>Erreur lors de l'ajout du plat.</h1>
        <?php endif; ?>
    </main>

</body>

</html>