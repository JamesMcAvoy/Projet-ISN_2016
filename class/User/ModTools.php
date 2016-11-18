<?php
/**
 * Classe abstraite qui décrit des outils de modération
 * @package Minichat
 */

namespace Minichat\class\User;

use Minichat\class\User\User;
use Minichat\class\Data\Data;

abstract class ModTools {

	/**
	 * Bannit un joueur
	 * Le bannissement peut être temporaire ou choisi par IP suivant le rang
	 */
	public abstract function ban();

	/**
	 * Supprime un message
	 * @param int $id
	 * @return void
	 */
	public function delete($id) {

		//Récupération des messages
		$data = new Data('msg.json');
		$list = $data->getData();

		//Si le message existe on le supprime
		if(isset($list[$id])) {
			unset($list[$id]);
		}

		//Enfin écrit dans le fichier
		$data->setData($list);

	}

	/**
	 * Kicke un utilisateur du minichat
	 * @param User $user
	 * @return bool
	 */
	public function kick(User $user) {


	}

	/**
	 * Interdit un utilisateur de poster
	 * @param User $user
	 * @return void
	 */
	public function mute(User $user) {

	}

}