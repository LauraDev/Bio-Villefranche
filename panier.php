<?php

$titrePage = 'Bio Villefranche - Panier';

include 'include/header.php';



if($_SESSION['qte'] == 0)
{
echo '<p class="alert alert-success"> Votre panier est vide </p>';
}
else //execution du script
{

    //qu'y a-t-il dans mon panier
    $rqPanier = "SELECT p.idPanier, p.idProduit, p.quantite, pr.nom, pr.prix, pr.stocks, pr.photo
                    FROM paniers as p
                    JOIN produits as pr
                    ON p.idProduit = pr.idProduit 
                    WHERE idClient = :idClient";

    //preparation
    $stmtPanier = $dbh->prepare($rqPanier);
    //parametres
    $params = array( ':idClient' => $_SESSION['id'] );
    //execution
    $stmtPanier->execute($params); 
    //recuperation
    $listePanier = $stmtPanier->fetchAll();


    //Creation de la variable total
    $total = 0;
    //Affichage tableau html contenant le panier

    ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom </th>
                    <th> </th>
                    <th>Quantité </th>
                    <th>Prix </th>
                    <th class="text-center">Action </th>
                    <th>Total </th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach($listePanier as $produitCommande)
                    { ?>    <tr>
                                <td> <?= $produitCommande['nom'] ; ?> </td>
                                <td> <?= '<img src="img/'. $produitCommande['photo']. ' " alt=" '. $produitCommande['nom'] .'" class="img-responsive img-circle imagePanier">'; ?> </td>
                                <td> <?= $produitCommande['quantite'] ?> </td>
                                <td> <?= number_format($produitCommande['prix'], 2, ',', ' '); ?> </td>

                                <td> 
                                    <form method="post" action="modifPanier.php" class="form-inline text-center">
                                        <input type="hidden" name="idPanier" value=" <?= $produitCommande['idPanier']  ?> ">
                                        <input type="number" name="quantite" class="form-control" min="0" max=" <?= $produitCommande['stocks'] ?> " value="<?=$produitCommande['quantite']?>">
                                        <button type="submit" name="btnModif"> <span class="ion-compose"></span> </button>
                                        <button type="submit" name="btnSuppr"> <span class="ion-trash-a"></span> </button>
                                    </form> 
                                </td>

                                <td> <?=  number_format($produitCommande['prix'] * $produitCommande['quantite'] , 2, ',', ' ');  ?> </td>
                            </tr>

                            <?php $total += $produitCommande['prix'] *  $produitCommande['quantite'];
                    }
                ?>

            </tbody>
            <tfoot>
                <tr class="success">
                    <td colspan="5" class="text-right"> <strong> A payer </strong> </td>
                    <td> <strong> <?= number_format($total, 2, ',', ' '); ?> </strong> </td>
                </tr>
            </tfoot>
        </table>

        <div class="text-center">
            <a href="validePanier.php" class="btn btn-lg btn-success"> Commander </a>
        </div>


    <?php 


    //enregistrement du montant total dans une session
    $_SESSION['totalFact'] = $total;
}

//inclure le footer
include 'include/footer.php';