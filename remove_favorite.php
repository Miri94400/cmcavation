<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour retirer un favori.";
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
        echo "Erreur lors de la suppression du favori.";
    }
} else {
    echo "Aucune annonce sélectionnée.";
}
?>