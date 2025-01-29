<?php
require_once '../includes/db_connection.php';
?>

<body>
    <header>
        <nav>
            <ul class="navbar">
                <li>
                    <div class="logo_acceuil">
                        <img src="./assets/img/logo_cook_&_share.png" alt="logo_cook&share" height="100px">
                    </div>
                </li>
                <li>
                    <div class="logo_navbar">
                        <a href="./pages/inscription.php"><img src="./assets/img/logo profile.png" alt="logo_profile"></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <h1>INSCRIPTION</h1>
    <form action="/Gestionnaire-de-menu/pages/inscription.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <button type="submit">S'inscrire</button>
    </form>

    <a href="./connexion.php">login</a>
</body>

<?php
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : Impossible de se connecter à la base de données. " . $e->getMessage());
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification des champs
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'adresse e-mail est invalide.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {


        // Hash du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

        try {
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);
            $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $error = "Le nom d'utilisateur ou l'email existe déjà.";
            } else {
                $error = "Erreur lors de l'inscription : " . $e->getMessage();
            }
        }
    }
}
