<?php

function verifPassword($mdp)
{
	$longueur = strlen($mdp); //longueur du mot de passe
	if($longueur < 8) return false;
	$nbInt = $nbMaj = 0; //compteurs majuscules et chiffres
	for($i=0; $i<$longueur; $i++)
	{
		// est-ce un nombre?
		if(is_numeric($mdp[$i])) $nbInt++;
		// est-ce une majuscule?
		else if(strtoupper($mdp[$i]) == $mdp[$i]) $nbMaj++;
	}
	if($nbInt < 1) return false;
	if($nbMaj < 1) return false;
	return true;
}