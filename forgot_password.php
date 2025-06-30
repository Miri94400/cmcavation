<?php
require_once 'config.php';

$message = '';
$message_class = 'forgot-message';

if (!empty($_POST['email'])) {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expire = ? WHERE id = ?");
        $stmt->execute([$token, $expire, $user['id']]);

        $reset_link = "http://localhost/cmcavation/reset_password.php?token=$token";
        $message = "Un email de réinitialisation a été envoyé.<br>(Lien pour test : <a href='$reset_link'>$reset_link</a>)";
    } else {
        $message = "Aucun compte trouvé avec cet email.";
        $message_class .= " error";
    }
}
?>

<div class="forgot-container">
    <h2>Mot de passe oublié</h2>
    <?php if (!empty($message)): ?>
        <div class="<?= $message_class ?>"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Votre email :</label>
        <input type="email" name="email" required>
        <button type="submit">Réinitialiser le mot de passe</button>
    </form>
</div>
