<?php
  session_start();
  $db = connecterDb();

  //si une recherche est fait on filtre selon la recherche
  if(isset($_GET["recherche"]) && $_GET["recherche"]!="")
  {
    $produits = rechercheProduit($db, $_GET["recherche"]);
  }
  //sinon, on prend tout les produits
  else
  {
    $produits = obtenirProduits($db);
  }

  //ajout au panier
  if(isset($_GET["ajoutPanier"]) && $_GET["ajoutPanier"]=="true")
  {
    if(isset($_GET["id"]))
    {
      $produitDansPanier = obtenirProduit($db, $_GET["id"]);
      if(ajoutPanier($produitDansPanier))
      {
        redirect("produits?success=true");
      }
      else
      {
        redirect("produits?success=false");
      }
    }
  }
?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">

  <?php require DOCROOT.'/includes/header.inc.php';?>
  <main class="container">
    <h3 class="text-white">Nos produits</h3>
    <!--Formulaire de recherche de produits -->
    <form method="GET" action="produits?recherche=true">
      <div class="input-group mb-3">
        <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Vous cherchez quelque chose en particulier?">
        <button type="submit" class="btn btn-primary">Rechercher</button>
      </div>
    </form>
    <?php
      //si une recherche est fait, on affiche un message selon sa recherche
      if(isset($_GET["recherche"]) && $_GET["recherche"]!="")
      {
        $compteResultat = count($produits);
        echo '<p class="text-white"> Voici le(s) résultat(s) pour: "'.$_GET["recherche"].'" - '.$compteResultat.' résultat(s)';
      }
      //si on rajoute on article au panier
      if(isset($_GET["success"]) && $_GET["success"]=="true")
      {
        echo "<p class='text-white'>Article ajouté au panier</p>";
      }
      elseif(isset($_GET["success"]) && $_GET["success"]=="false")
      {
        echo "<p class='text-danger'>Vous avez déjà dans votre panier le total que nous avons en stock pour cet article!</p>"; 
      }
    ?>
    <div class="text-center">
      <div class="text-center row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php
      //Afiche chaque produit avec certaine information, ainsi que son bouton pour en savoir plus
        foreach($produits as $produit)
        {
          echo 
          "<div class='col'>
            <div class='card border-dark h-100'>
              <img src='/img/".$produit['image']."' class='card-img-top h-100' alt='ImageProduit'>
              <div class='card-body'>
                <h5 class='card-title'>".$produit['nom']."</h5>
                <p class='card-text'>".$produit['prix']."$</p>
                <div class='btn-group-vertical'>
                  <a href='infoProduit?id=".$produit['id']."' class='btn btn-primary' type='button'>Plus d'information</a>";
                  //Si on a plus d'un certain article en stock, on disabled son bouton pour ajouter au panier
                  if($produit['quantite']<=0)
                  {
                    echo "<button href='ajoutPanier?id=".$produit['id']."' class='btn btn-primary' type='button' disabled>Ajouter au panier</button>";
                  }
                  else
                  {
                    echo "<a href='produits?id=".$produit['id']."&ajoutPanier=true' class='btn btn-primary' type='button'>Ajouter au panier</a>";
                  }
                  echo "
                </div>
              </div>
            </div>
          </div>";
        }
      ?>
      </div>
    </div>
  </main>

  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
