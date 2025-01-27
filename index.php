<?php
$host = 'localhost';
$dbname = 'Gestionnaire-de-menu';
$username = 'root'; // Utilisateur par défaut pour phpMyAdmin
$password = 'root'; // Mot de passe vide par défaut

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<?php include 'includes/header.php';
include 'includes/nav.php' ?>
<main>
    <h2>Bienvenue sur la page d'accueil</h2>
</main>
<?php include 'includes/footer.php'; ?>