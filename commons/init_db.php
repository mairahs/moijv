<?php
function getDb(){
	//déclaration du dsn
	$dsn = 'mysql:host=localhost;dbname=moijv;charset=utf8';

	//je déclare $pdo comme variable globale de façon à ce que pdo ne soit pas recréer plusieurs fois

	global $pdo;

	//on vérifie que odo n'a pas déjà été instanci ou créé
	if(!isset($pdo)){

			// Si pdo n'existe pas ou est nul on crée un nouveau pdo et on le stocke dans une variable $pdo qui est dorénavant globale
			//connexion en local seulement
			$pdo = new PDO($dsn,'root','');
	}

	return $pdo;
}