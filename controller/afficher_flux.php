<?php
use projet\model\RSS;
use projet\model\nouvelle;

require_once '../model/DAO.class.php';
require_once '../model/RSS.php';
require_once '../model/nouvelle.php';
if (isset ( $_GET ['flux'] )) {
	$flux = $_GET ['flux'];
} else {
	$flux = '';
}

global $data;
$bd = new DAO ();
$listeFlux = array ();
$listeFlux [] = new RSS ( 'http://www.lemonde.fr/m-actu/rss_full.xml' );
$listeFlux [] = new RSS ( 'http://www.01net.com/rss/info/flux-rss/flux-toutes-les-actualites/' );
foreach ( $listeFlux as $RSS ) {
	$RSS->update ();
	$bd->createRSS ( $RSS->getUrl () );
	foreach ( $RSS->getNouvelles () as $nouvelle ) {
		$bd->createNouvelle ( $nouvelle, $RSS->getUrl () );
	}
}

$urls = array ();
$urls = $bd->readAllUrlFromRSS ();

if ($flux != '') {
	// on a un flux qui est une adresse vers un flux
	$temp = $bd->readNewsFromRss ( $flux );
	$data ['flux'] = $temp;
	// on charge la vue avec un tableau de news en fonction du flux
	include '../vue/afficher_nouvelles_view.php';
} else {
	// on a pas de flux
	// on charge la page d'accueil
	$data ['RSS'] = $urls;
	include '../vue/afficher_flux_view.php';
}
?>