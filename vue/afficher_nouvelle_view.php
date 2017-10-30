<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1> Afficher nouvelle </h1>
    <?php
      $nouvelles = new nouvelle ();
      $nouvelle = $data['nouvelle'];
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
      	print_r ( "<tr>
      	<td>{$nouvelles['titre']}</td>
      	<td>{$nouvelles['description']}</td>
      	<td>{$nouvelles['date']}</td>
      	<td><a href={$nouvelles['url']}>{$nouvelles['url']}</a></td>
      	</tr>" );
      ?>
      </table>
      <?php
      print_r ( "<td><input align='center' type='submit' name='flux' value='retour'></td>" );
      ?>
     ?>
  </body>
</html>
