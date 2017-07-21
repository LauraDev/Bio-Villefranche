<?php 

$titrePage = "Bio-Villefranche - Administration";

//insertion de l'entete
include 'include/header.php';

?>

    <form method="post" action="admLogin2.php">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group text-center">
            <button type="submit" name="btnSub" class="btn btn-lg btn-danger">Entrer</button>
        </div>
    </form>
            

<?php
// insertion du footer
include 'include/footer.php';