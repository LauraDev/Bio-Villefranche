<?php session_start();

include 'include/connexion.php';


//Mr propre
$safe= array_map('strip_tags', $_POST);
// print_r($_POST);

// Si bouton suppr a été cliqué
if( isset($safe['btnSuppr'] ) )
{

// requete
    $rqSuppr = "DELETE 
                FROM paniers
                WHERE idPanier = :idPanier ";

//preparation
$stmtSuppr = $dbh->prepare($rqSuppr);
//parametres
$params = array( ':idPanier' => $safe['idPanier'] );
//execution
$add = $stmtSuppr->execute($params); 


        // Décrémenter un produit (dans le badge)
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
}

// Si bouton suppr a été cliqué
if( isset($safe['btnModif'] ) )
{
$rqAjout = "UPDATE paniers
            SET quantite = :quantite
            WHERE idPanier = :idPanier ";

//preparation
$stmtAjout = $dbh->prepare($rqAjout);
//parametres
$params = array(  ':idPanier' => $safe['idPanier'] , ':quantite' => $safe['quantite'] );
//execution
$add = $stmtAjout->execute($params); 
}



// si ajout/modif a fonctionner::
if($add !==false)
{
    header('location: panier.php');
} 
else echo '<p> Oups </p>';
