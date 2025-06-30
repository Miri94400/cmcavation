<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $description = htmlspecialchars($_POST['description'] ?? '');
    $catégorie = htmlspecialchars($_POST['catégorie'] ?? '');
    $type = htmlspecialchars($_POST['type'] ?? '');
    $model = htmlspecialchars($_POST['model'] ?? '');
    $year = intval($_POST['year'] ?? 0);
    $hours = intval($_POST['hours'] ?? 0);
    $user_id = $_SESSION['user_id'];

    // Gestion de l'upload de la photo
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed)) {
            $filename = uniqid() . '.' . $ext;
            $destination = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                $photo = $destination;
            }
        }
    }

    // Vérifie que tous les champs obligatoires sont remplis
    if ($title && $price && $description && $catégorie && $type && $model && $year && $hours && $photo) {
        $stmt = $pdo->prepare("INSERT INTO ads (user_id, title, price, description, catégorie, type, model, year, hours, photo, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        if ($stmt->execute([$user_id, $title, $price, $description, $catégorie, $type, $model, $year, $hours, $photo])) {
            header("Location: dashboard.php?added=1");
            exit;
        } else {
            echo "<p style='color:red;'>Erreur lors de l'ajout de l'annonce.</p>";
        }
    } else {
        echo "<p style='color:red;'>Merci de remplir tous les champs obligatoires et d'ajouter une photo.</p>";
    }
}
?>

<link rel="stylesheet" href="style.css">

<h2>Ajouter une annonce</h2>
<form method="post" enctype="multipart/form-data">
    <label>Titre : <input type="text" name="title" required></label><br><br>
    <label>Prix (€) : <input type="number" step="0.01" name="price" required></label><br><br>
    <label>Description : <textarea name="description" required></textarea></label><br><br>
    <label>Catégorie :
        <select name="catégorie" required>
            <option value="">Choisir...</option>
            <option value="Vente">Vente</option>
            <option value="Location">Location</option>
            <option value="Partage">Partage</option>
        </select>
    </label><br><br>
    <label>Type d'appareil :
        <select name="type" required>
            <option value="">Choisir...</option>
            <option value="Avion">Avion</option>
            <option value="Hélicoptère">Hélicoptère</option>
            <option value="Jet privé">Jet privé</option>
            <option value="ULM">ULM</option>
            <option value="Autre">Autre</option>
        </select>
    </label><br><br>
    <label>Modèle : <input type="text" name="model" required></label><br><br>
    <label>Année : <input type="number" name="year" min="1900" max="<?= date('Y') ?>" required></label><br><br>
    <label>Heures de vol : <input type="number" name="hours" min="0" required></label><br><br>
    <label>Photo : <input type="file" name="photo" accept="image/*" required></label><br><br>
    <input type="submit" name="submit" value="Ajouter l'annonce">
</form>