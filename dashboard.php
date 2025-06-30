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

<h2> Mon Cockpit </h2>

<p> Bienvenue dans ton espace personel. </p>

<h3> Mes annonces : </h3>
<ul>
<?php foreach ($result as $row) : ?>
    <li>
        <strong><?php echo htmlspecialchars($row['title']); ?></strong> - 
        <?php echo number_format($row['price'], 2); ?> €
       <a href="delete_ap.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer cette annonce ?');">Supprimer</a>
    </li>
<?php endforeach; ?>
</ul>

<p><a href="add_ad.php">Ajouter une nouvelle annonce</a></p>
<p><a href="get_favorite.php">Voir mes favoris</a></p>
<p><a href="logout.php">Se déconnecter</a></p>
