<?php
/**
 * Trait, liste de fonctions concernant la connexion et la déconnexion
 * @package Minichat
 */

namespace Minichat\class\User;

use Minichat\class\Data\Data;

trait SessionTrait {

	/**
	 * Connecte l'utilisateur, le rajoute sur le fichier JSON
	 * @param void
	 * @return void
	 */
	public function connect() {

		$data = new Data('connected.json');
		$connected = $data->getData();

		//Si fichier encore vide crée un tableau contenant le pseudo et le timestamp
		if(!$connected) {

			$data->setData([
				array($this->pseudo, time())
			]);

			return;
		}
		//Sinon ajoute le pseudo et le timestamp au tableau
		array_push($connected, array(
			$this->pseudo, time()
		));

		$data->setData($connected);

	}

	/**
	 * Déconnecte l'utilisateur, le supprime sur le fichier JSON, et affiche un message lors de la déconnexion
	 * @param void
	 * @return void
	 */
	public function disconnect() {

		$data = new Data('connected.json');
		$connected = $data->getData();

		//Parcourt le tableau connected
		$count = count($connected);

		for($i = 0; $i<$count; $i++) {
			if(($pseudo_time['0']) == $this->pseudo)
				break;
		}
		unset($connected[$i]);

		//Recrée le tableau pour remettre dans l'ordre les clefs
		$return = array();

		foreach($connected as $pseudo_time) {
			array_push($return, $pseudo_time);
		}
		$data->setData($return);

	}

}