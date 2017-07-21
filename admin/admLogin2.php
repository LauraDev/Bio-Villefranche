<?php session_start();

// Mr propre
$safe = array_map('strip_tags', $_POST);

//Vérificatyion login + password
if($safe['login'] == 'admin' && $safe['password'] == 'admin' )
{
    $_SESSION['admin'] = 'ok';
    $_SESSION['nom'] = 'Admin';
    $_SESSION['prenom'] = 'Admin';
    $_SESSION['id'] = 0;
    $_SESSION['qte'] = 0;
    $_SESSION['auth'] = 'ok';
    header('location:admin.php');
}
//redirection au formulaire si non reconnu
else header('location:admLogin.php');