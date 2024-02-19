<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rendezvous";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'decision_') === 0) {
        $idRendezVous = substr($key, strlen('decision_'));
        $decision = $conn->real_escape_string($value);

        // Mise à jour du statut dans la base de données
        $updateSql = "UPDATE rendezvouspatients SET statut = '$decision' WHERE id_rendezvous = $idRendezVous";

        if ($conn->query($updateSql) === TRUE) {
            echo "\n Décision mise à jour avec succès pour le rendez-vous ID: $idRendezVous \r\n";
            echo "<br>";

            // Envoi d'un email à l'utilisateur
            $idUser = getUserIdFromRendezVousId($conn, $idRendezVous);
            sendEmailToUser($conn, $idUser, $decision);

        } else {
            echo "\n Erreur lors de la mise à jour de la décision: \r\n" . $conn->error;
        }
    }
}

// Fermer la connexion à la base de données
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

function sendEmailToUser($conn, $idUser, $decision) {
    $userInfo = getUserInfo($conn, $idUser);

    if ($userInfo !== null) {
        $email = $userInfo['email'];
        $nom = $userInfo['nom'];
        $prenom = $userInfo['prenom'];

        // Construire le sujet et le corps de l'e-mail
        $sujet = "Mise à jour de votre rendez-vous médical";
        $corps = "Bonjour $prenom $nom,\r\n";
        $corps .= "Votre rendez-vous a été $decision.\r\n";


       if( mail($email, $sujet, $corps)){
           echo "\n email envoyé à $email \n\n";
           echo "<br>";
       }
      else echo "\n email non envoyé \n";
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
?>




