<?php

$titrePage = "Bio-Villefranche - Nos Produits";

// entete
include 'include/header.php';


//Mr property
$id = strip_tags($_GET['id']);

//requete
$rqProduits = "SELECT p.idProduit, p.origine, p.prix, p.poids, p.pxkilo, p.dluo, p.reference, p.description, p.stocks, p.photo, p.nom, p.delaisLivraison, f.RS
                FROM produits as p
                JOIN fournisseurs as f
                ON p.idFournisseur = f.idFournisseur
                WHERE idSCategorie = ?";
// preparation
$stmtProduits = $dbh->prepare($rqProduits);
// parametres
$params = array($id);
// execution
$stmtProduits->execute($params);
// récupération
$listeProduits = $stmtProduits->fetchAll();
// CTRL
// echo '<pre>';
// print_r($listeProduits);
// echo '</pre>';

//boucle d'affichage
echo '<section class="row">';
foreach($listeProduits as $index => $produit)
{
    ?> 
        <!--une section pour trois articles-->
        <article class="panel panel-default col-md-4">
            <!--un article par produit-->
            <h3 class="text-center"> <?= $produit['nom']; ?> </h3>
            <?= '<img src="img/'. $produit['photo']. ' " alt=" '. $produit['nom'] .'" class="img-responsive img-circle imageProduit">'; ?>

            <!-- <p><strong> Identifiant: </strong><?= $produit['idProduit']; ?> </p> -->
            <p><strong> Origine: </strong><?= $produit['origine']; ?> </p>
            <p><strong> Prix: </strong><?= $produit['prix']; ?> € </p>
            <p><strong> Poids: </strong><?= $produit['poids']; ?> kg </p>
            <!-- <p><strong> Prix au kilo: </strong><?= $produit['pxkilo']; ?> €/kg </p> -->
            <p><strong> DLUO: </strong><?= $produit['dluo']; ?> </p>
            <!-- <p><strong> Référence: </strong><?= $produit['reference']; ?> </p> -->
            <p><strong> Description: </strong><?= $produit['description']; ?> </p>
            <p><strong> Délais de livraison: </strong><?= $produit['delaisLivraison']; ?> jours </p>
            <p><strong> Fournisseur: </strong><?= $produit['RS']; ?> </p>

            <?php
            // acheter si l'utilisateur est connecté et produit en stock
            if (isset($_SESSION['auth']))
            {
                if($produit['stocks'] >0)
                {
                    // formulaire pour passer commande
                    echo '<form method="post" action="commander.php">';
                    echo '<input type="hidden" name="idProduit" value=" '. $produit['idProduit']. ' ">';
                    echo '<input type="hidden" name="cat" value=" '. $id. ' ">';
                    echo ' <div class="form-group"> <label> Quantité </label>
                            <input type="number" name="quantite" class="form-control" min="1" max="'. $produit['stocks'].'"> </div> 
                            <div class="form-group text-center">
                            <input type="submit" name="btnSub" class="btn btn-success" value="Commander"> </div>';
                    echo '</form>';
                } else echo '<p class="text-center rupture"><strong> Rupture de stock </strong></p>';
            }
            else
            {
                echo '<p class="text-center"><em> Vous devez vous identifier pour commander</em></p>';
            }
            ?>
        </article> 

    <?php
    if($index > 0 AND (($index+1) % 3 ) == 0) echo '</section><section class="row">';

}
echo '</section>';



// pied de page
include 'include/footer.php';