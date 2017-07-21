<?php
    // fichier include/menu.php

    $rqCatMenu = "SELECT s.idSCategorie, s.libSCategorie, c.libCategorie
                  FROM scategories as s
                  JOIN categories as c
                  ON c.idCategorie = s.idCategorie
                  WHERE idSCategorie 
                  IN(SELECT DISTINCT idSCategorie FROM produits)
                  ORDER BY s.idCategorie ASC";

    // pas de parametres donc query
    $stmtCatMenu = $dbh->query($rqCatMenu);
    // recuperation de la liste
    $listeSCatMenu = $stmtCatMenu->fetchAll();
    
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#monMenu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="index.php" class="navbar-brand">Accueil</a>
    </div> <!-- fin navbar-header -->

    <!-- partie dynamique du menu -->
    <div class="collapse navbar-collapse" id="monMenu">
      <!-- liste de sous categorie -->
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Produits <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!-- liste de sous categorie depuis BDD -->
            <!--<li><a href="produits.php?scat=1">libCategorie libSCategorie</a>-->
            <?php 
              foreach($listeSCatMenu as $sCMenu)
              {
                // liste des liens
                $href = 'produits.php?id='.$sCMenu['idSCategorie'];
                // le texte du lien : categorie + ss-categorie
                $libelle = $sCMenu['libCategorie'].' '.$sCMenu['libSCategorie'];
                // code html pour la création des liens + libellés
                echo ' <li><a href=" '. $href .' ">'.$libelle.'</a></li>';
              }
            ?>
          </ul>
        </li>
        <!--Verifier si le client est connecté-->
        <?php if(isset($_SESSION['auth'])): ?>
        <!-- menu si connecté -->
        <li>
          <p class="navbar-text" id='prenomClient'>
            <?= 'Bienvenue '.$_SESSION['prenom']; ?>
          </p>
        </li>
      </ul> <!-- fin menu gauche-->

      
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="panier.php">Panier <?php
                      if( $_SESSION['qte'] == 0 )
                      {
                        echo '</a>';
                      }
                      else
                      {
                        echo '<span class="badge">'. $_SESSION['qte'] . ' articles</span> </a>';
                      } ?>
        </li>
        <li>
          <a href="contact.php">Contact</a>
        </li>
        <li>
          <a href="quitter.php">Me déconnecter</a>
        </li>
        <li>
          <!-- formulaire de recherche -->
          <form class="navbar-form navbar-right" method="post" action="recherche.php">
            <div class="form-group">
              <input type="text" name="recherche" id="recherche" placeholder="Recherche" class="form-control">
            </div>
            <button type="submit" id="envoiRecherche"class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
          </form>
        </li>
      </ul>

      <?php else: ?>
      </ul>
      <!-- menu si non connecté -->
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="inscription.php">Inscription</a>
        </li>
        <li>
          <a href="login.php">Connexion</a>
        </li>
        <li>
          <!-- formulaire de recherche -->
          <form class="navbar-form navbar-right" method="post" action="recherche.php">
            <div class="form-group">
              <input type="text" name="recherche" id="recherche" placeholder="Recherche" class="form-control">
            </div>
            <button type="submit" id="envoiRecherche"class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
          </form>
        </li>
      </ul>
      <?php endif; ?>



    </div> <!-- fin partie dynamique -->


  </div> <!-- fin container fluid -->
</nav>
