<?php
session_start();
require_once 'config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// On récupère les infos de l'utilisateur depuis la base
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, lastname, firstname, email, birthdate, adress, city, Postal_code, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - cmcavation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Mon Profil</h1>
        
        <p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
        <a href="index.php">← Retour à l'accueil</a> | 
        <a href="logout.php">Se déconnecter</a>
    </header>

    <main>
        <h2>Mes informations</h2>
        <ul>
            <li><strong>Nom :</strong> <?= htmlspecialchars($user['lastname']) ?></li><br>
            <li><strong>Prénom :</strong> <?= htmlspecialchars($user['firstname']) ?></li><br>
            <li><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></li><br>
            <li><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></li><br>
            <li><strong>Date de naissance :</strong> <?= htmlspecialchars($user['birthdate']) ?></li><br>
            <li><strong>Adresse :</strong> <?= htmlspecialchars($user['adress']) ?>, <?= htmlspecialchars($user['Postal_code']) ?> <?= htmlspecialchars($user['city']) ?></li><br>
            <li><strong>Téléphone :</strong> <?= htmlspecialchars($user['phone']) ?></li><br>
        </ul>

        <!-- Tu pourras plus tard ajouter un bouton pour modifier ces infos -->
    </main>
</body>
</html>