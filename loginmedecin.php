<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Connexion Médecin</title>

    <style>
        .message-container {
            width: 80%;
            margin: 20px auto;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .success-message {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .default-message {
            color: #333;
            background-color: #f8f9fa;
            border: 1px solid #dae0e5;
        }

    </style>
</head>
<body>

<!-- Affichage du message -->
<?php
session_start();

if (isset($_SESSION['message'])) {
    $messageTypeClass = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'default-message';
    echo '<div class="message-container ' . $messageTypeClass . '">';
    echo $_SESSION['message'];
    echo '</div>';

    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>


<h1>Connexion Médecin</h1>
<form action="traitement_login_medecin.php" method="post" onsubmit="return validateLoginForm()">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required>

    <input type="submit" value="Se connecter">
</form>

<script>
    function validateLoginForm() {

        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('mot_de_passe');

        if (emailInput.value.trim() === '' || passwordInput.value.trim() === '') {
            alert('Veuillez remplir tous les champs.');
            return false;
        }

        return true;
    }
</script>


</body>
</html>
