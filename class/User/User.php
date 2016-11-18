<?php
/**
 * Interface user
 * @package Minichat
 */

namespace Minichat\class\User;

interface User {

	/**
	 * Retourne le pseudo de l'utilisateur
	 * @param void
	 * @return String
	 */
	public function getPseudo();

	/**
	 * Retourne la couleur de l'utilisateur (en fonction de son rang)
	 * @param void
	 * @return String
	 */
	public function getColor();

}