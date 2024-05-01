<?php
  $db = connecterDb();
  session_start();
  //action du panier
  if(lire_session("panier"))
  {
    //supprimer panier au complet 
    if(isset($_GET["supprimerPanier"]) && $_GET["supprimerPanier"]=="true")
    {
      delete_session("panier");
      redirect("panier");
    }
    //diminuer de un la quantite d'un article du panier
    if(isset($_GET["retireProduit"]) && is_numeric($_GET["retireProduit"]))
    {
      $produit = obtenirProduit($db, $_GET["retireProduit"]);
      changeQuantitePanier($produit, -1);
      redirect("panier");
    }
    //augmenter de un la quantite d'un article du panier
    if(isset($_GET["ajoutProduit"]) && is_numeric($_GET["ajoutProduit"]))
    {
      $produit = obtenirProduit($db, $_GET["ajoutProduit"]);
      if(!changeQuantitePanier($produit, 1))
      {
        redirect("panier?ajoutProduitMax=true");
      }
      redirect("panier");
    }
    //supprimer un article du panier
    if(isset($_GET["supprimeProduit"]) && is_numeric($_GET["supprimeProduit"]))
    {
      $produit = obtenirProduit($db, $_GET["supprimeProduit"]);
      supprimeProduitPanier($produit);
      redirect("panier");
    }
  }

?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">

  <?php require DOCROOT.'/includes/header.inc.php';?>
  <main class="container text-white">
    <h1>Panier</h1>
    <?php 
      //Si le panier existe
      if(lire_session("panier")):
        $panier = lire_session("panier"); 
        $count = count($panier);
        $total = 0;
        if(isset($_GET["ajoutProduitMax"]) && $_GET["ajoutProduitMax"]=="true")
        {
          echo "<p class='text-danger'>Vous avez déjà dans votre panier le total que nous avons en stock pour cet article!</p>";
        }
    ?>
    <table class='table table-striped'>
        <thead class='text-light'>
          <tr>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th><a class='btn btn-danger' href="panier?supprimerPanier=true">Supprimer le panier</a></th>
          </tr>
        </thead>
        <tbody>
        <?php 
        for($i = 0; $i < $count; $i++)
        {
          $infoProduit = obtenirProduit($db, $panier[$i]["idProduit"]);
          $total += ($infoProduit['prix'] * $panier[$i]['quantite']);
          echo 
          "<tr class='text-light'>
            <td>".$infoProduit['nom']."</td>
            <td>".$panier[$i]['quantite']."</td>
            <td>". number_format((float)$infoProduit['prix'] * $panier[$i]['quantite'], 2, '.', '')."$</td>
            <td>
              <div class='btn-group' role='group'>
              <a class='btn btn-primary' type='button' href='panier?retireProduit=".$infoProduit['id']."'>-</a>

              <a class='btn btn-primary' type='button' href='panier?ajoutProduit=".$infoProduit['id']."'>+</a>

              <a class='btn btn-danger' type='button' href='panier?supprimeProduit=".$infoProduit['id']."'>X</a>
            </td>
          </tr>";
        }
        ?>
        </tbody>
      </table>
      <h3>Total: <?php echo number_format((float)$total, 2, ".", "");?>$</h3>
      <?php 
      //Si on est connecte
      if(lire_session("estConnecte")):?>
        <form action="/actions/commander.php" method="POST" class="needs-validation" novalidate>
          <div>
            <label for="modePaiment">Mode de paiment</label>
            <select name="modePaiment" id="modePaiment" class="form-select"  required>
            <!--Les value ont des accents à cause de l'enum de la bd commande -->
              <option selected disabled value></option>
              <option value="chèque">Chèque</option>
              <option value="comptant">Comptant</option>
              <option value="crédit">Crédit</option>
              <option value="paypal">PayPal</option>
            </select>
            <div class="invalid-feedback">
              Veuiller selectionner un mode de paiment
            </div>
          </div>
          <br>
          <button class='btn btn-primary' type='submit' id="action" name="action" value="commander">Passer la commande</button>
        </form>
        <?php if(isset($_GET['success']) && $_GET["success"]=="false"):
          //Si il y a une erreur pendant la validation du mode de paiment
          ?>
          <p class="text-danger">Une erreur est survenu. Veuiller activer le javascript ou bien selectionner un mode de paiment.</p>
        <?php endif;?>
        <?php if(isset($_GET['success']) && $_GET["success"]=="erreur"):
          //Si il y a une erreur pendant la validation des stocks et du paniers
          $articleManqueDeStock = validationPanier($db);
          $countArticleManqueDeStock = count($articleManqueDeStock);
          ?>
          <p class="text-danger">Une erreur est survenu. Nous n'avons plus certains articles de votre panier en stock. Les voici:</p>
          <?php
            for($i = 0; $i < $countArticleManqueDeStock; $i++)
            {
              $infoProduit = obtenirProduit($db, $articleManqueDeStock[$i]);
              echo "<p class='text-danger'>".$infoProduit['nom'].": ".$infoProduit['quantite']." restant en stock</p>";
            }
          ?>
        <?php endif;?>
      <?php else:
        //Si l'utilisateur n<est pas connecte
        ?>
        <p class="text-danger">Veuillez vous connecter pour passer votre commande</p>
      <?php endif;?>
    <?php else:
      //Si le panier n'existe pas
      ?>
      <h4>Vous n'avez aucun article dans votre panier pour le moment</h4>
    <?php endif;?>
  </main>
  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
