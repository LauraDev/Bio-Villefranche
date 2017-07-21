<?php
  // fichier inscription.php
  $titrePage = 'BioVillefranche - Inscription';
  require 'include/header.php';
    ?>

  <div class="row">
    <div class="col-md-offset-3 col-md-6">
      <form action="ajoutClient.php" method="post">

        <div class="form-group">
          <label for="nomClient">Nom</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
            <input type="text" class="form-control" name="nomClient" required>
          </div>
        </div>

        <div class="form-group">
          <label for="prenomClient">Prénom</label>
          <input type="text" class="form-control" name="prenomClient" required>
        </div>

        <div class="form-group">
          <label for="adresseClient">Adresse</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
            <input type="text" class="form-control" name="adresseClient" required>
          </div>
        </div>

        <div class="form-group">
          <label for="cpClient">Code postal</label>
          <input type="text" class="form-control" name="cpClient" maxlength="5" required>
        </div>

        <div class="form-group">
          <label for="villeClient">Ville</label>

          <input type="text" class="form-control" name="villeClient" required>
        </div>

        <div class="form-group">
          <label for="mailClient">Mail</label>
          <div class="input-group">
            <div class="input-group-addon">@</div>
            <input type="mail" class="form-control" name="mailClient" required>
          </div>
        </div>

        <div class="form-group">
          <label for="telClient">Telephone</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
          <input type="text" class="form-control" name="telClient" required>
          </div>
        </div>

        <div class="form-group">


            <label for="passClient">Mot de passe</label>
              <div class="input-group">
            <div class="input-group-addon"><span class="ion-android-lock"></span></div>
            <input type="password" class="form-control" name="passClient" required>
          </div>
        </div>

        <div class="form-group text-center">
          <input type="submit" class="btn btn-success" name="btnSub" value="S'inscrire">
        </div>

      </form>
    </div>
  </div>


    <?php
    require 'include/footer.php';
    ?>
