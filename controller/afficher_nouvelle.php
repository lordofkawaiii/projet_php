<?php
// Implementation du modele
require_once("../model/DAO.class.php");
require_once("../model/RSS.php");
require_once("../model/nouvelle.php")

// Recuperation des infos dans la query string
if(isset($_GET['idNouvelle'])){
  $id = $_GET['idNouvelle'];
}else{
  $error = 'afficher_nouvelle.php : l\'ID a été perdu dans la query string';
}

// Ouverture de la database
$db = new DAO();
$tabPres = false;
// Recuperation des donees de la base en fonction de la query string
$nouvelle = $db->readNouvelle($id);
$tabPres = true;

// Passage des données a la vue
// Si il y a une Erreur
if(isset($erreur)){
  $data['erreur'] = $erreur
  include("../vue/error_view.php");
}elseif($tabPres) {
  $data['nouvelle'] = $nouvelle;
  include("../vue/afficher_nouvelles_view.php");
}
 ?>
