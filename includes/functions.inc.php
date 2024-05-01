<?php
  declare(strict_types=1); //obligatoire

  /***********************redirection via le lien en paramètre, ou via l'accueil si problème**************/
  function redirect(string $url = "")
  {
    if($url =="")
    {
      header("Location: "."/");
    }
    else
    {
      header("Location: "."/".$url);
    }
    exit();
  }

  /***************************************Connection à la db phpMyAdmin selon la config********************************/
  function connecterDb()
  {
    try 
    {
      $db = new PDO('mysql:host=localhost;dbname='.DBNAME.';charset=utf8', DBUSERNAME, DBPASSWORD);
    }
    catch(PDOException $e) 
    {
      echo "Impossible de se connecter!";
      die();
    }
    return $db;
  }
  
  /*******************************************Fonction de session*************************************/
  // Création d'une variable de session
  // En paramètre le nom et la valeur de la variable
  function creer_session($nom_session, $valeur_session = "")
  {
    $_SESSION[$nom_session] = $valeur_session;
    //si tout s'est bien déroulé
    if(isset($_SESSION[$nom_session]))
    {
      return true;
    } 
    else 
    {
      return false;
    }
  }

  // Lecture d'une variable de session
  // En paramètre le nom de la variable
  function lire_session($nom_session)
  {
    if(isset($_SESSION[$nom_session]))
    {
      return $_SESSION[$nom_session];
    } 
    else 
    {
      return false;
    }
  }

  // Mise à jour d'une variable de session
  // En paramètre le nom et la valeur de la variable /*IMPORTANT*/
  function update_session($nom_session, $valeur_session)
  {
    if(isset($_SESSION[$nom_session]))
    {
      $_SESSION[$nom_session] = $valeur_session;
      return true;
    } 
    else 
    {
      return false;
    }
  }
  
  // Suppression d'une variable de session
  // En paramètre le nom de la variable
  function delete_session($nom_session)
  {
    if(isset($_SESSION[$nom_session]))
    {
      unset($_SESSION[$nom_session]);
      return true;
    } 
    else 
    {
      return false;
    }
  }

  /*******************************************Fonction de cookie*************************************/

  // Création d'une variable de cookie
  // En paramètre le nom et la valeur de la variable
  function create_cookie($nom_cookie, $valeur_cookie = "", $nb_jours = 365)
  {
    // On créer notre variable de cookie à partir d'un paramètre
    setcookie($nom_cookie, $valeur_cookie, time() + $nb_jours*24*3600, '/', "", false, true);
    //si tout s'est bien déroulé
    if(isset($_COOKIE[$nom_cookie]))
    {
      return true;
    } 
    else 
    {
      return false;
    }
  }

  // Lecture d'une variable de cookie
  // En paramètre le nom de la variable
  function read_cookie($nom_cookie)
  {
    if(isset($_COOKIE[$nom_cookie]))
    {
      return $_COOKIE[$nom_cookie];
    } 
    else 
    {
      return false;
    }

  }

  // Suppression d'une variable de cookie
  // En paramètre le nom de la variable
  function delete_cookie($nom_cookie)
  {
    if(isset($_COOKIE[$nom_cookie]))
    {
      unset($_COOKIE[$nom_cookie]);
      setcookie($nom_cookie, '', time() - 42000, '/');
      return true;
    } 
    else 
    {
      return false;
    }
  }

  /*******************************************Fonction de client*************************************/
  //obtient les informations du clients si son login et mdp sont existant
  function obtenirClient($db, $login, $mdp)
  {
    /* 1ère étape : les données */
    $datas = array(
      'usager' => $login,
      'courriel' => $login,
      'mot_passe' => $mdp
    );
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM client WHERE (`mot_passe`=:mot_passe AND `courriel`=:courriel) OR (`mot_passe`=:mot_passe AND `usager`=:usager)"; //le SQL
    $qry = $db->prepare($sql);
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $connexion = $qry->fetchAll(); //le résultat dans un tableau
    return $connexion;
  }

  //obtient tout clients qui ont le même login et/ou usager, donc normalement 1 ou 0
  function obtenirClientLoginDisponible($db, $courriel, $usager)
  {
    /* 1ère étape : les données */
    $datas = array(
      'courriel' => $courriel,
      'usager' => $usager
    );
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM client WHERE (`courriel`=:courriel) OR (`usager`=:usager)"; //le SQL
    $qry = $db->prepare($sql);
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $connexion = $qry->fetchAll(); //le résultat dans un tableau
    return $connexion;
  }

  //obtient les informations du clients selon son id en session
  function obtenirClientEnSession($db, $id)
  {
    /* 1ère étape : les données */
    $datas = array(
      'id' => $id
    );
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM client WHERE `id`=:id"; //le SQL
    $qry = $db->prepare($sql);
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $connexion = $qry->fetchAll(); //le résultat dans un tableau
    return $connexion[0];
  }
  
  //Création d'un client
 function creerClient($db, $infos)
  {
    $datas = array(
     'prenom' => $infos["prenom"],
     'nom' => $infos["nom"],
     'adresse' => $infos["adresse"],
     'ville' => $infos["ville"],
     'province' => $infos["province"],
     'code_postal' => $infos["code_postal"],
     'usager' => $infos["usager"],
     'mot_passe' => $infos["mot_passe"],
     'courriel' => $infos["courriel"]
    );

    /* 2ème étape : préparer la requête */
    $sql =  "INSERT INTO client (prenom, nom, adresse, ville, province, code_postal, usager, mot_passe, courriel) VALUES (:prenom, :nom, :adresse, :ville,  :province, :code_postal, :usager, :mot_passe, :courriel)";
    $qry = $db->prepare($sql);

    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
  }


  //Modification d'un client
  function modifierClient($db, $infos, $id)
  {
    /* 1ère étape : les données */
    $datas = array(
      'id' => $id,
      'prenom' => $infos["prenom"],
      'nom' => $infos["nom"],
      'adresse' => $infos["adresse"],
      'ville' => $infos["ville"],
      'province' => $infos["province"],
      'code_postal' => $infos["code_postal"],
      'mot_passe' => $infos["mot_passe"]
    );

    /* 2ème étape : préparer la requête */
    $sql = "UPDATE client SET `prenom` = :prenom, `nom` = :nom, `adresse` = :adresse, `ville` = :ville, `province` = :province, `code_postal` = :code_postal, `mot_passe` = :mot_passe WHERE `id` = :id"; //le SQL
    $qry = $db->prepare($sql);  

    /* 3ème étape: On exécute la requête */
    $count = $qry->execute($datas);
    return $count;
  }


  /*******************************************Fonction de produit*************************************/
  //fonction de db avec les produits
  //obient l'ensemble des produits
  function obtenirProduits($db)
  {
    /* 1ère étape : les données */
    $datas = array();
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM produit"; //le SQL
    $qry = $db->prepare($sql);
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $produits = $qry->fetchAll(); //le résultat dans un tableau cities

    return $produits;
  }
  //obtient 1 produit selon son id
  function obtenirProduit($db, $id)
  {
    /* 1ère étape : les données */
    $datas = array(
      'id' => $id
    );
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM produit WHERE `id`=:id"; //le SQL
    $qry = $db->prepare($sql);
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $produit = $qry->fetchAll(); //le résultat dans un tableau

    return $produit[0];
  }

  //obient l'ensemble des produits selon une recherche
  function rechercheProduit($db, $recherche)
  {
    /* 1ère étape : les données */
    $datas = array();
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM produit WHERE `nom` LIKE '%".$recherche."%'"; //le SQL
    $qry = $db->prepare($sql);
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $produits = $qry->fetchAll(); //le résultat dans un tableau cities

    return $produits;
  }
  
  //Modification de la quantite d'un produit
  function modifierProduit($db, $id, $quantite)
  {
    /* 1ère étape : les données */
    $datas = array(
      'id' => $id,
      'quantite' => $quantite
    );

    /* 2ème étape : préparer la requête */
    $sql = "UPDATE produit SET `quantite` = :quantite WHERE `id` = :id"; //le SQL
    $qry = $db->prepare($sql);  

    /* 3ème étape: On exécute la requête */
    $count = $qry->execute($datas);
    return $count;
  }


  /******************************** Validation du client pour la création et la modification **************************/
  //regex de validation d'un code postal canadien
  function valideCanadianPostalCode($code_postal)
  {
    $expression = '/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/';
    $valid = (bool)preg_match($expression, $code_postal);
    return $valid;
  }

  //validation serveur pour la modification des infos client 
  //on valide aussi la longueur selon la structure bd
  function validationClientSansLogin($infos)
  {
    $validForm = true;
    if(!isset($infos["prenom"]) || $infos["prenom"] == "" || strlen($infos["prenom"]) > 150) {
        $validForm = false;
    }elseif (!isset($infos["nom"]) || $infos["nom"] == "" || strlen($infos["nom"]) > 200){
        $validForm = false;
    }elseif(!isset($infos["adresse"]) || $infos["adresse"] == ""){
        $validForm = false;
    }elseif(!isset($infos["ville"]) || $infos["ville"] == "" || strlen($infos["ville"]) > 150){
        $validForm = false;
    }elseif(!isset($infos["province"]) || $infos["province"] == "" || strlen($infos["province"]) > 100){
        $validForm = false;
    }elseif(!isset($infos["code_postal"]) || $infos["code_postal"] == "" || !valideCanadianPostalCode($_POST["code_postal"]) || strlen($infos["code_postal"]) != 6){
        $validForm = false;
    }elseif(!isset($infos["mot_passe"]) || $infos["mot_passe"] == "" ||strlen($infos["mot_passe"]) > 255){
        $validForm = false;
    }elseif(!isset($infos["mot_passe_confirmation"]) || $infos["mot_passe_confirmation"] == "" || $infos["mot_passe_confirmation"] != $infos["mot_passe"] || strlen($infos["mot_passe"]) > 255){
        $validForm = false;
    }
    return $validForm;
  }
  
  //validation serveur pour la creation d'un client
  //on appelle la fonction sans login pour valider le reste 
  function validationClientAvecLogin($infos)
  {
    $validForm = true;
    if (!validationClientSansLogin($infos)) {
        $validForm = false;
    }elseif (!isset($infos["usager"]) || $infos["usager"] == "" || strlen($infos["usager"]) > 50) {
        $validForm = false;
    }elseif (!isset($infos["courriel"]) || $infos["courriel"] == "" || !filter_var($infos["courriel"], FILTER_VALIDATE_EMAIL) || strlen($infos["courriel"]) > 200) {
        $validForm = false;
    }
    return $validForm;
  }

  /*************************************************Fonction de panier ********************************************************/
  //Ajout au panier si la session panier existe, sinon, création du panier avec l'ajout de l'article
  function ajoutPanier($produit)
  {
    //guarde un id du produit sous forme de int
    $produitId = $produit["id"];
    $id = (int)$produitId;
    //si le panier existe
    if(lire_session("panier"))
    {
      //guarde de la panier dans un array
      $array = lire_session("panier");
      //compte le nombre d'élément dans le arrau panier
      $count = count($array);
      $trouve = false;
      //pour chaque produit
      for($i = 0; $i < $count; $i++)
      {
        //si le id du produits est trouvé dans le panier
        if($id == $array[$i]["idProduit"])
        {
          //si il en a déjà le maximun dans le panier comparé à la quantité en stock, on retourne false
          if($produit["quantite"] == null || $produit["quantite"] == 0 || $produit["quantite"] - $array[$i]["quantite"] <= 0)
          {
            return false;
          }
          //sinon, on augmente la quantite de un
          else
          {
            $array[$i]["quantite"]++; 
            $trouve = true;
          }
        }
      }
      //si il n'est pas trouvé on rajoute le produit
      if($trouve == false)
      {
        $array[$count] = array("idProduit"=>$id, "quantite"=>1);
      }
      //et on fini par enregistrer les modifications
      update_session("panier", $array);
      return true;
    }
    //sinon, quand le panier existe pas, on le créer avec comme première valeur le produit
    else
    {
      creer_session("panier", array(0 => array("idProduit" => $id, "quantite" => 1)));
      return true;
    }
    //et on retourne true quand l'article est ajouté
    return false;
  }

  //ajoute ou soustrait une valeur à une quantité d'un produit
  function changeQuantitePanier($produit, $changement)
  {
    $produitId = $produit["id"];
    $id = (int)$produitId;
    $array = lire_session("panier");
    $count = count($array);
    //pour chaque produit dans le panier
    for($i = 0; $i < $count; $i++)
    {
      //si le id du produits est trouvé dans le panier
      if($id == $array[$i]["idProduit"])
      {
        //si le changement est négatif
        if($changement < 0)
        {
          $array[$i]["quantite"] = $array[$i]["quantite"] + $changement;
          //si la quantite est plus petite que 0, on supprime l'index du panier
          if($array[$i]["quantite"] <= 0)
          {
            unset($array[$i]);
            $array = array_values($array);
            update_session("panier", $array);
            return true;
          }
        }
        //si le changement est positif
        elseif($changement > 0)
        {
          //si il en a déjà le maximun dans le panier comparé à la quantité en stock, on retourne false
          if($produit["quantite"] == 0 || $produit["quantite"] - $array[$i]["quantite"] <= 0)
          {
            return false;
          }
          //sinon, on applique le changement
          else
          {
            $array[$i]["quantite"] = $array[$i]["quantite"] + $changement;
          }
        }
      }
    }
    update_session("panier", $array);
    return true;
  }

  //supprime du panier le produit en paramètre
  function supprimeProduitPanier($produit)
  {
    $produitId = $produit["id"];
    $id = (int)$produitId;
    $array = lire_session("panier");
    $count = count($array);
    for($i = 0; $i < $count; $i++)
    {
      if($id == $array[$i]["idProduit"])
      {
        unset($array[$i]);
        $array = array_values($array);
        update_session("panier", $array);
        return true;
      }
    }
    return false;
  }

  //valide lors de la commande si les produits sont toujours en stock
  function validationPanier($db)
  {
    $array = lire_session("panier");
    $count = count($array);
    $articleManqueDeStock = array();
    for($i = 0; $i < $count; $i++)
    {
      $produit = obtenirProduit($db, $array[$i]["idProduit"]);
      if($produit["quantite"] == 0 || $produit["quantite"] - $array[$i]["quantite"] < 0)
      {
        array_push($articleManqueDeStock, $produit["id"]);
      }
    }
    return $articleManqueDeStock;
  }

 /*******************************************Fonction de commande*************************************/
  //Création d'une commande
  function creerCommande($db, $typePaiement, $idClient)
  {
    $datas = array(
    'date' => date("Y-m-d"),
    'statut' => "en cours",
    'type_paiement' => $typePaiement,
    'id_client' => $idClient
    );

    /* 2ème étape : préparer la requête */
    $sql =  "INSERT INTO commande (`date`, `statut`, `type_paiement`, `id_client`) VALUES (:date, :statut, :type_paiement, :id_client)";
    $qry = $db->prepare($sql);

    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
  }

  //obitent les infos de commandes selon le client
  function obtenirCommande($db, $idClient){
    $datas = array(
      'id_client' => $idClient
    );
  
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM commande WHERE `id_client`=:id_client"; //le SQL
    $qry = $db->prepare($sql);
  
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $commandes = $qry->fetchAll(); //le résultat dans un tableau event_s
  
    return $commandes;
  }

 /*******************************************Fonction de produit_commande*************************************/
  //permet de créer les commandes de produits
 function creerProduitCommande($db, $id_produit, $id_commande, $quantite)
  {
    $datas = array(
    'id_produit' => $id_produit,
    'id_commande' => $id_commande,
    'quantite' => $quantite
    );

    /* 2ème étape : préparer la requête */
    $sql =  "INSERT INTO produit_commande (`id_produit`, `id_commande`, `quantite`) VALUES (:id_produit, :id_commande, :quantite)";
    $qry = $db->prepare($sql);

    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
  }

  //obtient les commandes de produits selon le id de la commande
  function obtenirProduitCommande($db, $idCommande){
    $datas = array(
      'id_commande' => $idCommande
    );
  
    /* 2ème étape : préparer la requête */
    $sql = "SELECT * FROM produit_commande WHERE `id_commande`=:id_commande"; //le SQL
    $qry = $db->prepare($sql);
  
    /* 3ème étape: On exécute la requête */
    $qry->execute($datas);
    $produitCommande = $qry->fetchAll(); //le résultat dans un tableau event_s
  
    return $produitCommande;
  }

?>
