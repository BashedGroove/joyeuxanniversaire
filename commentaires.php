<?php 
  
    { $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); }
  ?>

<!DOCTYPE html>
<html lang=fr>
<head>
  <link rel="stylesheet" href="style.css" />
  <title>4.7 - Blog - Commentaires</title>
</head>
<body>

<a href="index.php">Retour à la liste des billets</a>

<?php
  if (isset($_GET['billet']))
  {
    $billet = $_GET['billet'];
  }
  else
  {
    header('Location: index.php');
  }

  $req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y %Hh%imin%ss\') AS date_creation FROM billets WHERE id =?');
  $req->execute(array($_GET['billet']));

  $donnees = $req->fetch();
    echo '<div class="news"><h3>'.$donnees['titre'].' le '.$donnees['date_creation'].'</h3><p>'.$donnees['contenu'].'<br/><em><a href=\'commentaires.php?billet='.$donnees['id'].'\'>Commentaires</a></em></p></div>';

    echo '<h1>Commentaires</h1>';

  $req->closeCursor();

  $req = $bdd->prepare('SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y %Hh%imin%ss\') AS date_commentaire FROM commentaires WHERE id_billet = ?');
  $req->execute(array($_GET['billet']));

  while ($donnees = $req->fetch())
  {
    echo '<p><b>'.$donnees['auteur'].'</b> le '.$donnees['date_commentaire'].'<br/>'.$donnees['commentaire'].'</p>';
  }

  $req->closeCursor();

?>

</body>
</html>