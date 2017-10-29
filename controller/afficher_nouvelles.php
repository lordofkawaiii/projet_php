<?php
// Implementation du modele
require_once("../model/DAO.class.php");
require_once("../model/RSS.php");
require_once("../model/nouvelle.php")

// Recuperation des infos dans la query string
if(isset($_GET['idFlux'])){
  $id = $_GET['idFlux'];
}else{
  $error = 'afficher_nouvelles.php : l\'ID a été perdu dans la query string';
}
// Ouverture de la database
$db = new DAO();
$tabPres = false;
// Recuperation des donees de la base en fonction de la query string
$tabNouvelles = $db->readAllNouvelle($id);
$tabIDNouvelles = array();
foreach ($Id as $key) {
  $tabIDNouvelles[] = 
}
$tabPres = true;

// Passage des données a la vue
// Si il y a une Erreur
if(isset($erreur)){
  $data['erreur'] = $erreur
  include("../vue/error_view.php");
}elseif($tabPres) {
  $data['tabIDNouvelles'] = $tabIDNouvelles;
  include("../vue/afficher_nouvelles_view.php");
}
 ?>
