<?php

	require_once('_consts_.php');
	header("Access-Control-Allow-Origin: *");

global $mysqli;

$mysqli = new mysqli(DATABASE_HOST, DATABASE_UTILISATEUR, DATABASE_PASS, DATABASE_NOM_BASE);
$mysqli->set_charset("utf8");// Evite les problème convertion UTF8(site web) et Latin(Base raspisms)

if ($mysqli->connect_errno) {
	die ("Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
} 

function execquery($query) { 
global $mysqli;	
	if ($result = $mysqli->query($query)) {
    	/* Récupère un tableau associatif */
    	while ($row = $result->fetch_assoc()) $rows[] = $row;
    	/* Libération des résultats */
    	$result->free();
	}
	/*
	$result = $mysqli->query($query);
	if ( !$result ) 
		die ( "Echec lors de l'exécution de la requête $query : (" . $mysqli->errno . ") " . $mysqli->error );
	else 
		return mysqli_fetch_array( $result, MYSQLI_ASSOC );
		*/

	if (isset($rows)) {
		return $rows;		
	} else {
		return array();
	}	
}

function insertquery($query) {
global $mysqli;
	if ($mysqli->query($query) === TRUE) {
		return true;
	} else {
		return false;
	}
$result->free();
}

function updatequery($query) {
global $mysqli;
	if ($mysqli->query($query) === TRUE) {
		return true;
	} else {
		return false;
	}

$result->free(); 

}

function deletequery($query) { 
global $mysqli;
	if ($mysqli->query($query) === TRUE) {
		return true;
	} else {
		return false;
	}
$result->free(); 
}


function truncate($query) { 
global $mysqli;
$mysqli->query("SET FOREIGN_KEY_CHECKS=0");
	if ($mysqli->query($query) === TRUE) {
		return true;
	} else {
		return false;
	}
$mysqli->query("SET FOREIGN_KEY_CHECKS=1");
$result->free(); 
}

function dernier_id_ajoute() {
// Retourne l'id de la derniere insertion
global $mysqli;
		if ($result = $mysqli->insert_id) {
		 return $result; 	
	
		} else { 
		return "Erreur"	; 
		}
$result->free();	 
}


function dernier_nb_ligne_ajoute() {
// Retourne l'id de la derniere insertion
global $mysqli;
		if ($result = $mysqli->affected_rows) {
		 return $result; 	
	
		} else { 
		return "Erreur"	; 
		}
$result->free();	 
}


// Nettoyage d'une chaine
function clean($string) {
	$string = html_entity_decode(preg_replace('/&([a-zA-Z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);/i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8');
	$string = strtolower(trim(preg_replace('/[^0-9a-z]+/i', '_', $string), '-'));

	return $string;
}

function clean_text($str,$options = array('TOUT'),$max=0){
	// Utilisation: 
	// clean_text(CHAINE A NETTOYER,array('HTML','TRIM','TABULATION','ENTER','DOUBLE','SLASHES'));

	if(in_array('TOUT',$options)):
		$options = array('HTML','TRIM','MAJUSCULE','MINUSCULE','ACCENT','PONCTUATION','TABULATION','ENTER','DOUBLE','SLASHES');
	endif;

	foreach($options as $option):
		switch($option){

			// Suppression des espaces vides en debut et fin de chaque ligne
			case 'TRIM':
				$str = preg_replace("#^[\t\f\v ]+|[\t\f\v ]+$#m",'',$str);
			break;

			// Remplacement des caractères accentués par leurs équivalents non accentués
			case 'ACCENT':
				$str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
				$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
				$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. 'œ'
				$str = html_entity_decode($str); 
			break;

			// Transforme tout le texte en minuscule
			case 'MINUSCULE':
				$str = mb_strtolower($str, 'UTF-8');
			break;

			// Transforme tout le texte en majuscule
			case 'MAJUSCULE':
				$str = mb_strtoupper($str, 'UTF-8');
			break;

			// Remplace toute la ponctuation par des espaces
			case 'PONCTUATION':
				$str = preg_replace('#([[:punct:]])#',' ',$str);
				$exceptions = array("’");
				$str = str_replace($exceptions,' ',$str);
			break;

			// Remplace les tabulations par des espaces
			case 'TABULATION':
				$str = preg_replace("#\h#u", " ", $str);
			break;

			// Remplace les espaces multiples par des espaces simples
			case 'DOUBLE':
				$str = preg_replace('#[" "]{2,}#',' ',$str);
			break;

			// Remplace 1 entrée (\r\n) par 1 espace
			case 'ENTER':
				$str = str_replace(array("\r","\n"),' ',$str);
			break;

			// Supprime toutes les balises html
			case 'HTML':
				$str = strip_tags($str);
			break;
			
			// Ajoute les antislashes   ' -> /'  utiliser donc stripslashes( dans le code php pour les enlever après stripslashes($rowquery['description'])
			
			case 'SLASHES':
				$str = addslashes($str);
			break;		
			
			// Limite la taille de la chaine
			case 'LIMITE':
				   $str = substr($str, 0, $max);
			break;

			
		}
	endforeach;
	
	return $str;
}