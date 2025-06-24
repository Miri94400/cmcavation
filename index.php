<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'connexion_bdd.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer le username stocké en session lors de la connexion ou inscription
$user_name = $_SESSION['username'] ?? 'Utilisateur';

// Récupérer les produits de la base
$produits = $pdo->query("SELECT * FROM produits")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - cmcavation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur cmcavation</h1>

        <p><strong>Bonjour <?= htmlspecialchars($user_name) ?>, bienvenue à bord !</strong></p>
        <p>Connecté en tant que : <strong><?= htmlspecialchars($user_name) ?></strong></p>
           <a href="profil.php">Voir mon profil</a> |
           <a href="logout.php">Se déconnecter</a>

    </header>

    <main>
        <h2>Produits disponibles</h2>

        <?php if (count($produits) > 0): ?>
            <div class="produits">
                <?php foreach ($produits as $produit): ?>
                    <div class="produit">
                        <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                        <p><?= htmlspecialchars($produit['description']) ?></p>
                        <p>Prix : <?= htmlspecialchars($produit['prix']) ?> €</p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun produit pour le moment.</p>
        <?php endif; ?>
    </main>
</body>
</html>