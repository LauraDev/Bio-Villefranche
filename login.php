<?php
  // script login.php
  $titrePage = 'BioVillefranche - Connexion';
  include 'include/header.php';
?>
  <div class="row">
    <div class="col-md-offset-3 col-md-6">
      <!-- formulaire email pour envoi mot de passe perdu -->
      <form action="login2.php" method="post">
        <div class="form-group">
          <label for="mailClient">Email</label>
          <div class="input-group">
            <div class="input-group-addon">@</div>
            <input type="email" name="mailClient" class="form-control" required>
          </div>
        </div>

        <div class="form-group">
          <label for="passClient">Mot de passe</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="ion-android-lock"></span></div>
            <input type="password" name="passClient" class="form-control" required>
          </div>
        </div>

        <div class="form-group text-center">
          <input type="submit" name="btnSub" value="Entrer" class="btn btn-success"></button>
          <a href="perdu.php">Mot de passe perdu<a>
        </div>

      </form>
    </div>
  </div>

<?php
  include 'include/footer.php';
?>
