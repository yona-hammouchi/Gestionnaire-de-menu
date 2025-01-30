<?php
include 'includes\db_connection.php';
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
    <link rel="stylesheet" href="styles\style_profil.css">
    <link rel="stylesheet" href="styles\global.css">
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
                        <a href ="index.php"><img src="./assets/img/logo_cook_&_share.png" alt="logo_cook&share" height="100px"></a>
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

        <form action="./insert_plats.php" method="post" enctype="multipart/form-data">

    <label for="titre">Titre du plat :</label> 
    <input type="text" name="titre" id="titre" required>

    <label for="image">Image</label>
    <input type="file"> name="image" id="image">
    
    <label for="description">Description :</label>
    <textarea name="description" id="description" required></textarea>

    <label for="prix">Prix :</label>
    <input type="number" name="prix" id="prix" step="0.01" required>

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

</body>

</html>
<?php

$pdo = new PDO("mysql:host=localhost;dbname=Gestionnaire-de-menu;charset=utf8", "root", "");

$query = "SELECT * FROM plats";
$result = $pdo->query($query);

echo "<table style='border: 1px solid black; border-collapse: collapse; width: 100%;'>";
echo "<thead><tr>";


$columns = array_keys($result->fetch(PDO::FETCH_ASSOC));
foreach ($columns as $column) {
    echo "<th style='border: 1px solid black; padding: 5px;'>$column</th>";
}

echo "</tr></thead><tbody>";


$result->execute();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td style='border: 1px solid black; padding: 5px;'>$value</td>";
    }
    echo "</tr>";
}

echo "</tbody></table>";
?>
