<?php
  session_start();
  $db = connecterDb();
  if(!lire_session("estConnecte"))
  {
    redirect();
  }
  $estConnecte = lire_session("estConnecte");
  $client = obtenirClientEnSession($db, $estConnecte);
  $commande = obtenirCommande($db, $client["id"]);
  $count = count($commande);
?>

<!doctype html>
<html class="no-js" lang="fr">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
  <?php require DOCROOT.'/includes/header.inc.php';?>
  <main class="container text-light">
    <h1>Factures des commandes</h1>
    <?php if($count == 0): 
      //Si aucune commande existe
      ?>
      <p>Vous n'avez fait aucune commande pour l'instant!</p>
    <?php elseif($count > 0):
    //Sinon, on affiche toute les commandes
      if(isset($_GET["success"]) && $_GET["success"]=="true")
      {
        echo "<p>Votre dernière commande a bien été enregistré!</p>";
      } 
      echo "<p>Voici les commandes pour ".$client['prenom']." ".$client['nom'].", à l'adresse suivante: ".$client['adresse'].", ".$client['ville']." ".$client['province']."</p>";
      for($i = 0; $i < $count; $i++):?>
        <h3>Commande #<?php echo $commande[$i]["id"] ?></h3>
        <p>Date de la commande: <?php echo $commande[$i]["date"] ?></p>
        <p>Statut: <?php echo $commande[$i]["statut"] ?></p>
        <h5>Article(s) de la commandes</h5>
        <table class='table table-striped'>
          <thead class='text-light'>
            <tr>
              <th>Nom</th>
              <th>Quantité</th>
              <th>Prix</th>
            </tr>
          </thead>
          <tbody>
          <?php      
          $produits = obtenirProduitCommande($db, $commande[$i]["id"]);
          $countProduit = count($produits);   
          $total = 0;
          for($x = 0; $x < $countProduit; $x++)
          {
            $infoProduit = obtenirProduit($db, $produits[$x]["id_produit"]);
            $total += ($infoProduit['prix'] * $produits[$x]['quantite']);
            echo 
            "<tr class='text-light'>
              <td>".$infoProduit['nom']."</td>
              <td>".$produits[$x]['quantite']."</td>
              <td>". number_format((float)$infoProduit['prix'] * $produits[$x]['quantite'], 2, '.', '')."$</td>
            </tr>";
          }?> 
        <tbody>
      </table>
      <h5>Total: <?php echo number_format((float)$total, 2, ".", "");?>$</h5>
    <?php 
    echo "<br>";
    endfor;
    endif; 
    ?>
  </main>

  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
