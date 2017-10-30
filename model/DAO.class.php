<?php
use projet\model\RSS;
use projet\model\nouvelle;
class DAO {
	private $db; // L'objet de la base de donnée

	// Ouverture de la base de donnée
	function __construct() {
		$dsn = 'sqlite:../model/rss.db'; // Data source name
		try {
			$this->db = new PDO ( 'sqlite:../model/rss.db' );
		} catch ( PDOException $e ) {
			exit ( "Erreur ouverture BD : " . $e->getMessage () );
		}
	}

	// ////////////////////////////////////////////////////////
	// Methodes CRUD sur RSS
	// ////////////////////////////////////////////////////////

	// Crée un nouveau flux à partir d'une URL
	// Si le flux existe déjà on ne le crée pas
	function createRSS($url) {
		$rss = $this->readRSSfromURL ( $url );
		if ($rss == NULL) {
			try {
				$titre = explode ( '.', $url );
				$q = "INSERT INTO RSS (titre,url) VALUES ('$titre[1]','$url')";
				$r = $this->db->exec ( $q );
				if ($r == 0) {
					die ( "createRSS error: no rss inserted\n" );
				}
				return $this->readRSSfromURL ( $url );
			} catch ( PDOException $e ) {
				die ( "PDO Error :" . $e->getMessage () );
			}
		} else {
			// Retourne l'objet existant
			return $rss;
		}
	}
	function deleteRSS($titre) {
		$q = "select * FROM rss WHERE titre LIKE '%$titre%'";
		$r = $this->db->query ( $q );
		$resif = $r->fetchall ();
		if (! (empty ( $resif ))) {
			try {
				$q = "DELETE FROM nouvelle WHERE RSS_id LIKE '%$titre%'";
				$r = $this->db->exec ( $q );
				if ($r == 0) {
					die ( "createRSS error: no rss deleted2\n" );
				}
				$q = "DELETE FROM RSS WHERE titre LIKE '%$titre%'";
				$r = $this->db->exec ( $q );
				if ($r == 0) {
					die ( "createRSS error: no rss deleted1\n" );
				}
			} catch ( PDOException $e ) {
				die ( "PDO Error :" . $e->getMessage () );
			}
		}
	}

	// Acces à un objet RSS à partir de son URL
	function readRSSfromURL($url) {
		$sql = "SELECT * from RSS WHERE url='$url'";
		$res = array ();
		$res = $this->db->query ( $sql );
		if ($res) {
			$tab = $res->fetchAll ();
		} else {
			$tab = null;
		}
		return $tab;
	}
	function readAllUrlFromRSS() {
		$sql = 'SELECT * FROM RSS';
		$res = $this->db->query ( $sql );
		$tab = $res->fetchAll ();
		return $tab;
	}
	function readNewsFromRss($url) {
		$sql = "SELECT * FROM nouvelle WHERE RSS_id='$url'";
		$res = $this->db->query ( $sql );
		$tab = $res->fetchAll ();
		return $tab;
	}
	function readNewsFromKey($key) {
		$sql = "SELECT * FROM nouvelle WHERE description like '%$key%";
		$res = $this->db->query ( $sql );
		$tab = $res->fetchAll ();
		return $tab;
	}
	// Met à jour un flux
	function updateRSS(RSS $rss) {
		// Met à jour uniquement le titre et la date
		$titre = $this->db->quote ( $rss->titre () );
		$q = "UPDATE RSS SET titre=$titre, date='" . $rss->date () . "' WHERE url='" . $rss->url () . "'";
		try {
			$r = $this->db->exec ( $q );
			if ($r == 0) {
				die ( "updateRSS error: no rss updated\n" );
			}
		} catch ( PDOException $e ) {
			die ( "PDO Error :" . $e->getMessage () );
		}
	}

	// ////////////////////////////////////////////////////////
	// Methodes CRUD sur Nouvelle
	// ////////////////////////////////////////////////////////

	// Acces à une nouvelle à partir de son titre et l'ID du flux
	function readNouvellefromTitre($titre, $RSS_id) {
		$sql = 'SELECT * FROM nouvelle WHERE titre=' . $titre . ' AND RSS_id=' . $RSS_id . '';
		$res = $this->db->query ( $sql );
		$tab = $res->fetchAll ( $res, PDO::FETCH_CLASS, "nouvelle" );
		return $tab;
	}

	// Crée une nouvelle dans la base à partir d'un objet nouvelle
	// et de l'id du flux auquelle elle appartient
	function createNouvelle(nouvelle $n, $RSS_id) {
		try {
			$nouv = $n->getTitre ();
			$sql = "SELECT * FROM nouvelle WHERE titre='$nouv'";
			$r = $this->db->exec ( $sql );
			if ($r != 0) {
				$date = $n->getDate ();
				$desc = $n->getDescription ();
				$url = $n->getUrl ();
				$img = $n->getUrlImage ();
				$sql = "INSERT INTO nouvelle(date,titre,description,url,image,RSS_id) VALUES ('$date','$nouv','$desc','$url','$img','$RSS_id')";
				$r = $this->db->exec ( $sql );
			}
		} catch ( PDOException $e ) {
			die ( "PDO Error :" . $e->getMessage () );
		}
	}

  function readAllNouvelle($id){
    $sql = 'SELECT * FROM nouvelle WHERE RSS_id='$id'';
    $res = $this->db->query ( $sql );
		$tab = $res->fetchAll ( $res, PDO::FETCH_CLASS, "nouvelle" );
		return $tab;
  }
}

function readNouvelle($id){
	$sql = 'SELECT * FROM nouvelle WHERE id='$id'';
	$res = $this->db->query ( $sql );
	$tab = $res->fetchAll ( $res, PDO::FETCH_CLASS, "nouvelle" );
	return $tab;
}
}
?>
