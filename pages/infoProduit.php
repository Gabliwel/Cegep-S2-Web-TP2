<?php
  session_start();
  $db = connecterDb();
  //Si on x raison, on a pas obtenu de id, on effectue une redirection
  if(!isset($_GET["id"]) || !is_numeric($_GET["id"]))
  {
    redirect("produits");
  }

  $produit = obtenirProduit($db, $_GET["id"]);
  lire_session("estConnecte");

  //ajout au panier
  if(isset($_GET["ajoutPanier"]) && $_GET["ajoutPanier"]=="true")
  {
    $produitDansPanier = obtenirProduit($db, $produit['id']);
    if(ajoutPanier($produitDansPanier))
    {
      redirect("infoProduit?id=".$produit['id']."&success=true");
    }
    else
    {
      redirect("infoProduit?id=".$produit['id']."&success=false");
    }
  }
?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;" >

  <?php require DOCROOT.'/includes/header.inc.php';?>
  <main class="container">
    <h3 class="text-white"><?php echo $produit['nom'] ?></h3>
    <div class="row">
      <div class="col-12 col-md-4">
        <img src="/img/<?php echo $produit["image"];?>" class="img-fluid" alt="ImageProduit">
      </div>
      <div class="col-12 col-md-8 text-white fw-bolder">
        <p>Description:</p>
        <p><?php echo $produit["description"];?></p>
        <p>Date de publication: <?php echo $produit["date"];?></p>
        <p>Quantité en stock: <?php echo $produit["quantite"];?></p>
        <p>Prix: <?php echo $produit["prix"];?>$</p>
        <!--Ajout au panier -->
        <?php
          if($produit['quantite']<=0)
          { 
            echo "<button href='infoProduit?id=".$produit['id']."&ajoutPanier=true' class='btn btn-primary' disabled>Ajouter au panier</button>";
            echo "<p class='text-danger'>Nous avons plus cet article en stock!</p>"; 
          } 
          else
          {
            echo "<a href='infoProduit?id=".$produit['id']."&ajoutPanier=true' class='btn btn-primary'>Ajouter au panier</a>";
          }
          //suite à l'ajout au panier
          if(isset($_GET["success"]) && $_GET["success"]=="true")
          {
            echo "<p>Article ajouté au panier</p>";
          }
          elseif(isset($_GET["success"]) && $_GET["success"]=="false")
          {
            echo "<p class='text-danger'>Vous avez déjà dans votre panier le total que nous avons en stock pour cet article!</p>"; 
          }
        ?>
      </div>
  </main>

  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
