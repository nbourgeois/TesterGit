<?php
class Vue{
	private $fichier;
	private $donnees;
	function __construct($controleur,$action){
		$this->fichier='../vues/'.strtolower($controleur).'/'.strtolower($action).'.php';
		$this->donnees=array();		
	}
	function __set($cle,$valeur){
		return $this->donnees[$cle]=$valeur;
	}
	function __get($cle){
		if(!isset($this->donnees[$cle])){
			var_dump($cle);
			var_dump($this);
			exit();
		}
		return $this->donnees[$cle];		
	}
	function __isset($cle){
		return isset($this->donnees[$cle]);
	}
	function __unset($cle){
		unset($this->donnees[$cle]);
	}
	function afficher(){
		include($this->fichier);
	}
}