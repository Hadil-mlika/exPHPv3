<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Ajouter un rendez-vous</title>
</head>
<body>


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

<h1>Ajouter un rendez-vous</h1>
<form action="traitement_formulaire.php" method="post" onsubmit="return validateForm()">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required>

    <label for="email">email :</label>
    <input type="email" id="email" name="email" required>

    <label for="numero_telephone">Numéro de téléphone :</label>
    <input type="tel" id="numero_telephone" name="numero_telephone" required>

    <label for="date_rendezvous">Date du rendez-vous :</label>
    <input type="date" id="date_rendezvous" name="date_rendezvous" required>

    <input type="submit" value="Valider le rendez-vous">
</form>

<script>
    function validateForm() {

        var emailformat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var phoneformat =
            /^(00216|\+216)?(97|95|96|20)\d{6}$|(00216|\+216)?\d{8}$/;

        var emailInput = document.getElementById('email');
        var phoneInput = document.getElementById('numero_telephone');

        if (!emailformat.test(emailInput.value)) {
            alert('Veuillez entrer une adresse email valide.');
            return false;
        }

        if (!phoneformat.test(phoneInput.value.replace(/\s/g, ''))) {
            alert('Veuillez entrer un numéro de téléphone mobile tunisien valide.');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
