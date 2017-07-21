<?php 

$titrePage = "Bio-Villefranche - Réinitialisation de votre Mot de Passe";

//insertion de l'entete
include 'include/header.php';

$token = strip_tags($_GET['token']); 
//recuperer l'ID du client
$rqClient = "SELECT idClient FROM clients WHERE token = :token";
    // preparation
    $stmtClient = $dbh->prepare($rqClient);
    //parametres
    $params = array(':token'=>$token);
    // execution
    $stmtClient->execute($params);
    // info client
    $idClient = $stmtClient->fetchColumn(); //une seule info a recuperer
    // comparaison token recu et token BB

if($idClient != false)
{
    ?>
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <!-- formulaire email pour envoi mot de passe perdu -->
        <form action="perdu4.php" method="post">
            <input type="hidden" name="idClient" value="<?=$idClient?>">

            <div class="form-group">
            <label for="passClient">Nouveau mot de passe</label>
            <div class="input-group">
                <div class="input-group-addon"><span class="ion-android-lock"></span></div>
                    <input type="password" name="passClient" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
            <label for="passClient">Confirmer votre nouveau mot de passe</label>
            <div class="input-group">
                <div class="input-group-addon"><span class="ion-android-lock"></span></div>
                    <input type="password" name="passClient2" class="form-control" required>
                </div>
            </div>

            <div class="form-group text-center">
            <input type="submit" name="btnSub" value="Entrer" class="btn btn-success"></button>
            <a href="perdu.php">Demande de Modification<a>
            </div>

        </form>
    </div>
</div>

<?php
}
else echo '<p class="alert alert-danger">Erreur lors de la procédure de réinitialisation de votre mot de passe</p>';

///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////// VERIFICATION JAVASCRIPT QUE LES 2 MPD SONT LES MEME ////////////////////////////

// insertion du footer
include 'include/footer.php';