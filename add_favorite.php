<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo '<div class="message error">Vous devez être connecté pour ajouter un favori.</div>';
    exit;
}

if (isset($_POST['ad_id'])) {
    $user_id = $_SESSION['user_id'];
    $ad_id = $_POST['ad_id'];

    // Vérifie si le favori existe déjà
    $stmt = $pdo->prepare("SELECT id FROM favorite WHERE user_id = ? AND ad_id = ?");
    $stmt->execute([$user_id, $ad_id]);
    if ($stmt->rowCount() == 0) {
        // Ajoute le favori
        $stmt = $pdo->prepare("INSERT INTO favorite (user_id, ad_id) VALUES (?, ?)");
        if ($stmt->execute([$user_id, $ad_id])) {
            echo '<div class="message success">Annonce ajoutée aux favoris !</div>';
        } else {
            echo '<div class="message error">Erreur lors de l\'ajout du favori.</div>';
        }
    } else {
        echo '<div class="message">Cette annonce est déjà dans vos favoris.</div>';
    }
} else {
    echo '<div class="message error">Aucune annonce sélectionnée.</div>';
}
?>