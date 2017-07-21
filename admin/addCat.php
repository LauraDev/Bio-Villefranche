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
                FROM categories
                WHERE  libCategorie = :libCategorie ";
    $stmtVerif = $dbh->prepare($rqVerif); //preparation
    // parameters
    $paramCat = array(':libCategorie' => $safe['libCategorie']);
    $stmtVerif->execute($paramCat); //execution
    $exists = $stmtVerif->fetchColumn(); //contient 0 ou 1
    // echo $exists;
    if( $exists == 0) 
    {

        $rqCat = "INSERT INTO categories (libCategorie) VALUES (:libCategorie) ";
        $stmtCat = $dbh->prepare($rqCat);
        $paramCat = array(':libCategorie' => $safe['libCategorie']);
        if($stmtCat ->execute($paramCat))
        {
            header('location: admin.php');
        } else echo '<p class="alert alert-danger">Erreur lors de la création de la catégorie</p>';
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