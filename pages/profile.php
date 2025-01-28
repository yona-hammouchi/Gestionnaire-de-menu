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
                        <img src="./img/logo_cook_&_share.png" alt="logo_cook&share" height="100px">
                    </div>
                </li>
                <li>
                    <div class="logo_navbar">
                        <img src="./img/logo profile.png" alt="logo_profile">
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Bonjour, <?php echo $username; ?>!</h1>
        <section class="produit">
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
        </section>
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