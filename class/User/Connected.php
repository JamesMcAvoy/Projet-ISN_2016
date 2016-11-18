<?php
/**
 * Utilisateur connecté
 * @package Minichat
 */

namespace Minichat\class\User;

use Minichat\class\User\User;
use Minichat\class\User\SessionTrait;

class Connected implements User {

	/**
	 * Couleur du pseudo (connecté = vert)
	 * @var String
	 */
	private $color = '#20AA20';

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

}