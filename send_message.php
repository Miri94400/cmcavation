<?php
session_start();
require_once 'config.php';

$message = '';
$message_class = 'send-message-message';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!empty($_POST['content']) && !empty($_POST['receiver_id']) && !empty($_POST['ad_id'])) {
    $content = htmlspecialchars($_POST['content']);
    $receiver_id = intval($_POST['receiver_id']);
    $ad_id = intval($_POST['ad_id']);
    $sender_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO messages (content, created_at, ad_id, receiver_id, sender_id) VALUES (?, NOW(), ?, ?, ?)");
    if ($stmt->execute([$content, $ad_id, $receiver_id, $sender_id])) {
        $message = "Message envoyé !";
        $message_class .= " success";
    } else {
        $message = "Erreur lors de l'envoi du message.";
        $message_class .= " error";
    }
}
?>

<div class="send-message-container">
    <h2>Envoyer un message</h2>
    <?php if (!empty($message)): ?>
        <div class="<?= $message_class ?>"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Message :</label>
        <textarea name="content" required></textarea>
        <label>ID du destinataire :</label>
        <input type="number" name="receiver_id" required>
        <label>ID de l'annonce :</label>
        <input type="number" name="ad_id" required>
        <button type="submit">Envoyer</button>
    </form>
</div>
