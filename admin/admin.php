<?php 

$titrePage = "Bio-Villefranche - Administration";

//insertion de l'entete
include 'include/header.php';

if(!isset($_SESSION['admin']))
{
    header('location: index.php');
}
else 
{
    //liste des catégories
    $rqCat = "SELECT * FROM categories";
    $listeCategories = $dbh->query($rqCat)->fetchAll();

    //liste des fournisseurs
    $rqFourn = "SELECT * FROM fournisseurs";
    $listeFournisseurs = $dbh->query($rqFourn)->fetchAll();

    //liste des produits
    $rqProd = "SELECT * FROM produits";
    $listeProduits = $dbh->query($rqProd)->fetchAll();

    // liste des fournisseurs
    $rqFournisseurs = "SELECT idFournisseur, nomFournisseur, RS FROM fournisseurs";
    $listeFournisseurs = $dbh->query($rqFournisseurs)->fetchAll();

    // liste des categories et sous-categories
    $rqCatSCat = 'SELECT s.idSCategorie, s.libSCategorie, c.libCategorie
                FROM scategories as s
                JOIN categories as c
                ON c.idCategorie = s.idCategorie
                ORDER BY s.idCategorie ASC';
    $listeCatSCat = $dbh->query($rqCatSCat)->fetchAll();

    ?>

    <div class="row">
        <div class="col-sm-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Catégorie</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listeCategories as $cat): ?>
                    <tr>
                        <td> <?= $cat['idCategorie']; ?> </td>
                        <td> 
                            <form method="post" action="modifCat.php" class="form-inline">
                                <input type="hidden" name="idCategorie" value="<?=$cat['idCategorie'];?>">
                                <input type="text" name="libCategorie" value="<?=$cat['libCategorie'];?>" class="form-control">
                                <button type="submit" name="btnSub" class="btn btn-warning glyphicon glyphicon-pencil"></button>
                            </form>
                        </td>
                        <td><a href="supCategorie.php?id=<?= $cat['idCategorie'];?>" class="btn btn-danger"><i class="ion-trash-a"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="3">
                            <form method="post" action="addCat.php" class="form-inline">
                                <label> Libellé </label>
                                <input type="text" name="libCategorie" class="form-control" placeholder="Nouvelle Catégorie">
                                <button type="submit" name="btnSub" class="btn btn-primary">Ajouter</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- col-sm-6 -->
        <div class="col-sm-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Catégorie</th>
                        <th>Sous-Catégorie</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listeCatSCat as $sCat): ?>
                    <tr>
                        <td> <?= $sCat['idSCategorie']; ?> </td>
                        <td> <?= $sCat['libCategorie']; ?> </td>
                        <td> 
                            <form method="post" action="modifssCat.php" class="form-inline displayFlex">
                                <input type="hidden" name="idSCategorie" value="<?=$sCat['idSCategorie'];?>">
                                <input type="text" name="libSCategorie" value="<?=$sCat['libSCategorie'];?>" class="form-control">
                                <button type="submit" name="btnSub" class="btn btn-warning glyphicon glyphicon-pencil"></button>
                            </form>
                        </td>
                        <td><a href="supssCategorie.php?id=<?= $sCat['idSCategorie'];?>" class="btn btn-danger"><i class="ion-trash-a"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <form method="post" action="addssCat.php" class="form-inline displayFlex col-sm-6">
                            <td>
                                <label> Libellé </label>
                            </td>
                            <td>
                                <select name="idCategorie" class="form-control">
                                    <option value="" disabled selected>
                                        Catégorie
                                    </option>
                                    <?php foreach($listeCategories as $cat)
                                        {
                                            echo '<option value="'.$cat['idCategorie'].'">'.$cat['idCategorie'].' '.$cat['libCategorie'].'</option>';
                                        }
                                        ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="libSCategorie" class="form-control" placeholder="Nouvelle sous-catégorie">
                            </td>
                            <td>
                                <button type="submit" name="btnSub" class="btn btn-primary">Ajouter</button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div> <!-- col-sm-6 -->
    </div> <!-- row -->
    <div class="row">
        <div class="col-sm-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du Fournisseur</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listeFournisseurs as $fourn): ?>
                    <tr>
                        <td> <?= $fourn['idFournisseur']; ?> </td>
                        <td> 
                            <form method="post" action="modifFourn.php" class="form-inline">
                                <input type="hidden" name="idFournisseur" value="<?=$fourn['idFournisseur'];?>">
                                <input type="text" name="nom" value="<?=$fourn['nomFournisseur'];?>" class="form-control">
                                <button type="submit" name="btnSub" class="btn btn-warning glyphicon glyphicon-pencil"></button>
                            </form>
                        </td>
                        <td><a href="supFourn.php?id=<?= $fourn['idFournisseur'];?>" class="btn btn-danger"><i class="ion-trash-a"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- col-sm-6 -->
    </div> <!-- row -->

    <div class="row">
        <div class="col-sm-12">
            <form method="post" action="addFournisseur.php">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label> Nom </label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label> Prénom </label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label> Raison Sociale </label>
                        <input type="text" name="RS" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label> Email </label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div> <!-- row -->
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label> Téléphone </label>
                        <input type="text" name="tel" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label> Adresse </label>
                        <input type="text" name="rue" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Code Postal</label>
                        <input type="number" name="cp" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Ville</label>
                        <input type="text" name="ville" class="form-control">
                    </div>
                </div> <!-- row -->               
                <div class="form-group text-center">
                    <input type="submit" name="btnSub" value="Ajouter" class="btn btn-primary">
                </div> 
            </form>

        </div> <!-- col-sm-6 -->
    </div> <!-- row -->
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produit</th>
                        <th>Sous-Catégorie</th>
                        <th>Stock</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listeProduits as $prod): ?>
                    <tr>
                        <td> <?= $prod['idProduit']; ?> </td>
                        <td> 
                            <form method="post" action="renameProduit.php" class="form-inline displayFlex">
                                <input type="hidden" name="idProduit" value="<?=$prod['idProduit'];?>">
                                <input type="text" name="nom" value="<?=$prod['nom'];?>" class="form-control">
                                <button type="submit" name="btnSub" class="btn btn-warning glyphicon glyphicon-pencil"></button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="ssCatProduit.php" class="form-inline displayFlex">
                                <input type="hidden" name="idProduit" value="<?=$prod['idProduit'];?>">
                                <select name="idSCategorie" class="form-control">
                                    <option value="" disabled selected>
                                        Sélectionnez une sous-catégorie
                                    </option>
                                    <?php foreach($listeCatSCat as $CatSCat) 
                                        {
                                            echo '<option value="'.$CatSCat['idSCategorie'].'">'.$CatSCat['libCategorie'].' '.$CatSCat['libSCategorie'].'</option>';
                                        }
                                        ?>
                                </select>
                                <button type="submit" name="btnSub" class="btn btn-warning glyphicon glyphicon-pencil"></button>
                            </form>
                        </td>
                        <td> 
                            <form method="post" action="modifStock.php" class="form-inline displayFlex">
                                <input type="hidden" name="idProduit" value="<?=$prod['idProduit'];?>">
                                <input type="text" name="stocks" value="<?=$prod['stocks'];?>" class="form-control">
                                <button type="submit" name="btnSub" class="btn btn-warning glyphicon glyphicon-pencil"></button>
                            </form>
                        </td>
                        <td><a href="suppProduit.php?id=<?= $prod['idProduit'];?>" class="btn btn-danger"><i class="ion-trash-a"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" action="ajoutProduit.php" enctype="multipart/form-data">
                <div class="form-group col-sm-3">
                    <label> Nom </label>
                    <input type="text" name="nom" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label> Origine </label>
                    <input type="text" name="origine" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label> Prix </label>
                    <input type="text" name="prix" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label> Poids </label>
                    <input type="text" name="poids" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label> Prix au kiko </label>
                    <input type="text" name="pxkilo" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label> Référence </label>
                    <input type="text" name="reference" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label> Sous-Catégorie </label>
                    <select name="idSCategorie" class="form-control">
                        <option value="" disabled selected>
                            Sélectionnez une sous-catégorie
                        </option>
                        <?php foreach($listeCatSCat as $CatSCat) 
                            {
                                echo '<option value="'.$CatSCat['idSCategorie'].'">'.$CatSCat['libCategorie'].' '.$CatSCat['libSCategorie'].'</option>';
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label>Description</label>
                    <textarea name="description" 
                                    class="form-control"></textarea>
                </div>
                <div class="form-group col-sm-3">
                        <label>Stocks</label>
                        <input type="text" name="stocks" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label>Delais de Livraison</label>
                    <input type="text" name="delaiLivraison" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label>Photo</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label>Fournisseur</label>
                    <select name="idFournisseur" class="form-control">
                        <option value="" disabled selected>
                            Sélectionnez un fournisseur
                        </option>
                        <?php foreach($listeFournisseurs as $fournisseur) 
                        {
                            echo '<option value="'.$fournisseur['idFournisseur'].'">'.$fournisseur['RS'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group text-center col-sm-12">
                    <input type="submit" name="btnSub" value="Ajouter"
                                class="btn btn-primary">
                </div> 
            </form>
        </div><!-- col-sm-6 -->
    </div> <!-- row -->

<?php
}
            

// insertion du footer
include 'include/footer.php';