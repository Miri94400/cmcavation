<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour voir vos favoris.";
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    SELECT ads.*
    FROM favorite
    JOIN ads ON favorite.ad_id = ads.id
    WHERE favorite.user_id = ?
");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll();

if (count($favorites) > 0) {
    echo "<h2>Mes annonces favorites</h2><ul>";
    foreach ($favorites as $ad) {
        echo "<li>
            <strong>" . htmlspecialchars($ad['title']) . "</strong> - " . number_format($ad['price'], 2) . " €
            <a href='as_details.php?id=" . $ad['id'] . "'>Voir l'annonce</a>
        </li>";
    }
    echo "</ul>";
} else {
    echo "<p>Vous n'avez pas encore d'annonces en favoris.</p>";
}