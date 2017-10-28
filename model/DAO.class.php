<?php
use projet\model\nouvelle;
use projet\model\RSS;
class DAO {
	private $db; // L'objet de la base de donnée

	// Ouverture de la base de donnée
	function __construct() {
		$dsn = 'sqlite:rss.db'; // Data source name
		try {
			$this->db = new PDO ( $dsn );
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
				$q = "INSERT INTO RSS (url) VALUES ('$url')";
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

	// Acces à un objet RSS à partir de son URL
	function readRSSfromURL($url) {
		$sql = 'SELECT * FROM RSS WHERE url=' . $url . '';
		$res = $this->db->query ( $sql );
		$tab = $res->fetchAll ( $res, PDO::FETCH_CLASS, "RSS" );
		return $tab;
	}

  function readAllUrlFromRSS(){
    $sql = 'SELECT url FROM RSS';
    $res = $this->db->query ( $sql );
    $tab = $res->fetchAll ( $res, PDO::FETCH_CLASS, "RSS" );
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
		$sql = 'INSERT INTO nouvelle(titre,RSS_id) VALUES (' . $n . ',' . $RSS_id . ')';
		try {
			$r = $this->db->exec ( $sql );
			if ($r == 0) {
				die ( "insertNouvelle error: no nouvelle insert\n" );
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
