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
<?php
include 'includes\db_connection.php';

// Suppression d'un plat
if (isset($_POST['delete_id'])) {
    $plat_id = $_POST['delete_id'];

    try {
        // Préparer la requête pour supprimer le plat
        $sql = "DELETE FROM plats WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $plat_id);
        $stmt->execute();

        // Rediriger après la suppression
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont remplis
    if (empty($_POST['titre']) || empty($_POST['prix'])) {
        echo "Erreur : les champs Titre du plat et prix sont obligatoires.";
    } else {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $categorie_id = $_POST['categorie_id']; 

        try {
            // Préparer la requête SQL pour l'insertion dans la base de données
            $sql = "INSERT INTO plats (titre, description, prix, categorie_id) VALUES (:titre, :description, :prix, :categorie_id)";
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête préparée
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':categorie_id', $categorie_id);

            // Exécuter la requête
            $stmt->execute();

            // Redirection vers la même page après l'ajout
            header("Location: " . $_SERVER['PHP_SELF']);
            exit; // Assure-toi que le script s'arrête ici après la redirection

        } catch (PDOException $host) {
            echo "Erreur : " . $host->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\global.css">
    <link rel="stylesheet" href="styles\style_profil.css">
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
</header>

<main>
    <h1>Bonjour, <?php echo $username; ?>!</h1>
    <h1><a href = "menu.php">Menu</a><h1>

    <!-- Formulaire d'ajout de plat -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <label for="titre">Titre du plat :</label> 
        <input type="text" name="titre" id="titre" required>
        
        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>

        <label for="prix">Prix :</label>
        <input type="number" name="prix" id="prix" step="0.01" required>

        <!-- Menu déroulant pour la catégorie -->
        <label for="categorie">Catégorie :</label>
        <select name="categorie_id" id="categorie" required>
            <?php
            // Récupérer toutes les catégories de la base de données
            $stmt = $pdo->query("SELECT id,nom FROM categorie");
            $categories = $stmt->fetchAll();

            // Afficher chaque catégorie dans le menu déroulant
            foreach ($categories as $categorie) {
                echo "<option value='" . htmlspecialchars($categorie['id']) . "'>" . htmlspecialchars($categorie['nom']) . "</option>";
            }
            ?>
        </select>

        <button type="submit">Ajouter le plat</button>
    </form>

    <!-- Affichage des plats -->
    <h2>Liste des plats</h2>
    <ul>
        <?php
        $stmt = $pdo->query("SELECT plats.titre, plats.description, plats.prix, categorie.nom AS categorie FROM plats LEFT JOIN categorie ON plats.categorie_id = categorie.id");
        $plats = $stmt->fetchAll();

        foreach ($plats as $plat) {
            echo "<li>" . htmlspecialchars($plat['titre']) . " - " . htmlspecialchars($plat['description']) . " - " . htmlspecialchars($plat['prix']) . "€ - " . htmlspecialchars($plat['categorie']) . "</li>";  
        }
        ?>
    </ul>
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