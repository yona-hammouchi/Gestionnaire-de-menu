<?php
require_once '../includes/db_connection.php';

if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);
} else {
    $username = 'Invité';
}

// Suppression d'un plat
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $plat_id = $_GET['id'];

    try {
        $sql = "DELETE FROM plats WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $plat_id);
        $stmt->execute();

        // Redirection pour éviter répétition de l'action
        header("Location: ../pages/profile.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
}

// Ajout d'un plat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['titre']) || empty($_POST['prix'])) {
        echo "Erreur : les champs Titre du plat et prix sont obligatoires.";
    } else {
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $id_categorie = $_POST['id_categorie'];

        try {
            $sql = "INSERT INTO plats (titre, description, prix, id_categorie) VALUES (:titre, :description, :prix, :id_categorie)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':id_categorie', $id_categorie);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}

$plats = $pdo->query("SELECT plats.*, Categories.Nom as categorie_nom FROM plats 
                      INNER JOIN Categories ON plats.id_categorie = Categories.id 
                      ORDER BY Categories.Nom")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style_connexion.css">
    <link rel="stylesheet" href="../styles/global.css">
    <title>Cook & Share</title>
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
                        <a href="./pages/inscription.php"><img src="assets/img/logo_profile.png" alt="logo_profile"></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Bonjour, <?php echo $username; ?>!</h1>
        <h2>Ajoutez un nouveau plat !</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" required>
            <label for="description">Description :</label>
            <textarea name="description" required></textarea>
            <label for="prix">Prix :</label>
            <input type="number" name="prix" step="0.01" required>
            <label for="id_categorie">Catégorie :</label>
            <select name="id_categorie" required>
                <?php
                $Categories = $pdo->query("SELECT * FROM Categories")->fetchAll();
                foreach ($Categories as $Categorie) {
                    echo "<option value='{$Categorie['id']}'>{$Categorie['Nom']}</option>";
                }
                ?>
            </select>
            <button type="submit">Ajouter</button>
            <button onclick="window.location.href='creation_menu.php'">Créer votre menu</button>
            <br>
        </form>
        <!-- Affichage des plats -->
        <h2>Liste des plats</h2>
        <ul>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $categorie_actuelle = null;

                    // Requête SQL avec un ordre personnalisé des catégories
                    $plats = $pdo->query("
                SELECT plats.*, Categories.Nom as categorie_nom 
                FROM plats 
                INNER JOIN Categories ON plats.id_categorie = Categories.id 
                ORDER BY 
                    FIELD(Categories.Nom, 'Entrée', 'Plat', 'Dessert'), 
                    plats.titre
            ")->fetchAll();

                    foreach ($plats as $plat):
                        // Si la catégorie change, affichez un en-tête de catégorie
                        if ($categorie_actuelle !== $plat['categorie_nom']) {
                            $categorie_actuelle = $plat['categorie_nom'];
                            echo "<tr><th colspan='4' style='background-color: #f4f4f4; text-align:center;'>{$categorie_actuelle}</th></tr>";
                        }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($plat['titre']); ?></td>
                            <td><?php echo htmlspecialchars($plat['description']); ?></td>
                            <td class="prix"><?= htmlspecialchars($plat['prix']) ?> €</td>
                            <td>
                                <a href="#">Modifier</a>
                                <a href="../pages/profile.php echo $plat['id']; ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </ul>


    </main>
    <footer>
        <section class="footer">
            <div>Contact</div>
            <div>Connexion</div>
            <div>11 rue du Panier, 13002 Marseille</div>
        </section>
    </footer>
</body>

</html>