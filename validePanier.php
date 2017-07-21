<?php session_start();


if($_SESSION['qte'] == 0)
{
    // inclure l'entete
    include 'include/header.php';
    echo '<p class="alert alert-success"> Merci de votre confiance <p>';
}
else //execution du script
{
    // inclure l'entete
    include 'include/connexion.php';
    //creation de variables
    $idClient = $_SESSION['id'];
    $totalFacture = $_SESSION['totalFact'];

    // requete
    $rqPanier = "SELECT idPanier , idClient, idProduit, quantite
                    FROM paniers
                    WHERE idClient = $idClient ";
    $stmtPanier = $dbh->prepare($rqPanier); //preparation
    $params = array( ':idClient' => $idClient ); // parameters
    $stmtPanier->execute($params); //execution
    $contenuPanier = $stmtPanier->fetchAll();
    // print_r($contenuPanier);




    // Generer une facture
    $rqFact = "INSERT INTO factures(idCLient, idReglement, montant, dateFacture)
                VALUES (:idClient, 0, :totalFacture, NOW() ) " ;
    $stmtFact = $dbh->prepare($rqFact);
    //parametres
    // le $params de la requette precédente contient l'ID client donc on peut s'en resservir
    $param = array( ':idClient' => $idClient, ':totalFacture' => $totalFacture ); // parameters
    $stmtFact->execute($param); 
    //recuperation de l'id
    $idFacture = $dbh->lastInsertId();



    // création d'un fichier csv pour la recuperation de la commande
    $fd = fopen('bonsCommande/panier_'.date('dmYHis').'_'.$idClient.'.csv', 'w');

    // boucle sur le panier
    foreach($contenuPanier as $artPanier)
    {
        //ecriture dans le fichier csv (chaque ligne séparée par ; )
        fputcsv($fd, $artPanier, ';');



        //écrire dans la table facturedetails (bdd)
        $rqFact = "INSERT INTO facturedetails(idFacture, idProduit, quantite)
                VALUES (:idFacture, :idProduit, :quantite) " ;
        $stmtFact = $dbh->prepare($rqFact);
        //parametres
        $params2 = array( ':idFacture' => $idFacture, ':idProduit' => $artPanier['idProduit'], ':quantite' => $artPanier['quantite'] );
        //execution
        $stmtFact->execute($params2); 
        //recuperation de l'id de la facture (besoin pour la table details facture)
        // $idFacture = $dbh->lastInsertId();



        // Effacer le panier dans la bdd
        $rqDel = "DELETE FROM paniers
                    WHERE idClient = :idClient ";
        $stmtDel = $dbh->prepare($rqDel);
        //parametres
        // on utilise encore le meme $params
        //execution
        $add2 = $stmtDel->execute($params); 
        // si modif a fonctionner:
            if($add2 !==false)
            {
                // Modifier la valeur dans le badge
                $_SESSION['qte'] = 0; // $exists;
                // echo $_SESSION['qte'].'dans le badge';

                // Modifier le stock de chaque produit dans la BDD
                $rqStock = "UPDATE produits
                                SET stocks = stocks - :quantite
                                WHERE idProduit = :idProduit ";
                    $stmtStock = $dbh->prepare($rqStock);
                    //parametres
                    $params4 = array( ':idProduit' => $artPanier['idProduit'], ':quantite' => $artPanier['quantite'] );
                    //execution
                    $add3 = $stmtStock->execute($params4); 
                    // si modif a fonctionner:
                        // if($add3 !==false)
                        // {
                        //     echo '<p> Votre panier a bien été validé </p>';
                        // } 
                        // else echo '<p> Oups </p>';


            } 
            else echo '<p> Oups </p>';



    }
    // inclure l'entete
    include 'include/header.php';

    echo 'numéro de facture: ' .$idFacture.'<br>Montant à régler: ' . $totalFacture .'<br>';

    ?>
    
    <div class="text-center">
	<form action="https://www.paypal.com/cgi-bin/webscr"
			method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" 
				    value="XBCCCCUKVNN6L">
		<input type="hidden" name="amount" value="<?=$totalFacture;?>">
		<input type="hidden" name="item_name" value = "Facture N°<?=$idFacture;?>" >
		<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_buynowCC_LG.gif" 
		border="0" name="submit" 
		alt="PayPal, le réflexe sécurité pour payer en ligne">
		<img alt="" border="0" 
				src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
	</form>
</div>
    <?php

}



// inclure le footer
include 'include/footer.php';