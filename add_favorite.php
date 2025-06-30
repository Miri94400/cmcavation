<?php

session_start();
require_once 'config.php';

// Test de la connexion PDO (à retirer après le test)
// var_dump($pdo); exit;

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour ajouter un favori.";
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
            echo "Annonce ajoutée aux favoris !";
        } else {
            echo "Erreur lors de l'ajout du favori.";
        }
    } else {
        echo "Cette annonce est déjà dans vos favoris.";
    }
} else {
    echo "Aucune annonce sélectionnée.";
}
?>