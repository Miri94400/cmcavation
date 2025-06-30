<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'config.php';

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
           <a href="profil.php">Voir mon profil</a><br><br>
           <a href="dashboard.php">Mon Cockpit</a> <br> <br>

           <a href="logout.php">Se déconnecter</a><br><br>

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
                        <!-- Si tu veux afficher une image :
                        <?php if (!empty($produit['photo'])): ?>
                            <img src="<?= htmlspecialchars($produit['photo']) ?>" alt="Photo du produit" style="width:100%;max-height:160px;object-fit:cover;border-radius:6px;margin-bottom:10px;">
                        <?php endif; ?>
                        -->
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun produit pour le moment.</p>
        <?php endif; ?>
    </main>
</body>
</html>