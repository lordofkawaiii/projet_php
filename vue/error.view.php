<html>
<head>
  <meta charset="UTF-8">
</head>
<body>
<h1> Le Jeu du nombre : une erreur interne est survenue</h1>
<p> <?= $data['error']?> </p>
<form action="main.ctrl.php">
  <input type="hidden" name="nom" value="<?= $data['nom']?>"/>
  <input type="submit" value="Recommencer" />
</form>
</body>
</html>
