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
if (isset ( $_GET ['RSSp'] )) {
	$RSSp = $_GET ['RSSp'];
} else {
	$RSSp = '';
}
if (isset ( $_GET ['RSSm'] )) {
	$RSSm = $_GET ['RSSm'];
} else {
	$RSSm = '';
}
global $data;
$bd = new DAO ();
// $listeFlux = array ();
// // les 2 flux rss de base
// $listeFlux [] = $bd->( 'SELECT * FROM RSS' );
// // $listeFlux [] = new RSS ( 'http://www.01net.com/rss/info/flux-rss/flux-toutes-les-actualites/' );

// foreach ( $listeFlux as $RSS ) {
// $RSS->update ();
// $bd->createRSS ( $RSS->getUrl () );
// foreach ( $RSS->getNouvelles () as $nouvelle ) {
// $bd->createNouvelle ( $nouvelle, $RSS->getUrl () );
// }
// }
// on rajoute a la base de donnée le nouveau flux
if ($RSSp != '') {
	$leFlux = new RSS ( $RSSp );
	$leFlux->update ();
	$bd->createRSS ( $leFlux->getUrl () );
	foreach ( $leFlux->getNouvelles () as $nouvelle ) {
		$bd->createNouvelle ( $nouvelle, $leFlux->getUrl () );
	}
	$_GET ['RSSp'] = '';
}
if ($RSSm != '') {
	$bd->deleteRSS ( $RSSm );
	$_GET ['RRSm'] = '';
}
$urls = array ();
$urls = $bd->readAllUrlFromRSS ();

// si il n'y a pas de flux, met le monde
if (empty ( $urls )) {
	$leFlux = new RSS ( 'http://www.lemonde.fr/m-actu/rss_full.xml' );
	$leFlux->update ();
	$bd->createRSS ( $leFlux->getUrl () );
	foreach ( $leFlux->getNouvelles () as $nouvelle ) {
		$bd->createNouvelle ( $nouvelle, $leFlux->getUrl () );
	}
}
$urls = array ();
$urls = $bd->readAllUrlFromRSS ();

if (($flux == '') || ($flux == 'retour')) {
	// on a pas de flux
	// on charge la page d'accueil
	$data ['RSS'] = $urls;
	include '../vue/afficher_flux_view.php';
} else {
	// on a un flux qui est une adresse vers un flux
	$temp = $bd->readNewsFromRss ( $flux );
	$data ['flux'] = $temp;
	// on charge la vue avec un tableau de news en fonction du flux
	include '../vue/afficher_nouvelles_view.php';
}
?>