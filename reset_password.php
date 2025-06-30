<?php
require_once 'config.php';
$token = $_GET['token'] ?? '';


$stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expire > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();


if ($user) {

    if (!empty($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expire = NULL WHERE id = ?");
        $stmt->execute([$hashed_password, $user['id']]);

        echo "<h2>🛫 Mot de passe modifié avec succès, Commandant !</h2>
              <p><a href='login.php'>Retour au cockpit</a></p>";
        exit;
    }
    ?>
    <h2>🔑 Réinitialisation du mot de passe</h2>
    <p>Bienvenue dans la tour de contrôle, Commandant.<br>
    Pour reprendre les commandes de votre compte, veuillez entrer un nouveau mot de passe.</p>
    <form method="post" style="margin-top:20px;">
        <label>🛩️ Nouveau mot de passe :</label>
        <input type="password" name="new_password" required>
        <button type="submit">Changer le mot de passe</button>
    </form>
    <?php
} else {
    echo "<h2>🚫 Lien invalide ou expiré.</h2>
          <p>Veuillez recommencer la procédure depuis la tour de contrôle.</p>";
}
?>
