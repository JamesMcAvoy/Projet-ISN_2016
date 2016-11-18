<?php

session_start();
require __DIR__ '/Minichat/class/Minichat.php';
Minichat::autoloader();


//Vérification si ban IP
$ip = $_SERVER['REMOTE_ADDR'];
$data = new Data('bans_ip.txt');
$data = $data->getData();

if(in_array($ip, $data)) {
	$_SESSION['flash'] = 'Votre IP est bannie !';
	header('Location: /');
	exit;
}


//Si on accède niaisement à cette page on est renvoyé à l'accueil
elseif(empty($_POST)) {

	header('Location: /');
	exit;

}


//Si captcha incorrect
elseif(isset($_POST['captcha']) && $_POST['captcha'] != $_SESSION['captcha']) {

	$_SESSION['flash'] = 'Le captcha est incorrect !';
	header('Location: /');
	exit;

}


//Si connexion anonymous
elseif(isset($_POST['anonymous']) && $_POST['captcha'] == $_SESSION['captcha']) {

	$anonymous = new Anonymous(Minichat::create_pseudo());
	$anonymous->connect();

	$_SESSION['pseudo'] = $anonymous->getPseudo();

	$_SESSION['flash'] = 'Votre pseudo généré est '.$_SESSION['pseudo'].' !';

	$_SESSION['on'] = true;
	$_SESSION['token'] = substr(md5(uniqid()), 0, 6);

	header('Location: /');
	exit;

}


//Sinon connexion pseudo
elseif(isset($_POST['submit']) && $_POST['captcha'] == $_SESSION['captcha']) {

	//Vérifie si le pseudo n'est pas contenu dans la liste des Pokémon
	$pokemon = get_file('../data/pseudos/pokemon.txt');
	if(in_array($_POST['pseudo'], $pokemon)) {
		$_SESSION['flash'] = 'Ce pseudo ne peut pas être utilisé, il est réservé à une connexion anonyme !';
		header('Location: /');
		exit;
	}

	//Si pseudo est incorrect
	elseif(!preg_match('/^[a-zA-Z-_0-9]{3,15}$/', $_POST['pseudo'])) {
		$_SESSION['flash'] = 'Le pseudo n\'est pas conforme !';
		header('Location: /');
		exit;
	}

	//Si pseudo déjà utilisé actuellement
	elseif(pseudo_exists($_POST['pseudo'])) {
		$_SESSION['flash'] = 'Le pseudo est utilisé actuellement !';
		header('Location: /');
		exit;
	}

	//Si pseudo conforme
	else {
		//Création tableau avec liste des admins
		$admins = get_file('../data/pseudos/admins.txt');

		foreach($admins as $admin) {
			$admin = explode('|', $admin);

			//Si pseudo existe dans fichier ET MDP correspond
			if($_POST['pseudo'] == $admin['0'] && encrypt($_POST['pass']) == $admin['1']) {
				$_SESSION['flash'] = 'Vous êtes connecté !';
				$_SESSION['pseudo'] = $_POST['pseudo'];

				add_connected($_SESSION['pseudo']);

				//Session active et génération d'un token de sécurité
				$_SESSION['on'] = true;
				$_SESSION['admin'] = true;
				$_SESSION['token'] = substr(md5(uniqid()), 0, 6);
				header('Location: /');
				exit;
			}

			//Sinon si MDP incorrect
			elseif($_POST['pseudo'] == $admin['0'] && encrypt($_POST['pass']) != $admin['1']) {
				$_SESSION['flash'] = 'Le mot de passe est incorrect !';
				header('Location: /');
				exit;
			}
		}


		//Création tableau avec liste des modos
		$modos = get_file('../data/pseudos/modos.txt');

		foreach($modos as $modo) {
			$modo = explode('|', $modo);
			
			//Si pseudo existe dans fichier ET MDP correspond
			if($_POST['pseudo'] == $modo['0'] && encrypt($_POST['pass']) == $modo['1']) {
				$_SESSION['flash'] = 'Vous êtes connecté !';
				$_SESSION['pseudo'] = $_POST['pseudo'];

				add_connected($_SESSION['pseudo']);

				//Session active et génération d'un token de sécurité
				$_SESSION['on'] = true;
				$_SESSION['modo'] = true;
				$_SESSION['token'] = substr(md5(uniqid()), 0, 6);
				header('Location: /');
				exit;
			}

			//Sinon si MDP incorrect
			elseif($_POST['pseudo'] == $modo['0'] && encrypt($_POST['pass']) != $modo['1']) {
				$_SESSION['flash'] = 'Le mot de passe est incorrect !';
				header('Location: /');
				exit;
			}
		}


		//Création tableau avec liste des pseudos
		$pseudos = get_file('../data/pseudos/pseudos.txt');

		foreach($pseudos as $pseudo) {
			$pseudo = explode('|', $pseudo);

			//Si pseudo existe dans fichier ET MDP correspond
			if($_POST['pseudo'] == $pseudo['0'] && encrypt($_POST['pass']) == $pseudo['1']) {
				$_SESSION['flash'] = 'Vous êtes connecté !';
				$_SESSION['pseudo'] = $_POST['pseudo'];

				add_connected($_SESSION['pseudo']);

				//Session active et génération d'un token de sécurité
				$_SESSION['on'] = true;
				$_SESSION['token'] = substr(md5(uniqid()), 0, 6);
				header('Location: /');
				exit;
			}

			//Sinon si MDP incorrect
			elseif($_POST['pseudo'] == $pseudo['0'] && encrypt($_POST['pass']) != $pseudo['1']) {
				$_SESSION['flash'] = 'Le mot de passe est incorrect !';
				header('Location: /');
				exit;
			}
		}

		//Si pseudo inexistant le crée
		$pseudos = file_get_contents('../data/pseudos/pseudos.txt');
		$pseudos .= $_POST['pseudo'] . '|' . encrypt($_POST['pass']) . "\n";
		file_put_contents('../data/pseudos/pseudos.txt', $pseudos);

		//Session active et génération d'un token de sécurité
		$_SESSION['pseudo'] = $_POST['pseudo'];
		$_SESSION['flash'] = 'Votre pseudo a bien été créé !';
		add_connected($_SESSION['pseudo']);
		
		$_SESSION['on'] = true;
		$_SESSION['token'] = substr(md5(uniqid()), 0, 6);
		header('Location: /');
		exit;
	}

}