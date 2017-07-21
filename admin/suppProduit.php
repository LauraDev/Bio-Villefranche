<?php session_start();

//insertion du module de connexion
include 'include/connexion.php';

if(!isset($_SESSION['admin']))
{
    header('location: index.php');
}
else 
{
    $safe = strip_tags($_GET['id']); //mr propre
    $rqProd = "DELETE FROM produits WHERE idProduit = :idProduit";
    $stmtProd = $dbh->prepare($rqProd);
    $paramProd = array(':idProduit' => $safe);
    if($stmtProd ->execute($paramProd))
    {
        header('location: admin.php');
    } else
    {
        //insertion du module de connexion
        include 'include/header.php';
        echo '<p class="alert alert-danger">Erreur lors de la supression du produit</p>';
        // insertion du footer
        include 'include/footer.php';
    } 
}