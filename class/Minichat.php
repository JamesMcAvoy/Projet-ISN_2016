<?php
/**
 * Classe minichat, contient des fonctions
 * @package Minichat
 */

namespace Minichat\class;

use Minichat\class\Data\Data;
use Minichat\class\User\User;

abstract class Minichat {

	/**
	 * Inclut les classes demandées
	 * @param String $class
	 * @return void
	 */
	private function register_autoload($class) {

		//Récupère le nom de classe, du dossier courant et enlève l'\ de la classe demandée
		$thisClass = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
		$baseDir = rtrim(__DIR__, '/');
		$class = ltrim($class, '\\');

		//Si le nom de la classe est contenue dans le nom du dossier alors on raccourcit le nom du dossier courant
		if(substr($baseDir, -strlen($thisClass)) === $thisClass) {
			$baseDir = substr($baseDir, 0, -strlen($thisClass));
			$baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR);
		}

		//Cherche la position de la dernière occurence du séparateur de dossier (suivant l'OS) et soustrait ce qui y correspond à $baseDir
		$last = strripos($baseDir, DIRECTORY_SEPARATOR);
		$baseDir = substr($baseDir, 0, $last) . DIRECTORY_SEPARATOR;

		//La classe à charger commence par $baseDir
		$class_to_load = $baseDir;
		$namespace = '';

		//S'il existe une dernière occurence de « \ » (donc classe dans un namespace),
		//alors on met le namespace de la classe à charger dans $namespace,
		//$class prend la valeur de $class à partir de « \ » (on enlève le namespace),
		//et $class_to_load prend la valeur de $namespace en modifiant l'\ si nécessaire
		if($last = strripos($class, '\\')) {
			$namespace  = substr($class, 0, $last);
			$class      = substr($class, $last + 1);
			$class_to_load .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}

		//$class_to_load est concaténé à .php (fichier PHP)
		$class_to_load .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

		//Enfin, inclut la classe si elle existe
		if(file_exists($class_to_load)) require $class_to_load;

	}

	/**
	 * Fonction à lancer qui permet de charger automatiquement les classes
	 * @param void
	 * @return void
	 * @static
	 */
	public static function autoloader() {

		spl_autoload_register(__NAMESPACE__ . '\\Minichat::register_autoload');

	}

	/**
	 * Retourne un boolean en fonction de l'existence du pseudo (dans la liste des connectés)
	 * @param String $pseudo
	 * @return bool
	 * @static
	 */
	public static function pseudo_exists($pseudo) {

		$list = new Data('connected.json');
		$list = $list->getData();

		//Insensible à la casse
		//La liste des connectés comprend le pseudo et le timestamp doù le $pseudo['0']
		foreach($list as $pseudo) {
			if(strtolower($pseudo['0']) == strtolower($pseudo)) {
				return true;
			}
		}

		return false;

	}

	/**
	 * Crée un pseudo, génère un pseudo pour un utilisateur anonyme
	 * @param void
	 * @return String
	 */
	public static function create_pseudo() {

		$list = new Data('pokemon.txt');
		$list = $list->getData();
		$pseudo = '';

		do {
			$pseudo = $list[array_rand($list)]:
		} while(self::pseudo_exists($pseudo));

		return $pseudo;

	}

	/**
	 * Crée un captcha dans un session
	 * Attention, la session doit être démarrée
	 * @param bool $header Affiche si true l'image dans une page
	 * @return void|bool
	 * @static
	 */
	public static function function session_captcha($header = false) {

		if(!isset($_SESSION)) return false;

		if($header) header('Content-type: image/jpeg');
		
		//Génère un ID aléatoire, le hashe, prend ses 5 premiers éléments en majuscule
		$_SESSION['captcha'] = strtoupper(substr(md5(uniqid()), 0, 5));
		
		$image = imagecreate(55, 30);

		$background = imagecolorallocate($image, 0, 0, 0);
		$grey = imagecolorallocate($image, 25, 25, 25);
		$white = imagecolorallocate($image, 255, 255, 255);

		imagestring($image, 5, 5, 5, $_SESSION['captcha'], $white);
		$r = rand(1, 5);

		for($i = 0; $i<$r; $i++) {
			imageline($image, rand(0, 26), rand(0, 30), rand(27, 55), rand(0, 30), $grey);
		}

		imagejpeg($image, null, 0);
		
	}

	/**
	 * Détecte si AJAX utilisé
	 * @param void
	 * @return bool
	 * @static
	 */
	public static function is_ajax() {

		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XmlHttpRequest';

	}

	/**
	 * Hashe la chaîne en paramètre
	 * @param String $string Chaîne à hasher
	 * @param String $salt Salage
	 * @return String
	 * @static
	 */
	public static function encrypt($string, $salt = 'mdp_salage999') {

		//Salage de la chaîne et majuscule
		$string = strtoupper($salt . $string);
		//Hashe en MD5 puis en SHA1
		$string = sha1(md5($string));
		//Retourne la chaîne hashée
		return $string;
		
	}

	/**
	 * Poste un message
	 * @param User $user
	 * @param String $msg
	 * @return void
	 * @static
	 */
	public static function post(User $user, $msg) {

		//Récupération des messages
		$data = new Data('msg.json');
		$list = $data->getData();
		//Si pas de message crée un tableau
		if(!$list) $list = array();

		//Rajoute au tableau des messages un tableau contenant le timestamp, le pseudo, la couleur et le message
		array_push($list, [
			time(),
			$user->getPseudo(),
			$user->getColor(),
			$msg
		]);
		//Si on dépasse les 500 messages le premier est supprimé
		if(count($list) > 500) array_shift($list);

		//Enfin écrit dans le fichier
		$data->setData($list);

	}
	
}