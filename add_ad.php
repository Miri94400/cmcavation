<?php
session_start();
require_once 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $price = floatval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $category = htmlspecialchars($_POST['category']);
    $photo = htmlspecialchars($_POST['photo']); 
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO ads (user_id, title, price, description, photo, category, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    if ($stmt->execute([$user_id, $title, $price, $description, $photo, $category])) {
        echo "Annonce ajoutée avec succès !";
    } else {
        echo "Erreur lors de l'ajout de l'annonce.";
    }
}
?>

<!-- FORMULAIRE HTML -->
<h2>Ajouter une annonce</h2>
<form method="post">
    <label>Titre : <input type="text" name="title" required></label><br><br>
    <label>Prix : <input type="number" step="0.01" name="price" required></label><br><br>
    <label>Description : <textarea name="description" required></textarea></label><br><br>
    <label>Photo (URL) : <input type="text" name="photo"></label><br><br>
    <input type="submit" name="submit" value="Ajouter l'annonce">
</form>