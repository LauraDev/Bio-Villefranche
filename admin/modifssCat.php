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
    $rqCat = "UPDATE scategories SET libSCategorie= :libSCategorie WHERE idSCategorie= :idSCategorie";
    $stmtCat = $dbh->prepare($rqCat);
    $paramCat = array(':libSCategorie' => $safe['libSCategorie'], ':idSCategorie' => $safe['idSCategorie']);
    if($stmtCat ->execute($paramCat))
    {
        header('location: admin.php');
    } else
    {
        //insertion du module de connexion
        include 'include/header.php';
        echo '<p class="alert alert-danger">Erreur lors de la modification de la sous-catégorie</p>';
        // insertion du footer
        include 'include/footer.php';
    }
}