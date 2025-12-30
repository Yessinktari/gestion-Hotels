<?php
session_start();
require_once "../model/Chambre.php";
require_once "../model/Reservation.php";
require_once "../model/User.php";


$erreur = "";
$chambres = [];


$chambres = Chambre::getChambresDispo(); 

if(isset($_POST['filtrer'])){

    $prixMin = isset($_POST['prix-min']) && $_POST['prix-min'] !== '' ? (int)$_POST['prix-min'] : null;
    $prixMax = isset($_POST['prix-max']) && $_POST['prix-max'] !== '' ? (int)$_POST['prix-max'] : null;
    $type = isset($_POST['select']) && $_POST['select'] !== '' ? $_POST['select'] : null;

    if($type !== null) {
        switch($type) {
            case "simple":
                $type = 0;
                break;
            case "double":
                $type = 1;
                break;
            case "suite":
                $type = 2;
                break;
            default:
                $type = null;
        }
    }

    if($prixMin !== null && $prixMax !== null && $prixMin > $prixMax) {
        $erreur = "Le prix minimum ne peut pas être supérieur au prix maximum.";
    } else {
       $chambres = Chambre::filterChambre($type,$prixMin,$prixMax); // Récupère les chambres disponibles selon les critères de recherche
        if(empty($chambres)) {
            $erreur = "Aucune chambre ne correspond à vos critères de recherche.";
        }
    }
}
elseif(isset($_POST['afficher'])){
    $chambres = Chambre::getChambresDispo(); // Récupère toutes les chambres disponibles

}
else{
    $chambres = Chambre::getChambresDispo(); // Récupère toutes les chambres disponibles
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reserver'])) {
        $numch = $_POST['num'] ?? null;
        if ($numch !== null) {
            header("Location: ../controlleur/ControlReservation.php?num_chambre=" . urlencode($numch));
            exit();
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
}

include("../vue/pageclient.php");