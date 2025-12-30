<?php
require_once "../model/User.php";
session_start();

// Initialisation des variables de session
$_SESSION['role'] = 0;
$_SESSION['login'] = "";
$_SESSION['nom'] = "";
$_SESSION['password'] = "";
$_SESSION['email'] = "";
$_SESSION['adresse'] = "";
$_SESSION['tel'] = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs";
    } else {
        if ($user = User::connect($login, $password)) {
            $_SESSION['role'] = $user->role;
            $_SESSION['login'] = $login;
            $_SESSION['nom'] = $user->nom;
            $_SESSION['password'] = $password;
            $_SESSION['email'] = $user->email;
            $_SESSION['adresse'] = $user->adresse;
            $_SESSION['tel'] = $user->tel;
            
            if($user->role == 1) {
                header("Location: ../controlleur/ControlAdmin.php");
                exit();
            } else {
                header("Location: ../controlleur/Controlpageclient.php");
                exit();
            }
        } else {
            $_SESSION['erreur'] = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
}

include("../vue/authentification.php");
?>