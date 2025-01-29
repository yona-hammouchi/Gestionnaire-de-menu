<?php

session_start();

if (isset($_COOKIE['user_id'])) {
    if (basename($_SERVER['PHP_SELF']) !== 'profile.php') {
        header('Location: /Gestionnaire-de-menu/pages/profile.php');
        exit();
    }
} else {
    die("Accès non autorisé. Veuillez vous connecter.");
}

$username = isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : 'Invité';
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./global.css">
    <link rel="stylesheet" href="style2.css">
    <title>Cook & Share</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Profil</title>
</head>

<body>
    <header>
        <nav>
            <ul class="navbar">
                <li>
                    <div class="logo_acceuil">
                        <img src="./assets/img/logo_cook_&_share.png" alt="logo_cook&share" height="100px">
                    </div>
                </li>
                <li>
                    <div class="logo_navbar">
                        <a href="./pages/inscription.php"><img src="./assets/img/logo profile.png" alt="logo_profile"></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Bonjour, <?php echo $username; ?>!</h1>

        <form action="/Gestionnaire-de-menu/pages/insert_plats.php" method="post">
            <label for="nom_plats">Nom de votre plat:</label>
            <input type="text" id="nom_plats" name="nom_plats" required><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea><br>
            <label for="prix">Prix:</label>
            <input type="text" id="prix" name="prix" required><br>
            <input type="submit" name="action" value="Ajouter">
            <input type="submit" name="action" value="Valider">
            <input type="submit" name="action" value="Supprimer">
            <input type="submit" name="action" value="Modifier">
        </form>
    </main>
</body>

</html>

<!-- <section class="produit">
            <img src="./img/photo_recette1.png" alt="photo_recette1" width="100" height="100">
            <div class="ajouter">
                <input type="text" placeholder="Nom de la recette">
            </div>
            <div class="ajouter">
                <input type="button" value="Créer">
            </div>
            <div class="ajouter">
                <input type="button" value="Modifier">
            </div>
            <div class="ajouter">
                <input type="button" value="Valider">
            </div>
        </section> -->
</body>

</html>