<?php
session_start();
require_once 'config.php'; // ou 'connexion_bdd.php' selon ton projet

$error = "";

if (isset($_POST['login'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        $user = $query->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>Connexion à Cmcavation</h2>

    <?php if (!empty($error)) : ?>
        <div class="login-message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Se connecter</button>
        <p><a href="forgot_password.php">Mot de passe oublié ?</a></p>
    </form>

    <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
</div>

</body>
</html>