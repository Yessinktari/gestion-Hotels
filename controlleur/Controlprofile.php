<?php

include_once "../model/Reservation.php";
include_once "../model/Chambre.php";
include_once "../model/User.php";



session_start();
$msg = "";
$reservations = [];
$reservation = null;


// Vérification de la session
if (!isset($_SESSION['login'])) {
    header("Location: ../vue/authentification.php");
    exit();
}

$login = $_SESSION['login'];
$password = $_SESSION['password'];
$nom = $_SESSION['nom'];
$email = $_SESSION['email'];
$adresse = $_SESSION['adresse'];
$tel = $_SESSION['tel'];


if($login){
    $reservations = Reservation::getReservationsByUser($login);
    if($reservations){
        $msg = "Réservations récupérées avec succès";
    }
    else{
        $msg = "Aucune réservation trouvée";
    }
}

if (isset($_POST['annuler'])) {
    $id = $_POST['id'] ?? null;
    $num_chambre = $_POST['num_chambre'] ?? null;
    $chambre = Chambre::getChambreById($num_chambre);
    if ($id !== null) {
        $reservation = Reservation::getReservationById($id);
        if ($reservation) {
            $reservation->setStatut(2); // Annulé
            Reservation::updateReservation($reservation);
            
            $msg = "Réservation annulée avec succès.";
            header("Location: ../controlleur/ControlProfile.php");
            exit();
        } else {
            $msg = "Erreur lors de l'annulation de la réservation.";
            header("Location: ../controlleur/ControlProfile.php");
            exit();
        }
    } else {
        $msg = "Aucune réservation sélectionnée.";
        header("Location: ../controlleur/ControlProfile.php");
        exit();
    }
}


if (isset($_POST['payer'])) {
    $id = $_POST['id'] ?? null;
    $num_chambre = $_POST['num_chambre'] ?? null;
    header("Location: ../controlleur/ControlPayement.php?id=$id&num_chambre=$num_chambre");
    exit();
}









// Traitement de la modification des informations
if (isset($_POST['Modifier'])) {
    try {

        $login = $_SESSION['login'];
        $password = $_SESSION['password'];
        $nom = $_POST['nom'] ?? null;
        $email = $_POST['email'] ?? null;
        $adresse = $_POST['adresse'] ?? null;
        $tel = $_POST['tel'] ?? null;



        $user = new User($login, $password, $nom, $email,0,$adresse, $tel);
        if (User::updateUser($user)) {
            $_SESSION['nom'] = $_POST['nom'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['adresse'] = $_POST['adresse'];
            $_SESSION['tel'] = $_POST['tel'];
            $_SESSION['erreur'] = "Vos informations ont été mises à jour avec succès.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour des informations.";
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = "Erreur : " . $e->getMessage();
    }
}

if (isset($_POST['select'])) {
    switch ($_POST['select']) {
        case "compte":
            if ($_SESSION['role'] == 1) {    
                header("Location: ../controlleur/ControlAdmin.php");
            } else {
                header("Location: ../controlleur/ControlProfile.php");
            }
            exit();
        case "deconnexion":
            session_destroy();
            header("Location: ../controlleur/ControlAuth.php");
            exit();
    }
}














// Inclusion de la vue
include("../vue/profile.php");

