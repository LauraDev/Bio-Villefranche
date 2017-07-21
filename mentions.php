<?php

$titrePage = 'Bio-Villefranche - Mentions Légales';
include '\include\header.php';

echo '<pre>';
print_r(file_get_contents('mentions.txt'));
echo '</pre>';

////Lecture ligne par ligne
//$fd = fopen('mentions.txt', 'r');
//
////Boucle de parcours du ficher
//while(!feof($fd)) //feof=fin de fichier
//{
//    $ligne = fgets($fd, 4096);//Lecture de la ligne courante
//    echo '<p>'.$ligne.'</p>';//affichage dans un paragraphe
//}

include '\include\footer.php';

