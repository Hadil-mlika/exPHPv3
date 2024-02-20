<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rendezvous";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'decision_') === 0) {
        $idRendezVous = substr($key, strlen('decision_'));
        $decision = $conn->real_escape_string($value);

        // Mise à jour du statut dans bdd
        $updateSql = "UPDATE rendezvouspatients SET statut = '$decision' WHERE id_rendezvous = $idRendezVous";

        if ($conn->query($updateSql) === TRUE) {


            echo  '<script>alert("\n Décision mise à jour avec succès pour le rendez-vous ID: '.$idRendezVous.' \r\n");</script>';
            echo "<br>";

            // Envoi d'un email à l'utilisateur
            $idUser = getUserIdFromRendezVousId($conn, $idRendezVous);
            sendEmailToUser($conn, $idUser, $decision);

        } else {
            echo '<script> alert ("\n Erreur lors de la mise à jour de la décision: \r\n" . $conn->error)</script>';
        }
    }
}


$conn->close();

function getUserIdFromRendezVousId($conn, $idRendezVous) {
    $userIdQuery = "SELECT id_utilisateur FROM rendezvouspatients WHERE id_rendezvous = $idRendezVous";
    $result = $conn->query($userIdQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_utilisateur'];
    } else {
        return null;
    }

}

function sendEmailToUser($conn, $idUser, $decision)
{
    $userInfo = getUserInfo($conn, $idUser);
    $rendezVousInfo = getRendezVousInfo($conn, $idUser);

    if ($userInfo !== null) {
        $email = $userInfo['email'];
        $nom = $userInfo['nom'];
        $prenom = $userInfo['prenom'];
        $dateRendezVous = $rendezVousInfo['daterendezvous'];
        // Récupérer le nom du docteur à partir de l'ID du docteur
        $idDocteur = $rendezVousInfo['id_medecin'];
        $nomDocteur = getNomDocteur($conn, $idDocteur);

        // Construire le sujet et le corps de l'e-mail
        $sujet = "Statut de votre rendez-vous ";
        $corps = "Bonjour $prenom $nom,\r\n\r\n";
        $corps .= "Votre rendez-vous demandé pour la date $dateRendezVous a été $decision.\r\n\r\n";
        $corps .= "Cabinet du Dr. $nomDocteur";


        if (mail($email, $sujet, $corps)) {
            echo '<script>alert("un email est envoyé à '.$email.' ");</script>';
            echo "<br>";
        } else echo '<script>alert("echec lors de l\'envoi de l\'email  à '.$email.'");</script>';
        echo "<br>";
    }
}
function getUserInfo($conn, $idUser) {
    $query = "SELECT u.email, u.nom, u.prenom FROM utilisateurs u WHERE u.id_utilisateur = $idUser";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


function getNomDocteur($conn, $idDocteur)
{
    $query = "SELECT nomdocteur FROM medecins WHERE id_medecin = $idDocteur";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nomdocteur'];
    } else {
        return "Nom Inconnu";
    }
}



function getRendezVousInfo($conn, $idUser)
{
    $query = "SELECT daterendezvous, id_medecin FROM rendezvouspatients WHERE id_utilisateur = $idUser";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}






?>




