<?php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rendezvous";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Récupérer la liste des rendez-vous depuis la base de données

$sqlRendezVous = "SELECT id_rendezvous, daterendezvous FROM rendezvouspatients";
$resultRendezVous = $conn->query($sqlRendezVous);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>LES Rendez-vous </title>
    <style>
        form {
            max-width: 600px;
            margin: 0 auto;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        select {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none; /* Supprime la bordure de mise au point */
            cursor: pointer;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        select {
            /* Styles généraux pour le menu déroulant */
            padding: 5px;
            font-size: 14px;
            /* Ajoutez d'autres styles personnalisés selon vos besoins */
        }

        select option {
            /* Styles spécifiques pour chaque option */
            background-color: #f2f2f2;
            padding: 8px;
            color: #333;
            /* Ajoutez d'autres styles personnalisés selon vos besoins */
        }

        /* Styles spécifiques pour chaque option en fonction de la valeur */
        select option[value='accepté'] {
            background-color: #4caf50; /* Vert pour l'option "Accepter" */
            color: #fff;
        }

        select option[value='refusé'] {
            background-color: #f44336; /* Rouge pour l'option "Refuser" */
            color: #fff;
        }

    </style>

</head>
<body>
<h1>LES Rendez-vous</h1>

<form action="traitement_accepter_refuser.php" method="post">
    <ul>
        <?php
        while ($row = $resultRendezVous->fetch_assoc()) {
            echo "<li>";
            echo "<span class='date'><b>ID rendez-vous: {$row['id_rendezvous']}</b>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <B>Date rendez-vous: {$row['daterendezvous']}</B> <br> <br></span>";
            echo "<select name='decision_{$row['id_rendezvous']}'>";
            echo "<option value='accepté'><b>Accepter</b></option>";
            echo "<option value='refusé'><b>Refuser</b></option>";
            echo "</select>";
            echo "</li>";
        }

        ?>
    </ul>


    <button type="submit">Valider</button>
</form>



<?php
//
$conn->close();
?>
</body>
</html>
