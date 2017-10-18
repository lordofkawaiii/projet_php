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
	// $item est l'url de l'image à telechargé et $imageID est le titre du flux de l'image
	function downloadImage(DOMElement $item, $imageId) {
		// On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
		// On tente d'accéder à l'attribut 'url'
		$item = $item->attributes->getNamedItem ( 'url' );
		if ($item != NULL) {
			// L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
			$url = $item->nodeValue;
			// On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
			$this->image = 'images/' . $imageId . '.jpg';
			// On télécharge l'image à l'aide de son URL, et on la copie localement.
			file_put_contents ( $this->image, file_get_contents ( $url ) );
		}
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
?>
