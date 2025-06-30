<?php

session_start ();
require_once 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION ['user_id'];

$stmt = $pdo->prepare("SELECT * FROM ads WHERE user_id = ?");
$stmt -> execute([$user_id]);
$result = $stmt->fetchAll();

?> 

<div class="dashboard-container">
    <h2>Mon Cockpit</h2>

    <p>Bienvenue dans ton espace personnel.</p>

    <h3>Mes annonces :</h3>
    <div class="ads-list">
    <?php foreach ($result as $row) : ?>
        <div class="ad-card">
            <?php if (!empty($row['photo'])): ?>
                <div class="ad-photo">
                    <img src="<?= htmlspecialchars($row['photo']) ?>" alt="Photo avion" loading="lazy">
                </div>
            <?php endif; ?>
            <div class="ad-info">
                <strong><?= htmlspecialchars($row['title']) ?></strong>
                <span class="ad-type">(<?= htmlspecialchars($row['type'] ?? '') ?>)</span>
                <span class="ad-price"><?= number_format($row['price'], 2) ?> €</span>
                <?php if (!empty($row['model'])): ?>
                    <div><strong>Modèle :</strong> <?= htmlspecialchars($row['model']) ?></div>
                <?php endif; ?>
                <?php if (!empty($row['year'])): ?>
                    <div><strong>Année :</strong> <?= htmlspecialchars($row['year']) ?></div>
                <?php endif; ?>
                <?php if (!empty($row['hours'])): ?>
                    <div><strong>Heures de vol :</strong> <?= htmlspecialchars($row['hours']) ?></div>
                <?php endif; ?>
                <?php if (!empty($row['catégorie'])): ?>
                    <div><strong>Catégorie :</strong> <?= htmlspecialchars($row['catégorie']) ?></div>
                <?php endif; ?>
                <div class="ad-desc"><?= nl2br(htmlspecialchars($row['description'] ?? '')) ?></div>
                <a href="delete_ap.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Supprimer cette annonce ?');">Supprimer</a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <p><a href="add_ad.php">Ajouter une nouvelle annonce</a></p>
    <p><a href="get_favorite.php">Voir mes favoris</a></p>
    <p><a href="logout.php">Se déconnecter</a></p>

</div></div>
