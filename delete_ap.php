<?php
session_start();

require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$ad_id = $_GET['id'] ?? null;

if ($ad_id) {
    // Vérifie que l'annonce appartient à l'utilisateur connecté
    $stmt = $pdo->prepare("SELECT id FROM ads WHERE id = ? AND user_id = ?");
    $stmt->execute([$ad_id, $_SESSION['user_id']]);
    $ad = $stmt->fetch();

    if ($ad) {
        // Supprime l'annonce
        $stmt = $pdo->prepare("DELETE FROM ads WHERE id = ?");
        $stmt->execute([$ad_id]);
        // Redirige vers le dashboard avec un message de succès
        header("Location: dashboard.php?deleted=1");
        exit;
    } else {
        echo "Annonce introuvable ou vous n'avez pas le droit de la supprimer.<br>";
        echo "<a href='dashboard.php'>Retour au Cockpit</a>";
    }
} else {
    echo "Aucune annonce sélectionnée.<br>";
    echo "<a href='dashboard.php'>Retour au dashboard</a>";
}
?>