<?php 
//CONTROLLEUR
require_once'commons/controles_formulaire.php';
require_once'models/jeux.php';

function afficherErreurs($champ){

	// je récupère $erreurs depuis mon fil d'exécution global(mon controleur)
	global $erreurs;

	// je vérifie que le nom du champ existe dans $erreurs et j'affiche l'erreur correspondante
	echo !empty($erreurs[$champ]) ? $erreurs[$champ] : '';
}

function afficherCheck($valeurAttendue){

	//si on a renseigné un sexe en POST et que la valeur rentrée en POST est celle qui est attendue par l'input radio, alors on veut cocher cet input

	echo !empty($_POST['nb_joueurs']) && $_POST['nb_joueurs'] == $valeurAttendue ? 'checked' : '';

}

if(!empty($_POST)){

	$champs = array('Nom du jeu'=>'nom','Description'=>'description','Nombre de joueurs'=>'nb_joueurs');

	$erreurs = array();

	foreach($champs as $champBienEcrit=>$champ){

			if(!estPoste($champ)){

				
				$erreurs[$champ] = 'Le champ '.$champBienEcrit.' est obligatoire.';

			}


		}

	$minNom = 3;
	$maxNom = 50;
	$minDescription = 10;
	

	

	if(!longueurEntre('nom',$minNom,$maxNom)){

		$erreurs['nom'] = 'La longueur du nom doit être comprise entre '.$minNom.' et '.$maxNom.' caractères';
	}

	if(strlen($_POST['description'])< $minDescription){
		$erreurs['description'] = "La description doit contenir au minimum 10 caractères";
	}

	
	if(empty($_POST['nb_joueurs']) || !in_array($_POST['nb_joueurs'], ['1','2','3','4'])){
		$erreurs['nb_joueurs'] = "Le nombre de joueur renseigné n'est pas valide. Il doit être compris entre 1 et 4";
	}


	if(!empty($_FILES['image']['tmp_name'])){

		//vérification du type MIME
		// on va s'assurer du type MIME envoyé par $_FILES cette methode est plus sécurisée que $_FILES['avatar']
		if(is_uploaded_file($_FILES['image']['tmp_name'])){

			//je récupère le type MIME de façon sécurisée

			$typeMime = mime_content_type($_FILES['image']['tmp_name']);

			//je génère un tableau de type valides
			$typesValides = array('image/jpeg','image/png','image/gif');

			//Je vérifie que mon type mime fait partie des types MIME valides
			if(in_array($typeMime,$typesValides)){

				// je vérifie que mon fichier n'est pas trop volumineux
				$maxSize = 1000000; // 1 mo ce qui est largement suffisant pour un avatar

				if($_FILES['image']['size'] <= $maxSize){

					//j'ai fait toutes mes vérifications
					//je peux transférer mon fichier dans un dossier ou il ne sera pas détruit

					$nouveauNomFichier = md5(time().uniqid());
					// uniqid et time varie tout le temps et pour plus de sécurité on concatène les 2 et on fait un hasch dessus => sécurité MAX pour empecher que l'on ait 2 fichiers du même nom à chaque requête
					move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$nouveauNomFichier);
				}else{
					$erreurs['image'] = "Le fichier doit faire moins de 1Mo";
				}
			}
			else{
				$erreurs['image'] = "Le fichier doit être un jpg, un png ou un gif";
			}
		}
		else{

			$erreurs['image'] = "L'image  ne s'est pas téléchargée correctement";
		}
		
	}

	if(empty($erreurs)){

		

		if(!empty($nouveauNomFichier)){
			$idJeu = ajouterJeu($_POST,$nouveauNomFichier);
		}else{
			
			$idJeu = ajouterJeu($_POST);
		
		}

	}

}

 ?>

<?php include'incs/header.php';?>

		<?php include'incs/nav.php'; ?>

		<!-- Page Content -->
		<div class="container">

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Moi JV
						<small>Ajouter un jeu</small>
					</h1>
				</div>
			</div>
			
			<form class="form" action="ajouterJeu.php" method="POST" enctype = "multipart/form-data">
				<div class="form-group">
					<label for="nom">Nom du jeu</label>
					<input class="form-control" type="text" name="nom" id="nom">
					<?php afficherErreurs('nom'); ?>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea class="form-control" name="description" id="description"></textarea>
					<?php afficherErreurs('description'); ?>
				</div>
				<div class="form-group">
					<label for="nb_joueurs">Nombre de joueurs</label>
					<select class="form-control" name="nb_joueurs" id="nb_joueurs">
						<option value="1" <?php afficherCheck('1'); ?>>1</option>
						<option value="2" <?php afficherCheck('2'); ?>>2</option>
						<option value="3" <?php afficherCheck('3'); ?>>3</option>
						<option value="4" <?php afficherCheck('4'); ?>>4</option>
					</select>
					<?php afficherErreurs('nb_joueurs'); ?>
				</div>
				<div class="form-group">
					<label for="date">Date</label>
					<input class="form-control" type="date" name="date" id="date">
					<small>Format anglais (DD/MM/YYYY)</small>
				</div>
				<div class="form-group">
					<label for="image">Image</label><br/>
					<input type="file" name="image" id="image">
					<?php afficherErreurs('image'); ?>
				</div>

				<div class="form-group">
					
					<input class="btn" type="submit" name="send" id="send" value="Envoyer">
				</div>

			</form>

			<hr>

			<?php include'incs/footer.php'; ?>
