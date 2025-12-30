<?php
require_once "../model/Chambre.php";
require_once "../model/Reservation.php";
require_once "../model/User.php";
session_start();

// Vérification si l'utilisateur est connecté et est admin
if (!isset($_SESSION['login'])) {
    header("Location: ../vue/authentification.php");
    exit();
}

// Récupération des données
$chambres = Chambre::getChambres();
$reservations = Reservation::getReservations();
$users = User::getAllUsers();


if (isset($_POST['modifierInfo'])) {
    try {
        $login = $_SESSION['login'];
        $password = $_SESSION['password'];
        $role = $_SESSION['role'];
        $nom = $_POST['nom'] ?? null;
        $email = $_POST['email'] ?? null;
        $adresse = $_POST['adresse'] ?? null;
        $tel = $_POST['tel'] ?? null;

        $user = new User($login, $password, $nom, $email,1,$adresse, $tel);
        if (User::updateUser($user)) {
            $_SESSION['nom'] = $_POST['nom'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['adresse'] = $_POST['adresse'];
            $_SESSION['tel'] = $_POST['tel'];
            $_SESSION['erreur_profil'] = "Vos informations ont été mises à jour avec succès.";
        } else {
            $_SESSION['erreur_profil'] = "Erreur lors de la mise à jour des informations.";
        }
    } catch (Exception $e) {
        $_SESSION['erreur_profil'] = "Erreur : " . $e->getMessage();
    }
}




/////////// reservation ////////////////////////////////////////

if(isset($_POST['approuver'])){
    $id = $_POST['id'] ?? null;
    $num_chambre = $_POST['num_chambre'] ?? null;
    $chambre = Chambre::getChambreById($num_chambre);
    if ($id !== null) {
        $reservation = Reservation::getReservationById($id);
        if ($reservation) {
            $reservation->setStatut(1);
            Reservation::updateReservation($reservation);
            if ($chambre) {
                $chambre->setDispo(1);
                Chambre::updateChambre($chambre);
                header("Location: ../controlleur/ControlAdmin.php");
                exit();
            }
        }
    }
}

if(isset($_POST['refuser'])){
    $id = $_POST['id'] ?? null;
    if ($id !== null) {
        $reservation = Reservation::getReservationById($id);
        if ($reservation) {
            // Mettre à jour le statut de la réservation à 2 (refusé)
            $reservation->setStatut(2);
            Reservation::updateReservation($reservation);
            
            // Redirection pour éviter le rechargement du formulaire
            header("Location: ControlAdmin.php");
            exit();
        }
    }
}




////////////////////////// chambre //////////////////////////////////// 

if(isset($_POST['supprimerChambre'])){
    $num_chambre = $_POST['num_chambre'] ?? null;
    if ($num_chambre !== null && Reservation::getReservationsByChambre($num_chambre) == null) {
        Chambre::deleteChambre($num_chambre);
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
    else{
        $_SESSION['erreur_chambre'] = "Erreur : La chambre est déjà réservée.";
    }
}


if(isset($_POST['modifierChambre'])){

    $num_chambre = $_POST['num_chambre'] ?? null;
    $prix_nuit = $_POST['prix_nuit'] ?? null;
    $description = $_POST['description'] ?? null;
    $type = $_POST['type'] ?? null;
    $dispo = $_POST['dispo'] ?? null;
    $photo = $_POST['photo'] ?? null;
    $chambre = new Chambre($num_chambre, $type, $prix_nuit, $dispo, $description, $photo);
    if(Chambre::updateChambre($chambre)){
        $_SESSION['erreur_chambre'] = "Chambre modifiée avec succès.";
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
    else{
        $_SESSION['erreur_chambre'] = "Erreur lors de la modification de la chambre.";
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
}


//////////////////////// user ///////////////////////////////////////////////


if(isset($_POST['supprimerUser'])){
    $login = $_POST['login'] ?? null;
    $user = User::getUserByLogin($login);
    if ($login !== null && $user != null) {

        if(Reservation::getReservationEnAttendByLogin($login) != null){
            $_SESSION['erreur_user'] = "Erreur : L'utilisateur a des réservations en attente.";
            header("Location: ../controlleur/ControlAdmin.php");
            exit();
        }
        else{
            User::deleteUser($login);
            $_SESSION['erreur_user'] = "Utilisateur supprimé avec succès."; 
            header("Location: ../controlleur/ControlAdmin.php");
            exit();
        }
    }
    else{
        $_SESSION['erreur_user'] = "Erreur : L'utilisateur n'existe pas.";
    }
}

if(isset($_POST['modifierUser'])){

    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;
    $nom = $_POST['nom'] ?? null;
    $email = $_POST['email'] ?? null;
    $tel = $_POST['tel'] ?? null;
    $role = $_POST['role'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $user = new User($login, $password, $nom,$role,$email, $adresse, $tel);
    if(User::updateUser($user)){
        $_SESSION['erreur_user'] = "Utilisateur modifié avec succès.";
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
    else{
        $_SESSION['erreur_user'] = "Erreur lors de la modification de l'utilisateur.";
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
}


if(isset($_POST['ajouterUser'])){
    $_SESSION['show_add_user_row'] = true;
}


if(isset($_POST['validerAjoutUser'])){
    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;
    $nom = $_POST['nom'] ?? null;
    $email = $_POST['email'] ?? null;
    $tel = $_POST['tel'] ?? null;
    $role = $_POST['role'] ?? null;
$adresse = $_POST['adresse'] ?? null;

if(User::userExists($login, $email, $tel)){
    $_SESSION['erreur_user'] = "Erreur : L'utilisateur existe déjà.";
    header("Location: ../controlleur/ControlAdmin.php");
    exit();
}
else{
    $role = $role == 1 ? 1 : 0;
    
    $user = new User($login, $password, $nom, $role, $email, $adresse, $tel);
    if($user->register()){
        $_SESSION['erreur_user'] = "Utilisateur ajouté avec succès.";
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
    else{
        $_SESSION['erreur_user'] = "Erreur lors de l'ajout de l'utilisateur.";
        header("Location: ../controlleur/ControlAdmin.php");
        exit();
    }
}
}

if(isset($_POST['annulerAjoutUser'])){
    $_SESSION['show_add_user_row'] = false;
    header("Location: ../controlleur/ControlAdmin.php");
    exit();
}
/********************** Chambre ***************************************** */

if(isset($_POST['ajouterChambre'])){
    $_SESSION['show_add_ch_row'] = true;
}

if(isset($_POST['validerAjoutCh'])){
    $num_chambre = $_POST['num_chambre'] ?? null;
    $type = $_POST['type'] ?? null;
    $prix = $_POST['prix'] ?? null;
    $dispo = $_POST['dispo'] ?? null;
    $description = $_POST['description'] ?? null;

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        move_uploaded_file($photo_tmp, "../vue/photos/" . $photo_name);
        $photo = "../vue/photos/" . $photo_name;

        if(Chambre::getChambreById($num_chambre)!= null){
            $_SESSION['erreur_chambre'] = "Erreur : Chambre existe déjà.";
            header("Location: ../controlleur/ControlAdmin.php");
            exit();
        }else{
        $chambre = new Chambre($num_chambre, $type, $prix, $dispo, $description, $photo);
            if(Chambre::addChambre($chambre)){
                $_SESSION['erreur_chambre'] = "Chambre ajoutée avec succès.";
                header("Location: ../controlleur/ControlAdmin.php");
                exit();
            }else{
                $_SESSION['erreur_chambre'] = "Erreur lors de l'ajout de la chambre.";
                header("Location: ../controlleur/ControlAdmin.php");
                exit();
            }
    }
  }
  else {
    $_SESSION['erreur_chambre'] = "Veuillez sélectionner une photo.";
    header("Location: ../controlleur/ControlAdmin.php");
            exit();

}
}
    
if(isset($_POST['annulerAjoutCh'])){
    $_SESSION['show_add_ch_row'] = false;
    header("Location: ../controlleur/ControlAdmin.php");
    exit();
}




include("../vue/pageadmin.php");
