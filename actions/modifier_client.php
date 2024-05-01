<?php
  //Porte d'entrée de mon application
  //Bootstrap = démarrage de l'application web
  define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

  require DOCROOT."/includes/config.inc.php";
  require DOCROOT."/includes/debug.inc.php";
  require DOCROOT."/includes/functions.inc.php";

  session_start();
  $db = connecterDb();
  $idClient = lire_session("estConnecte");
  $ancienneInfoClient = obtenirClientEnSession($db, $idClient);

  if(isset($_POST["action"]) && ($_POST["action"]) == "modifier_client")
  {
    //Si l'ancien mot de passe pour enregistrer les nouvelles données est bon
    if($ancienneInfoClient["mot_passe"] == $_POST["ancienMdp"])
    {
      //Si la validation serveur passe
      if(validationClientSansLogin($_POST, $db))
      {
        modifierClient($db, $_POST, $idClient);
        redirect("connexion?success=modification_enregistre");
      }
      else
      {
        redirect("modifierClient?success=false");
      }  
    } 
    //puisque c'est une erreur assez récurante, on affiche un message
    else
    {
      redirect("modifierClient?success=mauvais_mot_de_passe");
    }
  }
  else
  {
    redirect();
  }
  