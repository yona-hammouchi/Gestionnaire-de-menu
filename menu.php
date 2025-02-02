<?php
include 'includes/db_connection.php';
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

// Récupérer les plats des catégories disponibles

$stmt = $pdo->query("SELECT id, titre, categorie_id FROM plats");
$plats = $stmt->fetchAll();

// Récupérer les catégories pour afficher la sélection
$categories_stmt = $pdo->query("SELECT id, nom FROM categorie");
$categories = $categories_stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['menu'])) {
    // Récupérer les plats sélectionnés
    $selected_plats = $_POST['plats']; // Un tableau d'ID de plats

    // Insérer le menu dans la base de données (exemple de table `menus`)
    try {
        // Créer un menu
        $sql = "INSERT INTO menu (user_id, nom) VALUES (:user_id, :nom_menu)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $_COOKIE['user_id']);
        $stmt->bindParam(':nom_menu', $_POST['nom_menu']);
        // Récupérer l'ID du dernier menu créé
        $menu_id = $pdo->lastInsertId();
        // Associer les plats sélectionnés au menu

        foreach ($selected_plats as $plat_id) {
            $sql = "INSERT INTO menu_plats (menu_id, plat_id) VALUES (:menu_id, :plat_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':menu_id', $menu_id);
            $stmt->bindParam(':plat_id', $plat_id);
            $stmt->execute();
        }

        echo "Menu créé avec succès !";
    } catch (PDOException $host) {
        echo "Erreur : " . $host->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="styles\global.css">
    <title>Cook & Share</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
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
                        <a href="inscription.php"><img src="assets/img/logo_profile.png" alt="logo_profile"></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>


    <main>
        <h1>Bonjour, <?php echo $username; ?> !</h1>

        <h2>Créez une expérience culinaire sur mesure et partagez-la avec vos invités."</h2>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <!-- Champ pour le nom du menu -->
            <label for="nom_menu">Nom de votre menu :</label>
            <input type="text" name="nom_menu" id="nom_menu" required>

            <h3>Choisissez vos plats :</h3>
            <div class="categories">
                <?php
                // Afficher les plats par catégorie
                foreach ($categories as $categorie) {
                    echo "<h4>" . htmlspecialchars($categorie['nom']) . "</h4>";

                    foreach ($plats as $plat) {
                        // Filtrer les plats par catégorie
                        if ($plat['categorie_id'] == $categorie['id']) {
                            echo "<label><input type='checkbox' name='plats[]' value='" . $plat['id'] . "'> " . htmlspecialchars($plat['titre']) . "</label><br>";
                        }
                    }
                }
                ?>
            </div>

            <button type="submit" name="menu">Créer le menu</button>
        </form>
    </main>
    <footer>
        <section class="footer">
            <div>
                <p>Contact</p>
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