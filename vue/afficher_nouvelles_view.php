<?php
use projet\model\nouvelle;
?>
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
<?php
print_r ( "<td><input align='center' type='submit' name='flux' value='retour'></td>" );
?>
<table>
<tr>
<th>le titre</th>
<th>la description</th>
<th>la date</th>
<th>acceder au contenu (site)</th>
</tr>
<?php
$nouvelles = new nouvelle ();
foreach ( $data ['flux'] as $nouvelles ) {
	print_r ( "<tr>
	<td>{$nouvelles['titre']}</td>
	<td>{$nouvelles['description']}</td>
	<td>{$nouvelles['date']}</td>
	<td><a href={$nouvelles['url']}>{$nouvelles['url']}</a></td>
	</tr>" );
}
?>
</table>
<?php
print_r ( "<td><input align='center' type='submit' name='flux' value='retour'></td>" );
?>
</form>
</body>
</html>