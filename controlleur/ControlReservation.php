<?php

require_once "../model/Chambre.php";
require_once "../model/Reservation.php";
require_once "../model/User.php";

session_start();

$login = $_SESSION['login'] ?? null;
$erreur = "";
$chambre = null;
$prix = 0;
$datefin = null;
$dateDeb = null;
$typeres = null;
$id = null;


if (!$login) {
    header("Location: ../vue/authentification.php");
    exit();
}


$num = isset($_GET['num_chambre']) ? trim($_GET['num_chambre']) : null;
$chambre = Chambre::getChambreById($num);

$user = User::getUserByLogin($login);

if (!$chambre) {
    $erreur = "Aucune chambre disponible pour le type sélectionné.";
}

if (isset($_POST['envoyer'])) {
    $dateDeb = isset($_POST['dateDeb']) ? trim($_POST['dateDeb']) : null;
    $dateFin = isset($_POST['dateFin']) ? trim($_POST['dateFin']) : null;
    $typeres = isset($_POST['select']) ? trim($_POST['select']) : null;
    if($typeres == "all"){
        $type = 3;
    }elseif($typeres == "complet"){
        $type = 2;
    }elseif($typeres == "demi"){
        $type = 1;
    }elseif($typeres == "petit-déjeuner"){
        $type = 0;
    }
    $nbpersonnes = isset($_POST['nbpersonnes']) ? trim($_POST['nbpersonnes']) : null;
    $nbnuits = isset($_POST['nbnuits']) ? trim($_POST['nbnuits']) : null;
    $desc = isset($_POST['desc']) ? trim($_POST['desc']) : null;
    
    if(Reservation::getlastid() == null){
        $id = 1;
    }else{
        $id = Reservation::getlastid() + 1;
    }

if($dateDeb == null){
    $erreur = "Veuillez remplir la date de début";
}elseif($dateFin == null){
    $erreur = "Veuillez remplir la date de fin";
}elseif($typeres == null){
    $erreur = "Veuillez remplir le type de réservation";
}elseif($nbpersonnes == null){
    $erreur = "Veuillez remplir le nombre de personnes";
}elseif($nbnuits == null){
    $erreur = "Veuillez remplir le nombre de nuits";
}elseif($desc == null){
    $erreur = "Veuillez remplir les spécifications";
}elseif($dateDeb > $dateFin){
    $erreur = "La date de début ne peut pas être supérieure à la date de fin";
}elseif($nbpersonnes < 1 || $nbpersonnes > 10){
    $erreur = "Le nombre de personnes doit être compris entre 1 et 10";
}elseif($nbnuits < 1){
    $erreur = "Le nombre de nuits doit être supérieur à 0";
}elseif(Reservation::checkAvailability($num, $dateDeb, $dateFin)){
    $erreur = "La chambre n'est pas disponible pour les dates sélectionnées";
}else{
    // Calcul du prix en fonction du type de réservation
    $prix_base = $chambre->prix_nuit * $nbpersonnes * $nbnuits;
    
    switch($typeres) {
        case "all":
            $prix = $prix_base +50; // 50% de plus pour all inclusive
            break;
        case "complet":
            $prix = $prix_base +80; // 30% de plus pour pension complète
            break;
        case "demi":
            $prix = $prix_base + 120; // 20% de plus pour demi-pension
            break;
        case "petit-déjeuner":
            $prix = $prix_base + 160; // 10% de plus pour petit-déjeuner
            break;
        default:
            $prix = $prix_base;
    }
    
    $reservation = new Reservation($id,$user,$chambre,$dateDeb, $dateFin, $type, $nbpersonnes, $nbnuits, $prix, $desc, 0);
    Reservation::addReservation($reservation);
    $_SESSION['erreur'] = "Réservation effectuée avec succès";
    header("Location: ../controlleur/Controlprofile.php?id=".$id);
    exit();
}
    
}





include("../vue/pageReservation.php");  