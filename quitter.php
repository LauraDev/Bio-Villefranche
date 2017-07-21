<?php session_start();

// nettoyage des variables de session
session_unset(); // ou $_SESSION = array();

// destruction de la session
session_destroy();

// retour à l'accueil
header('location: index.php');