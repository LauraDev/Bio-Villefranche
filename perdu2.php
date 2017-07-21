<?php 

$titrePage = "Bio-Villefranche - Mot de passe perdu";

//insertion de l'entete
include 'include/header.php';

//insertion phpMailer
require 'include/phpmailer/PHPMailerAutoload.php';


//verifier que l'adresse est bien dans la BDD
$email = strip_tags($_POST['mailClient']); //mr propre
$rqEmail = "SELECT COUNT(*) FROM clients WHERE mailClient = :mailClient";
$stmtEmail = $dbh->prepare($rqEmail); // préparation
$paramEmail = array(':mailClient' => $email); // parametres
$stmtEmail ->execute($paramEmail); //execution
$exist = $stmtEmail->fetchColumn(); // recuperation

//generer un token
if($exist == 1)
{
    $token = md5($email.date('YmdHis'));
    //echo $token; // controle

    $mail = new PHPMailer; //nouvel objet de type mail
    $mail->isSMTP(); //connexion directe au serveur SMTP
    $mail->isHTML(true); //Utilisation du format HTML
    $mail ->CharSet= "UTF-8";
    $mail->Host = 'smtp.gmail.com'; //Le serveur de messagerie
    $mail->Port = 465; //Port obligatoire de google
    $mail->SMTPAuth = true; //On va fournir login/password
    $mail->SMTPSecure = 'ssl'; //Certificat SSL
    $mail->Username = 'wf3villefranche@gmail.com'; //Utilisateur SMTP
    $mail->Password = 'Azerty1234'; //mdp utilisateur SMTP
    $mail->setFrom('wf3villefranche@gmail.com', 'Bio Villefranche'); //Expéditeur du mail
    $mail->addAddress($email); //Destinataire du mail
    $mail->Subject = 'Mot de Passe Biovillefranche';
    $mail->Body = '<html>
                        <head>
                            <style>
                                h1{color:green; }
                            </style>
                        </head>
                        <body>
                            <h1>Mot de Passe Biovillefranche</h1>
                            <p><a href="http://'.$_SERVER['SERVER_NAME'].'/laura/biovillefranche2/perdu3.php?token='.$token.'">Réinitialiser votre Mot de passe</a></p>
                        </body>
                    </html>'; //Le corps du mail

    if(!$mail->send()) //si l'envoi échoue
    {
        echo '<p class="alert alert-danger">Erreur envoi '.$mail->ErrorInfo.'</p>';
    } else //si envoi ok

        // enregistrement du token dans la BDD
        $rqMaj = "UPDATE clients SET token= :token WHERE mailClient= :mailClient";
        $stmtMaj = $dbh->prepare($rqMaj); //preparation
        $param2 = array(':token' => $token , ':mailClient' => $email); //<arametres
        $stmtMaj->execute($param2); //execution

        //Message de retour
        echo '<p class="alert alert-success">Un e-mail vient de vous etre envoyer pour réinitialiser votre mot de passe</p>';
}



// insertion du footer
include 'include/footer.php';