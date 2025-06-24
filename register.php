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

</head>
<body>
    <h2>Inscription</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php">
         <label for="Nom">Nom :</label>
         <input type="text" id="Nom" name="lastname" required><br><br>
        <label for = "Prénom" > Prénom :</label>
        <input type = "text" id = "Prénom" name= "Prénom" required> <br><br>
        <label for = " Genre"> Genre :</label>
        <select id="Genre" name="Genre" required>
            <option value="">Sélectionnez un genre</option>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
    </select> <br><br>
    <label for =" Date de naissance "> Date de naissance :</label>
    <input type="date" id="Date de naissance" name="Date de naissance" required> <br><br>
     <label for = "Code postal"> Code postal : </label>
    <input type = "text" id = " Code postal" name= "Code postal" required> <br><br>
    <label for = "text"> Ville :</label>
    <input type = " text" id= "Ville" name= "Ville" required> <br><br>
    <label for="Adresse"> Adresse :</label>
    <input type="text" id="Adresse" name="Adresse" required> <br><br>
    <label for =" Téléphone"> Téléphone :</label>
    <input type = "tel" id = " Téléphone" name = "Téléphone" required> <br><br>
    <label for = "username"> Nom d'utilisateur :</label>
    <input type = "text" id= "username" name = "username" required> <br><br>
        <label for = "email"> Adresse email :</label>
        <input type = "email" id = "Email" name = "Email" required> <br><br>
        
        <label>Mot de passe :</label><br>
        <input type = "Password" name = " Mot de passe" required> <br><br>
        <label for="confirm_password">Confirmer le mot de passe :</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <label> syrine : </label>
        <input type = Fille name = "syrine" value = "syrine" checked>
        <h1> syrine <h1> <br><br>
        <h2> LALALALAALLALA <h2>
            <h4> JDJDIOFNOZEFNOAEG <h4>
       
        <button type="submit" name="submit">S'inscrire</button>
    </form>


</body>
</html>