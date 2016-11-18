<?php
/**
 * Classe qui permet la gestion des données
 * @package Minichat
 */

namespace Minichat\class\Data;

class Data {

	/**
	 * Lien vers le dossier contenant les données
	 * @var String
	 */
	private $link;

	/**
	 * Constructeur
	 * @param String $data
	 * fichier data sur lequel on va travailler
	 * (par exemple "pseudos.txt")
	 */
	public function __construct($data) {

		$sep = DIRECTORY_SEPARATOR;
		$this->link = str_replace($sep.'Minichat'.$sep.'class'.$sep.'Data', 'Minichat'.$sep.'data', __DIR__) . $sep . $data;

		//Si le fichier n'existe pas on lève une exception
		if(!file_exists($this->link)) throw new \Exception('Le fichier n\'existe pas !');

	}

	/**
	 * Récupère le format du fichier
	 * @param void
	 * @return String
	 */
	private function getFormat() {

		$format = explode('.', $this->link);

		//Retourne la dernière valeur du tableau qui correspond au format
		return $format[count($format) - 1];

	}

	/**
	 * Retourne le fichier en fonction de son format
	 * @param void
	 * @return String
	 */
	public function getData() {

		if($this->getFormat() == 'txt')
			return explode("\n", file_get_contents($this->link));

		elseif($this->getFormat() == 'json')
			return json_decode(file_get_contents($this->link));

	}

	/**
	 * Modifie le fichier en le réécrivant complètement
	 * @param String
	 * @return Data
	 */
	public function setData($data) {

		if($this->getFormat() == 'txt')
			file_put_contents($this->link, implode("\n", $data));

		elseif($this->getFormat() == 'json')
			file_put_contents($this->link, json_encode($data));

		return $this;

	}

}