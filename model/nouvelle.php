<?php

namespace projet\model;

use DOMElement;

class nouvelle {
	private $titre; // Le titre
	private $date; // Date de publication
	private $description; // Contenu de la nouvelle
	private $url; // Le lien vers la ressource associée à la nouvelle
	private $urlImage; // URL vers l'image

	// Contructeur
	function __construct() {
	}

	// Fonctions getter
	function getTitre() {
		return $this->titre;
	}
	function getDate() {
		return $this->date;
	}
	function getDescription() {
		return $this->description;
	}
	function getUrl() {
		return $this->url;
	}
	function getUrlImage() {
		return $this->urlImage;
	}

	// Charge les attributs de la nouvelle avec les informations du noeud XML
	function update(DOMElement $item) {
		// TODO
		$this->date = $item->getElementsByTagName ( 'pubDate' )->item ( 0 )->textContent;
		$this->titre = $item->getElementsByTagName ( 'title' )->item ( 0 )->textContent;
		$this->description = $item->getElementsByTagName ( 'description' )->item ( 0 )->textContent;
		$this->url = $item->getElementsByTagName ( 'link' )->item ( 0 )->textContent;
		$img = $item->getElementsByTagName ( 'enclosure' );
		if ($img->length != 0) {
			$this->urlImage = $img->item ( 0 )->getAttribute ( "url" );
		} else {
			$this->urlImage = "pas d'image pour cette nouvelle ¯\_('-')_/¯";
		}
	}
}

