<?php
//Porte d'entrée de mon application
  //Bootstrap = démarrage de l'application web
  define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
  
  require DOCROOT."/includes/config.inc.php";
  require DOCROOT."/includes/debug.inc.php";
  require DOCROOT."/includes/functions.inc.php";
  session_start();
  $db = connecterDb(); 

  //Si l'action est la bonne
  if(isset($_POST["action"]) && ($_POST["action"]) == "creer_client")
  {
    $array = obtenirClientLoginDisponible($db, $_POST['courriel'], $_POST['usager']);
    //si la validation serveur est bonne et qu'il n'y a aucun client avec le même usager et/ou courriel
    if(validationClientAvecLogin($_POST) && count($array) == 0)
    {
      creerClient($db, $_POST);
      $infoClient = obtenirClient($db, $_POST["courriel"], $_POST["mot_passe"]);
      //on guarde le id du client en session
      creer_session("estConnecte", $infoClient[0]['id']);
      redirect("accueil");
    }
    else
    {
      redirect("creerClient?success=false");
    }
  }
  else
  {
    redirect();
  }

  