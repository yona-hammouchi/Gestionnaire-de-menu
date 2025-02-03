<?php
include 'includes/db_connection.php';
session_start();
session_start();

if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);
} else {
    $username = 'Invité';
}

// Récupérer les plats des catégories disponibles
$stmt = $pdo->query("SELECT id, titre, id_categorie FROM plats");
$plats = $stmt->fetchAll();

// Récupérer les catégories pour afficher la sélection
$categories_stmt = $pdo->query("SELECT id, nom FROM categories");
$categories = $categories_stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['menu'])) {
    // Récupérer les plats sélectionnés
    $selected_plats = $_POST['plats'] ?? []; // Si vide, tableau vide

    // Vérifier qu'un nom de menu est bien renseigné
    if (empty($_POST['nom_menu']) || empty($selected_plats)) {
        die("Erreur : Veuillez entrer un nom de menu et sélectionner au moins un plat.");
    }

    try {
        // Récupérer l'utilisateur connecté
        $id_user = isset($_COOKIE['id_user']) ? (int) $_COOKIE['id_user'] : null;

        if ($id_user === null) {
            die("Erreur : Utilisateur non connecté.");
        }

        // Insérer le menu dans la base de données
        $sql = "INSERT INTO menu (id_user, nom_menu) VALUES (:id_user, :nom_menu)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':nom_menu', $_POST['nom_menu']);
        $stmt->execute();

        // Récupérer l'ID du menu nouvellement créé
        $menu_id = $pdo->lastInsertId();

        // Insérer les plats sélectionnés dans une table de liaison (exemple : menu_plats)
        $sql = "INSERT INTO menu_plats (menu_id, plat_id) VALUES (:menu_id, :plat_id)";
        $stmt = $pdo->prepare($sql);

        foreach ($selected_plats as $plat_id) {
            $stmt->bindParam(':menu_id', $menu_id);
            $stmt->bindParam(':plat_id', $plat_id);
            $stmt->execute();
        }

        echo "Menu créé avec succès !";
    } catch (PDOException $e) {
        echo "Erreur lors de la création du menu : " . $e->getMessage();
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
                        if ($plat['id_categorie'] == $categorie['id']) {
                            echo "<label><input type='checkbox' name='plats[]' value='" . $plat['id'] . "'> " . htmlspecialchars($plat['titre']) . "</label><br>";
                        }
                    }
                }
                ?>
            </div>

            <button onclick="window.location.href='./menu.php';">Créer votre menu</button>
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