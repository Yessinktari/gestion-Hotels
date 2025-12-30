<?php


session_start();
require_once "../model/Chambre.php";
require_once "../model/Reservation.php";
require_once "../model/User.php";

$login = $_SESSION['login'];

$id = $_POST['id'] ?? null;
$num_chambre = $_POST['num_chambre'] ?? null;
$chambre = Chambre::getChambreById($num_chambre);
$reservation = Reservation::getReservationById($id);









include_once "../vue/paiement.php";