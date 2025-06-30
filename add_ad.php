<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? '';
    $type = $_POST['type'] ?? '';
    $description = $_POST['description'] ?? '';
    $year = $_POST['year'] ?? null;
    $hours = $_POST['hours'] ?? null;
    $model = $_POST['model'] ?? '';
    $cat = $_POST['catégorie'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Gestion de l'upload de photo
    $photo = null;
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $photo = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);
    }

    if ($title && $price && $type) {
        $stmt = $pdo->prepare("INSERT INTO ads (user_id, title, price, type, description, year, hours, model, photo, catégorie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $price, $type, $description, $year, $hours, $model, $photo, $cat]);
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une annonce avion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Ajouter une annonce d’avion</h2>
    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Titre* : <input type="text" name="title" required></label>
        <label>Prix (€)* : <input type="number" name="price" step="0.01" required></label>
        <label>Type* :
            <select name="type" required>
                <option value="">Choisir</option>
                <option value="Vente">Vente</option>
                <option value="Location">Location</option>
            </select>
        </label>
        <label>Année : <input type="number" name="year" min="1900" max="2100"></label>
        <label>Heures de vol : <input type="number" name="hours" min="0"></label>
        <label>Modèle : <input type="text" name="model"></label>
        <label>Catégorie : <input type="text" name="catégorie"></label>
        <label>Description :<textarea name="description" rows="4"></textarea></label>
        <label>Photo : <input type="file" name="photo" accept="image/*"></label>
        <input type="submit" value="Créer l’annonce">
    </form>
    <p><a href="dashboard.php">Retour au cockpit</a></p>
</div>
</body>
</html>