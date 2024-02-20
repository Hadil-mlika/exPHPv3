<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rendezvous";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$numero_telephone = htmlspecialchars($_POST['numero_telephone']);
$date_rendezvous =  htmlspecialchars($_POST['date_rendezvous']);
$email= htmlspecialchars($_POST['email']);


session_start();



$sql1 = "INSERT INTO utilisateurs (nom, prenom, email, telephone) VALUES ('$nom', '$prenom', '$email', '$numero_telephone')";

//if ($conn->query($sql1) === TRUE) {
//    // Récupérer l'id_utilisateur de l'utilisateur nouvellement ajouté
//    $id_utilisateur = $conn->insert_id;
//
//
//    $sql2 = "INSERT INTO rendezvouspatients (ID_Utilisateur, DateRendezVous	) VALUES ('$id_utilisateur', '$date_rendezvous')";
//
//    if ($conn->query($sql2) === TRUE) {
//       echo  '<script>alert("Rendez-vous ajouté avec succès!");</script>';
//    } else {
//        echo "Erreur lors de l'insertion dans la table rendez_vous: " . $conn->error;
//    }
//} else {
//    echo '<script>alert("Erreur lors de l\'insertion dans la table rendez_vous: ' . $conn->error . '");</script>';
//}





if ($conn->query($sql1) === TRUE) {


    $id_utilisateur = $conn->insert_id;

    $sql2 = "INSERT INTO rendezvouspatients (ID_Utilisateur, DateRendezVous) VALUES ('$id_utilisateur', '$date_rendezvous')";

    if ($conn->query($sql2) === TRUE) {



        $_SESSION['message'] = "Rendez-vous ajouté avec succès!" ;
        $_SESSION['message_type'] = 'green'; // Success message type
        header("Location: ajout_rendezvous.php");
        exit();


    } else {
        $_SESSION['message'] = "Error: Incorrect email or password.";
        $_SESSION['message_type'] = 'red'; // Error message type
        $_SESSION['message'] = "Erreur lors de l'insertion dans la table rendez_vous: " . $conn->error;
        $_SESSION['message_type'] = 'red';
        header("Location:  ajout_rendezvous.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Erreur lors de l'insertion dans la table rendez_vous: " . $conn->error;
    $_SESSION['message_type'] = 'red';
    header("Location: ajout_rendezvous.php");
    exit();
}


$conn->close();

?>
