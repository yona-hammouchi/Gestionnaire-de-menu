<?php
require_once 'includes/db_connection.php';

if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);
} else {
    $username = 'Invité';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont remplis
    if (empty($_POST['titre']) || empty($_POST['prix'])) {
        echo "Erreur : les champs Titre du plat et prix sont obligatoires.";
    } else {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $id_categorie = $_POST['id_categorie'];

        try {
            // Préparer la requête SQL pour l'insertion dans la base de données
            $sql = "INSERT INTO plats (titre, description, prix, id_categorie) VALUES (:titre, :description, :prix, :id_categorie)";
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête préparée
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':id_categorie', $id_categorie);

            // Suppression d'un plat
            if (isset($_POST['delete_id'])) {
                $plat_id = $_POST['delete_id'];

                try {
                    // Préparer la requête pour supprimer le plat
                    $sql = "DELETE FROM plats WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $plat_id);
                    $stmt->execute();

                    // Rediriger après la suppression
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }

            // Exécuter la requête
            $stmt->execute();
        } catch (PDOException $host) {
            echo "Erreur : " . $host->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/style_profil.css">
    <title>Cook & Share</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <ul class="navbar">
                <li>
                    <div class="logo_acceuil">
                        <a href="index.php"><img src="./assets/img/logo_cook_&_share.png" alt="logo_cook&share" height="100px"></a>
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
        <h1>Bonjour, <?php echo $username; ?>!</h1>

        <h2>Ajoutez votre touche personnelle en créant un nouveau plat !</h2>
        <div>
            <!-- Formulaire d'ajout de plat -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <label for="titre">Titre du plat :</label>
                <input type="text" name="titre" id="titre" required>
                <label for="description">Description : ingredients</label>
                <textarea name="description" id="description" required></textarea>
                <label for="prix">Prix :</label>
                <input type="number" name="prix" id="prix" step="0.01" required>
                <label for="categorie">Catégorie :</label>
                <select name="id_categorie" id="id_categorie" required>
                    <?php
                    $Categories = $pdo->query("SELECT * FROM Categories")->fetchAll();
                    foreach ($Categories as $Categorie) {
                        echo "<option value='{$Categorie['id']}'>{$Categorie['Nom']}</option>";
                    }
                    ?>
                </select>
                <button type="submit">Ajouter le plat</button>
            </form>

            <h2>Assemblez un menu unique en sélectionnant vos plats préférés !</h2>

            <button onclick="window.location.href='creation_menu.php'">Créer votre menu</button>

            <br>

            <!-- Affichage des plats -->
            <h2>Liste des plats</h2>
            <ul>
                <?php
                // Récupérer et afficher tous les plats
                $stmt = $pdo->query("SELECT * FROM plats");
                $plats = $stmt->fetchAll();
                foreach ($plats as $plat) {
                    echo "<li>" . htmlspecialchars($plat['titre']) . " - " . htmlspecialchars($plat['description']) . " - " . htmlspecialchars($plat['prix']) . "€</li>";
                }
                ?>
            </ul>
        </div>

    </main>
    <footer>
        <section class="footer">
            <div>
                <p>
                    Contact
                </p>
            </div>
            <div>
                Connexion
            </div>
            <div>
                11 rue du Panier <br>
                13002 Marseille
            </div>
        </section>
    </footer>
</body>