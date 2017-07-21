<?php
// fichier include/header.php
  @session_start(); //toujours en haut
  // connexion BDD
  require 'include/connexion.php';
    ?>
<!DOCTYPE html>
  <html lang="fr">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title><?php echo $titrePage; ?></title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet"> 
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div class="container">

      <header>
        <div class="row">
          <div class="col-md-4">
            <img src="img/logo.png" alt="logo biovillefranche" class="logo img-responsive center-block">
          </div>
          <div class="col-md-8">
            <hgroup>
              <h1>
                Bio Villefranche
              </h1>
              <h2>
                Votre épicerie Bio à Villefranche
              </h2>
            </hgroup>
          </div>
        </div>
      </header>
<?php
  require 'include/menu.php';
?>
