<?php 

$titrePage = "Bio-Villefranche - Contactez-nous";

//insertion de l'entete
include 'include/header.php';

?>
<div class="row formulaireContact">
    <div class="col-md-offset-3 col-md-6">
        <form method="post" action="contact2.php">
            <div class="form-group">
                <label class="obligatoire">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="obligatoire">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="obligatoire">E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="obligatoire">Message</label>
                <textarea name="message" rows="10" class="form-control" required></textarea>
            </div>
            <span class="obligatoire"></span><em>Champs Oligatoires</em>
            <div class="form-group text-center">
                <button type="submit" name="btnSub" class="btn btn-success">Envoyer</button>
            </div>
            

<?php
// insertion du footer
include 'include/footer.php';