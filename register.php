<?php
$host = 'localhost';
$db = 'cmcavation';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    $lastname = trim($_POST['lastname'] ?? '');
    $firstname = trim($_POST['Prénom'] ?? '');
    $genre = trim($_POST['Genre'] ?? '');
    $birthdate = trim($_POST['Date_de_naissance'] ?? '');
    $Postal_code = trim($_POST['Code_postal'] ?? '');
    $city = trim($_POST['Ville'] ?? '');
    $adress = trim($_POST['Adresse'] ?? '');
    $phone = trim($_POST['Téléphone'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $password = trim($_POST['Mot_de_passe'] ?? '');
    $username = trim($_POST['username'] ?? '');

    if (empty($email) || empty($password) || empty($lastname) || empty($firstname)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } elseif (strlen($password) < 10) {
        $error = "Le mot de passe doit contenir au moins 10 caractères.";
    } else {
        // Vérifie si l'email existe déjà
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Vérifie si le nom d'utilisateur existe déjà
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Ce nom d'utilisateur est déjà utilisé.";
            } else {
                // Hachage du mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertion dans la base de données
                $stmt = $conn->prepare("INSERT INTO users (lastname, firstname, genre, birthdate, Postal_code, city, adress, phone, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssssss", $lastname, $firstname, $genre, $birthdate, $Postal_code, $city, $adress, $phone, $email, $username, $hashed_password);

                if ($stmt->execute()) {
                    $success = "Inscription réussie !";
                    session_start();
                    $_SESSION['user_id'] = $stmt->insert_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Erreur lors de l'inscription.";
                }
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    .register-container {
        background: #fff;
        max-width: 450px;
        margin: 60px auto 0 auto;
        padding: 32px 28px 24px 28px;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(30, 60, 90, 0.08);
        text-align: center;
    }
    
    .register-container h2 {
        margin-bottom: 24px;
        color: #1a4d7a;
    }
    
    .register-container label {
        font-weight: 500;
        color: #1a4d7a;
        display: block;
        margin-bottom: 8px;
        text-align: left;
    }
    
    .register-container input[type="text"],
    .register-container input[type="email"],
    .register-container input[type="password"],
    .register-container input[type="date"],
    .register-container input[type="tel"],
    .register-container select {
        width: 100%;
        padding: 10px;
        border: 1px solid #b5c9d6;
        border-radius: 6px;
        font-size: 1em;
        background: #f9fbfc;
        margin-bottom: 16px;
    }
    
    .register-container button[type="submit"] {
        background: #1a4d7a;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 12px 0;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s;
        margin-bottom: 10px;
    }
    
    .register-container button[type="submit"]:hover {
        background: #2566a8;
    }
    
    .register-container a {
        color: #2566a8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .register-container a:hover {
        color: #1a4d7a;
        text-decoration: underline;
    }
    
    .register-message {
        max-width: 400px;
        margin: 0 auto 18px auto;
        padding: 14px 10px;
        border-radius: 8px;
        background: #eaf6ff;
        color: #1a4d7a;
        font-size: 1.08em;
        text-align: center;
        box-shadow: 0 2px 10px rgba(30,60,90,0.07);
    }
    
    .register-message.error {
        background: #ffeaea;
        color: #a11a1a;
    }
    
    .register-message.success {
        background: #eaffea;
        color: #1a7a2e;
    }    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-container">
        <h2>Inscription</h2>
        <?php if ($error): ?>
            <div class="register-message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="register-message success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <label for="Nom">Nom :</label>
            <input type="text" id="Nom" name="lastname" required>

            <label for="Prénom">Prénom :</label>
            <input type="text" id="Prénom" name="Prénom" required>

            <label for="Genre">Genre :</label>
            <select id="Genre" name="Genre" required>
                <option value="">Sélectionnez un genre</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>

            <label for="Date_de_naissance">Date de naissance :</label>
            <input type="date" id="Date_de_naissance" name="Date_de_naissance" required>

            <label for="Code_postal">Code postal :</label>
            <input type="text" id="Code_postal" name="Code_postal" required>

            <label for="Ville">Ville :</label>
            <input type="text" id="Ville" name="Ville" required>

            <label for="Adresse">Adresse :</label>
            <input type="text" id="Adresse" name="Adresse" required>

            <label for="Téléphone">Téléphone :</label>
            <input type="tel" id="Téléphone" name="Téléphone" required>

            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>

            <label for="Email">Adresse email :</label>
            <input type="email" id="Email" name="Email" required>

            <label for="Mot_de_passe">Mot de passe :</label>
            <input type="password" id="Mot_de_passe" name="Mot_de_passe" required>

            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit" name="submit">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </div>
</body>
</html>