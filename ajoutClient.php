<?php
    // script ajoutClient.php
    $titrePage = 'BioVillefranche - Inscription';
    include 'include/header.php';

    //Mr propre
    $safe = array_map('strip_tags', $_POST);
    $errors = array();
    // contôles
    // controle mail
    if (!filter_var($safe['mailClient'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse mail invalide';
    }
    
    // controle mdp
    $mdp = $safe['passClient'];

    $longueur = strlen($mdp);
    if ($longueur < 8) {
        $errors[] = 'Mot de passe trop court';
    }

    $nbInt = $nbMaj = 0; //compteur
    for ($i=0; $i <$longueur ; $i++) {
        // un nombre ?
        if (is_numeric($mdp[$i])) {
            $nbInt ++;
        }
        // une majuscule ?
        elseif (strtoupper($mdp[$i]) == $mdp[$i]) {
            $nbMaj ++;
        }
    }
    if ($nbInt < 1) {
        $errors[] = 'Le mot de passe doit contenir au moins un chiffre';
    }

    if ($nbMaj < 1) {
        $errors[] = 'Le mot de passe doit contenir au moins une majuscule';
    }

    // mail déjà dans la table ?
    $rqVerif = "SELECT COUNT(*) FROM clients WHERE mailClient = :mailClient";
    // préparartion
    $stmtVerif = $dbh->prepare($rqVerif);
    // parametres
    $paramVerif = array(':mailClient' => $safe['mailClient']);
    //execution
    $stmtVerif ->execute($paramVerif);
    // recuperation
    $exist = $stmtVerif->fetchColumn();
    // si erreur > 0
    if ($exist > 0) {
        $errors[] = 'L\'adresse mail existe déjà';
    }

    if (count($errors) == 0) {
        // hash mdp
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        // ajout BDD
        $req = "INSERT INTO clients(nomClient,prenomClient,adresseClient, cpClient, villeClient, mailClient, passClient, telClient, remiseClient, actif)
                VALUES (:nomClient, :prenomClient, :adresseClient, :cpClient, :villeClient, :mailClient, :passClient, :telClient, :remiseClient, :actif)";
        // préparation
        $stmt = $dbh->prepare($req);
        // parametres
        $params = array(':nomClient' => $safe['nomClient'],
                        ':prenomClient' => $safe['prenomClient'],
                        ':adresseClient' => $safe['adresseClient'],
                        ':cpClient' => $safe['cpClient'],
                        ':villeClient' => $safe['villeClient'],
                        ':mailClient' => $safe['mailClient'],
                        ':passClient' => $hash,
                        ':telClient' =>$safe['telClient'],
                        ':remiseClient' => 0,
                        ':actif' => 1);
        // execution
        if ($stmt->execute($params)) {
            // Message retour
        echo '<div class="alert alert-success">Merci pour votre inscription</div>';
        } else {
            echo '<div class="alert alert-danger">Erreur de requête</div>';
        }
    }
    // Message d'erreur
    else {
        $liste = '';  //chaine vide
        // pour chaque erreur
    foreach ($errors as $error) {
        $liste = '<li>' . $error . '</li>';
        }
        echo '<div class="alert alert-danger">Des erreurs sont à corriger: <ul>' . $liste . '</ul></div>';
    }


    include 'include/footer.php';
