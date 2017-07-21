<?php 

$titrePage = "Bio-Villefranche - Mot de passe perdu";

//insertion de l'entete
include 'include/header.php';

?>
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <!-- formulaire email + password -->
        <form action="perdu2.php" method="post">
            <div class="form-group">
            <label for="mailClient">Email</label>
            <div class="input-group">
                <div class="input-group-addon">@</div>
                <input type="email" name="mailClient" class="form-control" required>
            </div>
            </div>

            <div class="form-group text-center">
            <input type="submit" name="btnSub" value="Entrer" class="btn btn-success"></button>
            </div>

        </form>
    </div>
</div>

<?php

// insertion du footer
include 'include/footer.php';