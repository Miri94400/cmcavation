<?php
require_once 'config.php';

<<<<<<< HEAD
$message = '';
$message_class = 'forgot-message';

if (!empty($_POST['email'])) {
    $email = $_POST['email'];

=======
if (!empty($_POST['email'])) {
    $email = $_POST['email'];

    
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
<<<<<<< HEAD
=======
     
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
        $token = bin2hex(random_bytes(32));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expire = ? WHERE id = ?");
        $stmt->execute([$token, $expire, $user['id']]);

        $reset_link = "http://localhost/cmcavation/reset_password.php?token=$token";
<<<<<<< HEAD
        $message = "Un email de réinitialisation a été envoyé.<br>(Lien pour test : <a href='$reset_link'>$reset_link</a>)";
    } else {
        $message = "Aucun compte trouvé avec cet email.";
        $message_class .= " error";
=======
        echo "Un email de réinitialisation a été envoyé. (Lien pour test : <a href='$reset_link'>$reset_link</a>)";
    } else {
        echo "Aucun compte trouvé avec cet email.";
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
    }
}
?>

<<<<<<< HEAD
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
=======
<form method="post">
    <label>Votre email :</label>
    <input type="email" name="email" required>
    <button type="submit">Réinitialiser le mot de passe</button>
</form>
>>>>>>> 3546658a76f93c1acef1d7135df5b38e49c84063
