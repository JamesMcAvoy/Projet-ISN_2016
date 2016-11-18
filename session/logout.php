<?php
//Démarre la session et inclusion fonction
session_start();
require '../inc/func/functions.php';

//Si token est inexact renvoie vers l'index.php pour éviter les CSRF
if(!isset($_GET['token']) && ($_GET['token'] != $_SESSION['token'])) {
	header('Location: /');
	exit;
}

//Supprime le pseudo de connected.json :
$data = file_get_contents('../data/connected.json');
$data = json_decode($data);

//Parcourt le tableau des connectés
$count = count($data);
for($i = 0; $i<$count; $i++) {
	if($data[$i]['0'] == $_SESSION['pseudo']) {
		unset($data[$i]);
		break;
	}
}

//Recrée un nouveau tableau pour reset les keys du tableau
$data2 = array();

foreach($data as $entree) {
	array_push($data2, $entree);
}

//Réécrit le fichier
file_put_contents('../data/connected.json', json_encode($data2));

session_unset();
session_destroy();

header('Location: /');
