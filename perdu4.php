<?php 

$titrePage = "Bio-Villefranche - Mot de passe perdu";

//insertion de l'entete
include 'include/header.php';
include 'include/toolbox.php';

// changer le mdp dans la BDD
// Récupération des infos client
$safe = array_map('strip_tags', $_POST); 

//mot de passe identique
if($safe['passClient'] !== $safe['passClient2'])
{
    echo '<p class="alert alert-danger">Les mots de passe doivent être identitiques <a href="#" onclick="window.history.go(-1); return false;">Recommencer</a></p>';
}
else 
{
    if( verifPassword($safe['passClient']) == true ) //appel de la fonction toolbox de verif du mot de passe
    {
        //mise a jour du mdp dans BDD et suppression du token
        $hash = password_hash($safe['passClient'], PASSWORD_DEFAULT);
        $rqMdp = "UPDATE clients SET passClient = :passClient, token = ''  WHERE idClient = :idClient"; // recuperation des infos client
        $stmtMdp = $dbh->prepare($rqMdp); // preparation
        $param = array(':passClient'=> $hash, ':idClient'=> $safe['idClient']); //parametres
        if($stmtMdp->execute($param)) // execution
        {
            echo '<p class="alert alert-success">Votre mot de passe a été modifié</p>';
        }
        else echo '<p class="alert alert-danger">Erreur lors de la procédure de réinitialisation de votre mot de passe</p>';
    }
    else echo '<div class="alert alert-danger">Le mot de passe doit contenir plus de 8 lettres, au moins un chiffre et une majuscule <a href="#" onclick="window.history.go(-1); return false;">Recommencer</a> </div>';
}





// insertion du footer
include 'include/footer.php';