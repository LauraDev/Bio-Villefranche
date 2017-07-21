<?php session_start();
// script login2.php
require 'include/connexion.php';

// Mr propre
$safe = array_map('strip_tags', $_POST);
// adress mail existe
$rqVerif = "SELECT COUNT(*) FROM clients WHERE mailClient = :mailClient";
// préparation
$stmtVerif = $dbh->prepare($rqVerif);
// parametres
$paramVerif = array(':mailClient' => $safe['mailClient']);
//execution
$stmtVerif ->execute($paramVerif);
// recuperation
$exist = $stmtVerif->fetchColumn();


// si erreur = 0
if ($exist == 1) {
    // recuperation mdp
    $rqClient = "SELECT idClient, nomClient, prenomClient, passClient FROM clients WHERE mailClient = :mailClient";
    // preparation
    $stmtClient = $dbh->prepare($rqClient);
    // execution
    $stmtClient->execute($paramVerif);
    // info client
    $client = $stmtClient->fetch();
    // comparaison mdp form et mdp BDD
    if (password_verify($safe['passClient'], $client['passClient'])) {
        // client trouvé

        $_SESSION['auth']='ok';
        $_SESSION['nom']=$client['nomClient'];
        $_SESSION['id']=$client['idClient'];
        $_SESSION['prenom']=$client['prenomClient'];
        //sécurité
        session_regenerate_id();

        // Définir une session quantité qui enregistre le nombre d'article ajoutés, enlevés du panier
        // Verif si il existe deja
        $rqVerif = "SELECT COUNT(*)
                        FROM paniers
                        WHERE idClient = :idClient ";
        $stmtVerif = $dbh->prepare($rqVerif); //preparation
        // parameters
        $params = array(':idClient' => $_SESSION['id'] );
        $stmtVerif->execute($params); //execution
        $exists = $stmtVerif->fetchColumn(); //contient 0 ou 1

        // Incrémenter le nombre de produit dans le badge
        $_SESSION['qte'] = $exists;

        // Message de bienvenue et retour accueil
        echo '<script>alert("Bienvenue ' . $client['prenomClient'] . ' ' . $client['nomClient'] .'");
            window.location.href="index.php";
            </script>';
    } else {
        echo '<script>alert("Votre mot de passe est incorrect");
            window.location.href="login.php";
            </script>';
    }
} else {
    echo '<script>alert("Votre email est inconnu");
        window.location.href="login.php";
        </script>';
}
