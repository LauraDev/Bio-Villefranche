<?php session_start();

//insertion du module de connexion
include 'include/connexion.php';

if(!isset($_SESSION['admin']))
{
    header('location: index.php');
}
else 
{
    $safe = array_map('strip_tags', $_POST); //mr propre




    // I- CONTROLE DES INPUTS
    if (!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse mail invalide';
    }
    
    if (trim($safe['nom']) == NULL OR trim($safe['prenom'])== NULL OR trim($safe['RS'])== NULL ) {
        $errors[] = 'Le nom, prénom et raison sociale sont obligatoires';
    }


    if (count($errors) == 0) 
    {   




        // II- ENREGISTREMENT DANS LA BDD
        $rqVerif = "SELECT COUNT(*) 
                FROM fournisseurs
                WHERE  RS = :RS ";
        $stmtVerif = $dbh->prepare($rqVerif); //preparation
        // parameters
        $paramCat = array(':RS' => $safe['RS']);
        $stmtVerif->execute($paramCat); //execution
        $exists = $stmtVerif->fetchColumn(); //contient 0 ou 1
        // echo $exists;
        if( $exists == 0) 
        {

            $rqCat = "INSERT INTO fournisseurs (nomFournisseur, prenomFournisseur, RS, emailFournisseur, telFournisseur, rueFournisseur, cpFournisseur, villeFournisseur) 
                                VALUES (:nomFournisseur, :prenomFournisseur, :RS, :emailFournisseur, :telFournisseur, :rueFournisseur, :cpFournisseur, :villeFournisseur) ";
            $stmtCat = $dbh->prepare($rqCat);
            $paramCat = array(':nomFournisseur'=> $safe['nom'], ':prenomFournisseur'=> $safe['prenom'], ':RS'=> $safe['RS'], ':emailFournisseur'=> $safe['email'], ':telFournisseur'=> $safe['tel'], ':rueFournisseur'=> $safe['rue'], ':cpFournisseur'=> $safe['cp'], ':villeFournisseur'=> $safe['ville']);
            if($stmtCat ->execute($paramCat))
            {
                header('location: admin.php');
            } else echo '<p class="alert alert-danger">Erreur lors de la création du fournisseur</p>';
        }
        else 
        {
            //insertion du module de connexion
            include 'include/header.php';
            echo '<p class="alert alert-danger"> cette catégorie existe déja</p>';
            // insertion du footer
            include 'include/footer.php';
        }

    }
    // Message d'erreur
    else {
        $liste = '';  //chaine vide
        // pour chaque erreur
    foreach ($errors as $error) {
        $liste = '<li>' . $error . '</li>';
        }
        include 'include/header.php';
        echo '<div class="alert alert-danger">Des erreurs sont à corriger: <ul>' . $liste . '</ul></div>';
        include 'include/footer.php';
    }
}

