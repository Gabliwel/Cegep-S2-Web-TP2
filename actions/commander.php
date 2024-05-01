<?php
  //Porte d'entrée de mon application
  //Bootstrap = démarrage de l'application web
  define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
  
  require DOCROOT."/includes/config.inc.php";
  require DOCROOT."/includes/debug.inc.php";
  require DOCROOT."/includes/functions.inc.php";
  
  session_start();
  $db = connecterDb();
  
  if(isset($_POST["action"]) && $_POST["action"] == "commander")
  {
    if(isset($_POST["modePaiment"]) && $_POST["modePaiment"] != "")
    {
      //Si le mode de paiment est valide
      if($_POST["modePaiment"] == "chèque" || $_POST["modePaiment"] == "comptant" || $_POST["modePaiment"] == "crédit" || $_POST["modePaiment"] == "paypal")
      {
        $articleManqueDeStock = validationPanier($db);
        $countArticleManqueDeStock = count($articleManqueDeStock);
        //Si avec la quantite en stock on peut accepter la commande
        if($countArticleManqueDeStock == 0)
        {
          $panier = lire_session("panier"); 
          $estConnecte = lire_session("estConnecte");
          $client = obtenirClientEnSession($db, $estConnecte);
          $id = (int)$client['id'];
          //on fait la commande avec les infos en session 
          creerCommande($db, $_POST['modePaiment'], $id);
          
          $count = count($panier);
          $commandes = obtenirCommande($db, $client['id']);
          $countCommandeClient = count($commandes);
          $idCommande = $commandes[$countCommandeClient-1]["id"];

          //pour chaque produit, on fait la commande du produit et on diminu la quantite
          for($i = 0; $i < $count; $i++)
          {
            creerProduitCommande($db, $panier[$i]["idProduit"], $idCommande, $panier[$i]["quantite"]);
            $produit = obtenirProduit($db, $panier[$i]["idProduit"]);
            $quantiteMax = (int)$produit["quantite"];
            $nouvelleQuantite = $quantiteMax - $panier[$i]["quantite"];
            modifierProduit($db, $panier[$i]["idProduit"], $nouvelleQuantite);
          }
          //on efface la panier et on fait une redirection vers la page des commandes
          delete_session("panier");
          redirect("commande?success=true");
        }
        else
        {
          redirect("panier?success=erreur");
        }
      }
      else
      {
        redirect("panier?success=false");
      }
    }
    else
    {
      redirect("panier?success=false");
    }
  }
  else
  {
    redirect();
  }
  
  