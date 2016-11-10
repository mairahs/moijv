<?php

require_once 'commons/init_db.php';

function ajouterJeu($infosJeu,$image = 'default.png'){

	$pdo = getDb();
	$dateEdition = date('Y-m-d H:i:s');

	$ajoutJeu = $pdo->prepare('INSERT INTO jeux (nom,description,nombre_joueurs,dateEdition,image) VALUES(:nom,:description,:nombre_joueurs,:dateEdition,:image)');

	$ajoutJeu->bindValue(':nom',trim($infosJeu['nom']));
	$ajoutJeu->bindValue(':description',trim($infosJeu['description']));
	$ajoutJeu->bindValue(':nombre_joueurs',$infosJeu['nb_joueurs']);
	$ajoutJeu->bindValue(':dateEdition',$infosJeu['date']);
	$ajoutJeu->bindValue(':image',$image);
	$ajoutJeu->execute();

	return $pdo->lastInsertId();

}

