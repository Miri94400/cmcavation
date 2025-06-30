<?php
$host = 'localhost';
$dbname = 'cmcavation';
$user = 'root';
$password = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    // En production, mieux vaut ne pas afficher le détail de l'erreur
    echo "Erreur de connexion à la base de données.";
    // Pour le debug, tu peux décommenter la ligne suivante :
    // echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>

