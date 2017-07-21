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

    $rqVerif = "SELECT COUNT(*) 
                FROM scategories
                WHERE  libSCategorie = :libSCategorie ";
    $stmtVerif = $dbh->prepare($rqVerif); //preparation
    // parameters
    $paramCat = array(':libSCategorie' => $safe['libSCategorie']);
    $stmtVerif->execute($paramCat); //execution
    $exists = $stmtVerif->fetchColumn(); //contient 0 ou 1
    // echo $exists;
    if( $exists == 0) 
    {

        $rqCat = "INSERT INTO scategories (idCategorie, libSCategorie) VALUES (:idCategorie, :libSCategorie) ";
        $stmtCat = $dbh->prepare($rqCat);
        $paramCat = array(':idCategorie' => $safe['idCategorie'], ':libSCategorie' => $safe['libSCategorie']);
        if($stmtCat ->execute($paramCat))
        {
            header('location: admin.php');
        } else echo '<p class="alert alert-danger">Erreur lors de la création de la sous-catégorie</p>';
    }
    else 
    {
        //insertion du module de connexion
        include 'include/header.php';
        echo '<p class="alert alert-danger"> cette sous-catégorie existe déja</p>';
        // insertion du footer
        include 'include/footer.php';
    }

}