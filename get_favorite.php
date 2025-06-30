<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
<<<<<<< HEAD
    echo "<div class='message error'>Vous devez être connecté pour voir vos favoris.</div>";
=======
    echo "Vous devez être connecté pour voir vos favoris.";
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
    exit;
}

$user_id = $_SESSION['user_id'];

<<<<<<< HEAD
=======

>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
$stmt = $pdo->prepare("
    SELECT ads.*
    FROM favorite
    JOIN ads ON favorite.ad_id = ads.id
    WHERE favorite.user_id = ?
");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll();

<<<<<<< HEAD
echo "<div class='favorite-container'>";
if (count($favorites) > 0) {
    echo "<h2>Mes annonces favorites</h2>";
    echo "<div class='favorite-list'>";
    foreach ($favorites as $ad) {
        echo "<div class='favorite-item'>";
        if (!empty($ad['photo'])) {
            echo "<img src='" . htmlspecialchars($ad['photo']) . "' alt='Photo de l\'annonce'>";
        }
        echo "<div class='info'>
                <strong>" . htmlspecialchars($ad['title']) . "</strong><br>
                <span>" . number_format($ad['price'], 2, ',', ' ') . " €</span><br>
                <a href='as_details.php?id=" . $ad['id'] . "'>Voir l'annonce</a>
              </div>
            </div>";
    }
    echo "</div>";
} else {
    echo "<div class='message'>Vous n'avez pas encore d'annonces en favoris.</div>";
}
echo "</div>";
=======
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
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
