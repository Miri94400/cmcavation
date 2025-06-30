<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
<<<<<<< HEAD
    echo "<div class='remove-favorite-message'>Vous devez être connecté pour retirer un favori.</div>";
=======
    echo "Vous devez être connecté pour retirer un favori.";
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
    exit;
}

if (isset($_GET['ad_id'])) {
    $user_id = $_SESSION['user_id'];
    $ad_id = intval($_GET['ad_id']);

    $stmt = $pdo->prepare("DELETE FROM favorite WHERE user_id = ? AND ad_id = ?");
    if ($stmt->execute([$user_id, $ad_id])) {
        header("Location: get_favorite.php?removed=1");
        exit;
    } else {
<<<<<<< HEAD
        echo "<div class='remove-favorite-message'>Erreur lors de la suppression du favori.</div>";
    }
} else {
    echo "<div class='remove-favorite-message'>Aucune annonce sélectionnée.</div>";
=======
        echo "Erreur lors de la suppression du favori.";
    }
} else {
    echo "Aucune annonce sélectionnée.";
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
}
?>