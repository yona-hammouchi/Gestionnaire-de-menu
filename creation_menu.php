<?php
include 'includes/db_connection.php';

// Récupérer les plats et catégories depuis la base de données
$stmt = $pdo->query("SELECT id, titre, id_categorie FROM plats");
$plats = $stmt->fetchAll();

$categories_stmt = $pdo->query("SELECT id, nom FROM categories");
$categories = $categories_stmt->fetchAll();

// Traitement du formulaire (création du menu)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['menu'])) {
    $selected_plats = $_POST['plats'] ?? [];
    $nom_menu = $_POST['nom_menu'] ?? '';

    // Vérification des champs
    if (empty($nom_menu) || empty($selected_plats)) {
        die("Erreur : Veuillez entrer un nom de menu et sélectionner au moins un plat.");
    }

    try {
        // Insérer le menu dans la table menus sans utilisateur
        $sql = "INSERT INTO menus (nom_menu) VALUES (:nom_menu)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom_menu', $nom_menu);
        $stmt->execute();

        // Récupérer l'ID du menu nouvellement créé
        $menu_id = $pdo->lastInsertId();

        // Insérer les plats sélectionnés dans la table de liaison menu_plats
        $sql = "INSERT INTO menu_plats (menu_id, plat_id) VALUES (:menu_id, :plat_id)";
        $stmt = $pdo->prepare($sql);

        foreach ($selected_plats as $plat_id) {
            $stmt->bindParam(':menu_id', $menu_id);
            $stmt->bindParam(':plat_id', $plat_id);
            $stmt->execute();
        }

        // Message de succès
        echo "Menu créé avec succès !";
        echo "<br><a href='menu.php?menu_id=$menu_id'>Voir votre menu</a>";
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
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/creation_menu.css">
    <title>Cook & Share</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <nav>
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
        </nav>
    </header>

    <main>
        <h1>Créez un menu personnalisé :</h1>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <!-- Nom du menu -->
            <label for="nom_menu">Nom de votre menu :</label>
            <input type="text" name="nom_menu" id="nom_menu" required>

            <h3>Choisissez vos plats :</h3>
            <div class="categories">
                <?php
                // Afficher les plats par catégorie
                foreach ($categories as $categorie) {
                    echo "<h4>" . htmlspecialchars($categorie['nom']) . "</h4>";

                    foreach ($plats as $plat) {
                        if ($plat['id_categorie'] == $categorie['id']) {
                            echo "<label><input type='checkbox' name='plats[]' value='" . $plat['id'] . "'> " . htmlspecialchars($plat['titre']) . "</label><br>";
                        }
                    }
                }
                ?>
            </div>
            <button type="submit" name="menu">Créer votre menu</button>
        </form>

        <h2>Liste des menus existants :</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom du menu</th>
                    <th>Plats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer les menus et leurs plats associés
                $menus_stmt = $pdo->query("
            SELECT menus.id AS menu_id, menus.nom_menu, GROUP_CONCAT(plats.titre SEPARATOR ', ') AS plats
            FROM menus
            LEFT JOIN menu_plats ON menus.id = menu_plats.menu_id
            LEFT JOIN plats ON menu_plats.plat_id = plats.id
            GROUP BY menus.id
        ");
                $menus = $menus_stmt->fetchAll();

                foreach ($menus as $menu) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($menu['nom_menu']) . "</td>";
                    echo "<td>" . htmlspecialchars($menu['plats']) . "</td>";
                    echo "<td>
                <a href='modifier_menu.php?menu_id=" . $menu['menu_id'] . "'>Modifier</a> 
                <form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post' style='display:inline;'>
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='menu_id' value='" . $menu['menu_id'] . "'>
                    <button type='submit' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce menu ?');\">Supprimer</button>
                </form>
            </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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