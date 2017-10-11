<?php
// Test de la classe RSS
use projet\model\RSS;
use projet\model\nouvelle;

require_once ('RSS.php');
require_once ('nouvelle.php');

// Une instance de RSS
$rss = new RSS ( 'http://www.lemonde.fr/m-actu/rss_full.xml' );

// Charge le flux depuis le réseau
$rss->update ();

// Affiche le titre
echo $rss->getTitre () . "\n";
echo $rss->getDate () . "\n";
$nouvelles = $rss->getNouvelles ();
foreach ( $nouvelles as $nouvelle ) {
	echo "----------------------- \n";
	echo $nouvelle->getTitre () . "\n";
}
?>