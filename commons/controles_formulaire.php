<?php

function estPoste($champ){
	return isset($_POST[$champ]) && trim($_POST[$champ]) !=='';
}

function longueurEntre($champ,$min,$max){

	//on vérifie que le champ est passée en $_POST

	if(estPoste($champ)){

		// on récupère la longueur du champ

		$longueurChamp = strlen($_POST[$champ]);

		// on retourne un booleen vrai si cette longueur est bien comprise entre $min et $ max et faux sinon

		return $longueurChamp >= $min && $longueurChamp <= $max;
		/*
			if($longueurChamp < $min || $longueurChamp > $max){
			return false;
		} else {
			return true;
		}  pour les newbies !!!
		*/
	} else {
		return false;
	}

}
