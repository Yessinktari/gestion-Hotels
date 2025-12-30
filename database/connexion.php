<?php


try {
    $conn = new PDO('mysql:host=localhost;dbname=bdreservation', 'root', '');
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
