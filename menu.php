<?php
include 'includes/db_connection.php';

// Vérifier que l'ID du menu est présent dans l'URL
if (isset($_GET['menu_id'])) {
    $menu_id = $_GET['menu_id'];

    // Récupérer le nom du menu
    $stmt = $pdo->prepare("SELECT nom_menu FROM menus WHERE id = :menu_id");
    $stmt->bindParam(':menu_id', $menu_id);
    $stmt->execute();
    $menu = $stmt->fetch();

    if ($menu) {
        echo "<h1>" . htmlspecialchars($menu['nom_menu']) . "</h1>";

        // Récupérer les plats associés à ce menu
        $stmt = $pdo->prepare("SELECT plats.titre, plats.description, plats.prix 
                               FROM plats 
                               JOIN menu_plats ON plats.id = menu_plats.plat_id 
                               WHERE menu_plats.menu_id = :menu_id");
        $stmt->bindParam(':menu_id', $menu_id);
        $stmt->execute();
        $plats = $stmt->fetchAll();

        if ($plats) {
            echo "<ul>";
            foreach ($plats as $plat) {
                echo "<li><strong>" . htmlspecialchars($plat['titre']) . "</strong><br>";
                echo "Description: " . htmlspecialchars($plat['description']) . "<br>";
                echo "Prix: " . htmlspecialchars($plat['prix']) . "€</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun plat associé à ce menu.</p>";
        }
    } else {
        echo "<p>Menu non trouvé.</p>";
    }
} else {
    echo "<p>ID du menu non spécifié.</p>";
}
?>

<?php
include 'includes/db_connection.php';

// Récupérer tous les menus avec leurs plats associés
$stmt = $pdo->query("SELECT menus.id AS menu_id, menus.nom_menu, plats.titre AS plat_titre
                     FROM menus
                     LEFT JOIN menu_plats ON menus.id = menu_plats.menu_id
                     LEFT JOIN plats ON menu_plats.plat_id = plats.id
                     ORDER BY menus.id, plats.id");

$menus = [];
while ($row = $stmt->fetch()) {
    // Organiser les menus et plats dans un tableau associatif
    $menus[$row['menu_id']]['nom_menu'] = $row['nom_menu'];
    if ($row['plat_titre']) {
        $menus[$row['menu_id']]['plats'][] = $row['plat_titre'];
    }
}

// Affichage des menus et des plats
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/menu.css">

    <title>Cook & Share</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <main>
        <h1>Liste des menus créés</h1>

        <?php
        if ($menus) {
            // Afficher chaque menu et ses plats associés
            foreach ($menus as $menu_id => $menu) {
                echo "<h2>" . htmlspecialchars($menu['nom_menu']) . "</h2>";
                if (!empty($menu['plats'])) {
                    echo "<ul>";
                    foreach ($menu['plats'] as $plat) {
                        echo "<li>" . htmlspecialchars($plat) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun plat associé à ce menu.</p>";
                }
            }
        } else {
            echo "<p>Aucun menu n'a encore été créé.</p>";
        }
        ?>
    </main>

    <footer>
    <section class="footer">
            <div>
                <p>
                    Contact
                </p>
                 </div>
               <div>
                        <a href="index.php"><img src="./assets/img/logo_cook_&_share.png" alt="logo_cook&share" height="50px"></a>  
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
