<?php

session_start();
require_once 'config.php';

$ad_id = $_GET['id'] ?? null;

if (!$ad_id) {
    echo "Aucune annonce sélectionnée.";
    exit;
}

$stmt = $pdo->prepare("SELECT ads.*, users.username FROM ads JOIN users ON ads.user_id = users.id WHERE ads.id = ?");
$stmt->execute([$ad_id]);
$ad = $stmt->fetch();

if (!$ad) {
    echo "Annonce introuvable.";
    exit;
}
?>

<div class="details-container">
    <h2><?= htmlspecialchars($ad['title']) ?></h2>
    <p><strong>Catégorie :</strong> <?= htmlspecialchars($ad['catégorie']) ?></p>
    <p><strong>Type :</strong> <?= htmlspecialchars($ad['type']) ?></p>
    <p><strong>Modèle :</strong> <?= htmlspecialchars($ad['model']) ?></p>
    <p><strong>Année :</strong> <?= htmlspecialchars($ad['year']) ?></p>
    <p><strong>Heures de vol :</strong> <?= htmlspecialchars($ad['hours']) ?></p>
    <p><strong>Prix :</strong> <?= number_format($ad['price'], 2) ?> €</p>
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($ad['description'])) ?></p>
    <p><strong>Vendeur :</strong> <?= htmlspecialchars($ad['username']) ?></p>
    <?php if (!empty($ad['photo'])): ?>
        <img src="<?= htmlspecialchars($ad['photo']) ?>" alt="Photo de l'annonce">
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $ad['user_id']): ?>
        <form method="post" action="send_message.php">
            <input type="hidden" name="ad_id" value="<?= $ad['id'] ?>">
            <input type="hidden" name="receiver_id" value="<?= $ad['user_id'] ?>">
            <label>Envoyer un message au vendeur :</label>
            <textarea name="content" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    <?php endif; ?>

    <a href="index.php">Retour à la liste</a>
</div>