<?php session_start();

echo '<pre>';
print_r($_POST);
echo '</pre>';

include 'include/connexion.php';

// Verification
// print_r($dbh); //affiche pdo Object() si ok

$safe = array_map('strip_tags', $_POST);
$idClient = $_SESSION['id']; // id du client;

// Verif si il existe deja
$rqVerif = "SELECT COUNT(*)
                FROM paniers
                WHERE  idProduit = :idProduit
                AND idCLient = :idClient ";
$stmtVerif = $dbh->prepare($rqVerif); //preparation
// parameters
$params = array(':idClient' => $idClient, ':idProduit' => $safe['idProduit']);
$stmtVerif->execute($params); //execution
$exists = $stmtVerif->fetchColumn(); //contient 0 ou 1
// echo $exists;
if( $exists == 0) 
{
    // si n'existe pas, creer la ligne idCLient, idProduit, quantite
    $rqAjout = "INSERT INTO paniers(datePanier, idClient, idProduit, quantite )
                    VALUES ( NOW(), :idClient, :idProduit, :quantite )";
}
else 
{
    // si exist, modification de la valeur dans le panier
    $rqAjout = "UPDATE paniers
                SET quantite = quantite + :quantite
                WHERE idClient = :idClient
                AND idProduit = :idProduit ";
}
//preparation
$stmtAjout = $dbh->prepare($rqAjout);
//parametres
$params = array( ':idClient' => $idClient, ':idProduit' => $safe['idProduit'], ':quantite' => $safe['quantite'] );
//execution
$add = $stmtAjout->execute($params); 

// changement de la valeur du stock
// $rqAjout2 = "UPDATE produits
//                 SET stocks = stocks - :quantite
//                 WHERE idProduit = :idProduit ";
// $stmtAjout2 = $dbh->prepare($rqAjout2);
// //parametres
// $params2 = array( ':idProduit' => $safe['idProduit'], ':quantite' => $safe['quantite'] );
// //execution
// $add2 = $stmtAjout2->execute($params2); 

// si ajout a fonctionner:
    if($add !==false)
    {
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
        header('location: produits.php?id='.$safe[cat].'');
    } 
    else echo '<p> Oups </p>';