<?php
  session_start();
  $db = connecterDb();
?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>
<!-- Le background est en style car, pour x raison, ne fonctionne pas en classe dans le main css-->
<body style="background-image: url('/img/fond2.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
  <?php require DOCROOT.'/includes/header.inc.php';?>
  <!--La classe en main et son style centre ses éléments -->
  <main class="d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="container text-center text-white">
      <h1 class="titre font-monospace">LA BOUTIQUE</h1>
      <p>Avez-vous déjà attendu parlé de Akihabara? Il s’agit d'un grand quartier commerçant de Tokyo connu pour différentes raisons, dont ses nombreux mangas qui s'y trouvent. Mais que diriez d'un catalogue de mangas presque aussi rempli que se que peut nous offrir cet endroit connu, et être capable de les avoirs en français. C'est la mission de notre petite nouvelle marque: La Boutique 漫画(manga)!</p>
      <!--Formulaire de cherche de produits -->
      <form method="GET" action="produits?recherche=true">
        <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Vous cherchez quelque chose en particulier?">
        <br>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
      </form>
    </div>
  </main>
  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
