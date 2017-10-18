<?php

namespace projet\model;

use DOMDocument;

class RSS {
	private $titre; // Titre du flux
	private $url; // Chemin URL pour télécharger un nouvel état du flux
	private $date; // Date du dernier téléchargement du flux
	private $nouvelles; // Liste des nouvelles du flux dans un tableau d'objets Nouvelle

	// Contructeur
	function __construct($url) {
		$this->url = $url;
	}

	// Fonctions getter
	function getTitre() {
		return $this->titre;
	}
	function getUrl() {
		return $this->url;
	}
	function getDate() {
		return $this->date;
	}
	function getNouvelles(): array {
		return $this->nouvelles;
	}

	// Récupère un flux à partir de son URL
	function update() {
		// Cree un objet pour accueillir le contenu du RSS : un document XML
		$doc = new DOMDocument ();

		// Telecharge le fichier XML dans $rss
		$doc->load ( $this->url );

		// Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
		$nodeList = $doc->getElementsByTagName ( 'title' );

		// Met à jour le titre dans l'objet
		$this->titre = $nodeList->item ( 0 )->textContent;

		// on recupere la date de publication
		$nodeList = $doc->getElementsByTagName ( 'pubDate' );

		// on met a jour l'objet
		$this->date = $nodeList->item ( 0 )->textContent;

		// on recupere les nouvelles
		$nodeList = $doc->getElementsByTagName ( 'item' );

		$i = 0;

		// Récupère tous les items du flux RSS
		foreach ( $nodeList as $node ) {

			// Création d'un objet Nouvelle à conserver dans la liste $this->nouvelles
			$nouvelle = new Nouvelle ();

			// Modifie cette nouvelle avec l'information téléchargée
			$nouvelle->update ( $node );
			$nouvelle->downloadImage ( $node->getElementsByTagName ( 'enclosure' )->item ( 0 ), $i );
			$news [$i] = $nouvelle;

			$i ++;
		}
		$this->nouvelles = $news;
	}
}


