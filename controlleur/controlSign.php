<?php


require_once "../model/User.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $tel = $_POST['telephone'];
    $adresse = $_POST['adresse'];
   
    $role = 0; 

    if (empty($login) || empty($password) || empty($tel) || empty($email) || empty($adresse) || empty($nom) ) {
        $_SESSION['erreur'] ="<h2 style='color: red;'>Tous les champs sont obligatoires</h2>";
    } else {
        if (User::userExists($login, $email, $tel)) {
            $_SESSION['erreur'] = "Ce nom d'utilisateur existe déjà";
        } else {
        $user = new User($login, $password, $nom, $role, $email, $adresse, $tel);
        $user->register();
        header("Location: ../controlleur/ControlAuth.php");
        exit();
    }


}

}
include("../vue/signup.php");
?>