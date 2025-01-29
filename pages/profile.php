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
    <title>Profile</title>
</head>

<body>
    <header>
        <nav>
            <ul class="navbar">
                <li>
                    <div class="logo_acceuil">
                        <img src="./assets/img/logo_cook_&_share.png" alt="logo" height="100px">
                    </div>
                </li>
                <li>
                    <div class="logo_navbar">
                        <a href="./pages/inscription.php"><img src="./assets/img/logo_profile.png" alt="logo_profile"></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>

        <head>
            <h1>Bonjour, <?php echo $username; ?>!</h1>
            <title>Ajouter un plat</title>
        </head>

        <body>
            <h2>Ajouter un plat</h2>
            <form action="/Gestionnaire-de-menu/pages/insert_plats.php" method="post" enctype="multipart/form-data">
                <label for="titre">Nom de votre plat:</label>
                <input type="text" id="titre" name="titre" required><br>
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea><br>
                <label for="prix">Prix:</label>
                <input type="number" id="prix" name="prix" required><br>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image"><br>
                <input type="submit" name="action" value="Ajouter">
                <input type="submit" name="action" value="Valider">
                <input type="submit" name="action" value="Supprimer">
                <input type="submit" name="action" value="Modifier">
            </form>

        </body>

</html>
</main>
</body>

</html>