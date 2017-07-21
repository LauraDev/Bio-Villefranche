<?php session_start();

//insertion du module de connexion
include 'include/connexion.php';

if(!isset($_SESSION['admin']))
{
    header('location: index.php');
}
else 
{
    $safe = array_map('strip_tags', $_POST); //mr propre
    // I- Verifier si le produit existe deja
    $rqVerif = "SELECT COUNT(*) 
                FROM produits
                WHERE  nom = :nom ";
    $stmtVerif = $dbh->prepare($rqVerif); //preparation
    // parameters
    $paramCat = array(':nom' => $safe['nom']);
    $stmtVerif->execute($paramCat); //execution
    $exists = $stmtVerif->fetchColumn(); //contient 0 ou 1


    // II- ENregistrer l'image dans le bon dossier avec le bon nom
    if(!isset($_FILES['photo']) OR $_FILES['photo']['error'] > 0 )
    {
        echo '<p> Fichier trop grand </p>';
    }
    // Le fichier est bien téléchargé
    else
    {
        // Pour les images, récupération de la taille
        $size = getimagesize($_FILES['photo']['tmp_name']);
        // print_r($size);
        if( !$size ) 
        {
            echo "ce n'est pas une image";
        } 
        else 
        {
            $info = new finfo(FILEINFO_MIME_TYPE);
            $mime = $info->file($_FILES['photo']['tmp_name']);
            // echo($mime); //plus precis que print_r : renvoi aussi le type
            
            if( $mime == "image/jpeg" || $mime == "image/jpg" ||$mime == "image/png" ) 
            {
                //changer le nom du fichier 
                // a-obtenir l'extension(tt apres le point)
                $extension = substr($_FILES['photo']['name'],
                                strrpos($_FILES['photo']['name'] , '.'));
                // echo $extension;
                // b- creer une cle unique random securisee
                $nomFichier = md5(uniqid(rand(), true));
                // echo '<p>Nouveau nom:'.$nomFichier.$extension.'</p>';

                // Deplacer l'image dans le dossier images de l'application
                // $up = move_uploaded_file($_FILES['monFichier']['tmp_name'], 'images/'.$_FILES['monFichier']['tmp_name']);
                $up = move_uploaded_file($_FILES['photo']['tmp_name'], '../img/'.$nomFichier.$extension);
                if($up) echo '<p>Fichier Téléchargé</p>';
            } 
            else echo '<br>Erreur Format ( JPEG / JPG / PNG )';            
            
        }
    
    

        // III- CREER LE PRODUIT
        if( $exists == 0) 
        {

            $rqProd = "INSERT INTO produits (nom, idSCategorie, origine, prix, poids, pxkilo, reference, description, stocks, delaisLivraison, idFournisseur, photo) 
                        VALUES (:nom, :idSCategorie, :origine, :prix, :poids, :pxkilo, :reference, :description, :stocks, :delaisLivraison, :idFournisseur, :photo) ";
            $stmtProd = $dbh->prepare($rqProd);
            $paramProd = array(':nom' => $safe['nom'], ':idSCategorie' => $safe['idSCategorie'] , ':origine'=> $safe['origine'], ':prix'=> $safe['prix'], ':poids'=> $safe['poids'], ':pxkilo'=> $safe['pxkilo'], ':reference'=> $safe['reference'], ':description'=> $safe['description'], ':stocks'=> $safe['stocks'], ':delaisLivraison'=> $safe['delaiLivraison'], ':idFournisseur'=>$safe['idFournisseur'], ':photo'=>$nomFichier.$extension);
            if($stmtProd ->execute($paramProd))
            {
                header('location: admin.php');
            } else echo '<p class="alert alert-danger">Erreur lors de la création de la catégorie</p>';
        
        }
        else{
            //insertion du module de connexion
            include 'include/header.php';
            echo '<p class="alert alert-danger"> Ce produit existe déjà</p>';
            // insertion du footer
            include 'include/footer.php'; 
        }
    }
}