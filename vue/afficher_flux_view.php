<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>voici la liste des flux</title>
<link rel="stylesheet" type="text/css" href="../vue/test.css">
<style type="text/css">
</style>
</head>
<body>
<form action="afficher_flux.php">
<table align="center">
<tr>
<th>Les sites:</th>
<th>Les liens vers le flux RSS:</th>
<th>Consulter les dernieres news</th>
</tr>
<?php
foreach ( $data ['RSS'] as $url ) {
	$temp = explode ( '/', $url ['url'] );
	$site = $temp [0] . '//' . $temp [1] . $temp [2];
	print_r ( "<tr>
	<td><a href={$site}>{$site}</a></td>
	<td><a href={$url['url']}>{$url['titre']}</a></td>
	<td><input type='submit' name='flux' class = {$url['url']} value='{$url['url']}'></td>
	</tr>" );
}
?>
</table>
<p>
  Si vous voulez rajouter un flux:<br>
  <input type="text" name="RSSp" placeholder="inserez un lien de flux rss"><br>
  <input type="submit">
</p>
<p>
  Si vous voulez supprimer un flux:<br>
  <input type="text" name="RSSm" placeholder="inserez un titre de flux rss"><br>
  <input type="submit">
</p>
</form>
</body>
</html>
