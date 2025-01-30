<?php
session_start();
require_once 'includes/db_connection.php';

if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);
} else {
    $username = 'Invité';
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
        <h1>Bonjour, <?php echo $username; ?>!</h1>

        <h2>Envie d'un Nouveau Menu ?</h2>
        <h3>Créer votre recette</h3>

        <form action="insert_plats.php" method="POST" enctype="multipart/form-data">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description" required></textarea>

            <label for="image_url">URL de l'image :</label>
            <input type="url" name="image_url" required><br>

            <label for="prix">Prix :</label>
            <input type="number" step="0.01" name="prix" id="prix" required>

            <label for="categorie">Catégorie :</label>
            <select name="id_categorie" id="categorie" required>
                <?php
                try {
                    $categories = $pdo->query("SELECT * FROM Categories")->fetchAll();
                    foreach ($categories as $categorie) {
                        echo "<option value='{$categorie['id']}'>{$categorie['nom']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
                ?>
            </select>
            <button type="submit">Ajouter le plat</button>
        </form>
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

</html>