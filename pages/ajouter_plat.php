<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plats</title>
</head>

<body>
    <form action="insert_plats.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="categorie" value="plat">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" required>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea>

        <label for="prix">Prix :</label>
        <input type="number" name="prix" step="0.01" required>

        <label for="image">Image :</label>
        <input type="file" name="image">

        <button type="submit">Ajouter le plat</button>
    </form>
</body>

</html>