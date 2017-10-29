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
<table>
<tr>
<td>les sites:</td>
<td>les liens vers le flux RSS:</td>
<td>consulter les dernieres news</td>
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
</form>
</body>
</html>