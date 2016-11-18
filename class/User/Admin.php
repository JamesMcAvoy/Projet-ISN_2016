<?php
/**
 * Classe admin 
 * @package Minichat
 */

namespace Minichat\class\User;

use Minichat\class\User\User;
use Minichat\class\User\SessionTrait;
use Minichat\class\User\ModTools;

class Admin extends ModTools implements User {

	/**
	 * Couleur du pseudo (modérateur = orange)
	 * @var String
	 */
	private $color = '#EE2020';

	/**
	 * Pseudo de l'utilisateur anonyme
	 * @var String
	 */
	private $pseudo;

	/**
	 * Constructeur
	 * @param String pseudo
	 */
	public function __construct($pseudo) {

		$this->pseudo = $pseudo;

	}

	/**
	 * @see User::getPseudo()
	 */
	public function getPseudo() {

		return $this->pseudo;
	
	}

	/**
	 * @see User::getColor()
	 */
	public function getColor() {

		return $this->color;
	
	}

	use SessionTrait;

	/**
	 * Bannit un utilisateur temporairement, définitivement ou par IP
	 * L'utilisateur doit être anonyme ou connecté
	 * @param User $user
	 * @param mixed $type
	 * @return void
	 */
	public function ban(User $user, $type) {

	}

}