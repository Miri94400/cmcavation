<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_class = 'update-message';

// Récupérer les infos actuelles
$stmt = $pdo->prepare("SELECT username, lastname, firstname, email, birthdate, adress, city, Postal_code, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "<div class='$message_class error'>Utilisateur introuvable.</div>";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = trim($_POST['lastname'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $adress = trim($_POST['adress'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $Postal_code = trim($_POST['Postal_code'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($lastname && $firstname && $username && $email) {
        $stmt = $pdo->prepare("UPDATE users SET lastname=?, firstname=?, username=?, email=?, birthdate=?, adress=?, city=?, Postal_code=?, phone=? WHERE id=?");
        if ($stmt->execute([$lastname, $firstname, $username, $email, $birthdate, $adress, $city, $Postal_code, $phone, $user_id])) {
            $message = "Profil mis à jour avec succès.";
            $message_class .= " success";
            // Met à jour les infos affichées
            $user = array_merge($user, compact('lastname', 'firstname', 'username', 'email', 'birthdate', 'adress', 'city', 'Postal_code', 'phone'));
        } else {
            $message = "Erreur lors de la mise à jour.";
            $message_class .= " error";
        }
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
        $message_class .= " error";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="update-container">
    <h2>Modifier mon profil</h2>
    <?php if ($message): ?>
        <div class="<?= $message_class ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Nom :</label>
        <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required>
        <label>Prénom :</label>
        <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required>
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        <label>Email :</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <label>Date de naissance :</label>
        <input type="date" name="birthdate" value="<?= htmlspecialchars($user['birthdate']) ?>">
        <label>Adresse :</label>
        <input type="text" name="adress" value="<?= htmlspecialchars($user['adress']) ?>">
        <label>Ville :</label>
        <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>">
        <label>Code postal :</label>
        <input type="text" name="Postal_code" value="<?= htmlspecialchars($user['Postal_code']) ?>">
        <label>Téléphone :</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
        <button type="submit">Enregistrer</button>
    </form>
    <p><a href="profil.php">Retour au profil</a></p>
</div>
</body>
</html>