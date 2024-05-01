<?php
  //Porte d'entrée de mon application
  //Bootstrap = démarrage de l'application web
  define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
  
  require DOCROOT."/includes/config.inc.php";
  require DOCROOT."/includes/debug.inc.php";
  require DOCROOT."/includes/functions.inc.php";
  
  session_start();
  $db = connecterDb();

  //Si le formulaire est bien envoyé
  if(isset($_POST["action"]) && ($_POST["action"]) == "connexion_client")
  {
    //Si le client est trouvé avec email, on créer une session avec ce dernier
    if(obtenirClient($db, $_POST["login"], $_POST["mot_passe"]) != null)
    {
      $infoClient = obtenirClient($db, $_POST["login"], $_POST["mot_passe"]);
      creer_session("estConnecte", $infoClient[0]['id']);

      //Si la case est coché, on crée un cookie
      if(isset($_POST["seSouvenir"]) && $_POST["seSouvenir"] == true)
      {
        create_cookie("login", $_POST["login"]);
      }
      //Sinon, si il existe, on le supprime
      elseif(!isset($_POST["seSouvenir"]))
      {
        delete_cookie("login");
      }
      redirect("accueil");
    }
    //Sinon, on le redirige à la page de connexion avec une erreur
    else
    {
      redirect("connexion?success=false");
    }
  }
  else
  {
    redirect();
  }