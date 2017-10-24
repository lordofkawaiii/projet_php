<?php
global $out;
$dao = new DAO ();
$i = 0;
foreach ( $dao->readAllUrlFromRSS () as $url ) {
	$out [i] = $url;
}
?>