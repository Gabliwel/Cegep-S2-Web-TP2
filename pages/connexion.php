<?php
  session_start();
  $db = connecterDb();

  //Si on se deconnecte, on détruit cet élément de session
  if(isset($_GET['action']) && $_GET['action'] == "deconnecter")
  {
    delete_session("estConnecte");
  }

  $estConnecte = lire_session("estConnecte");
  //Si on est connecte, on obtient ses infos
  if($estConnecte != false)
  {
    $client = obtenirClientEnSession($db, $estConnecte);
  }
  //cookie de login
	$login = read_cookie("login");

?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body class="text-light" style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
  <?php require DOCROOT.'/includes/header.inc.php';?>

  <main class="container">
  
    <!--Si l'utilisateur n'est pas connecté -->
    <!--Formulaire de connexion-->
    <?php if(!$estConnecte):?>
      <h1>Se connecter</h1>
      <form id="rendered-form" method="POST" action="/actions/connexion_client.php" class="needs-validation" novalidate>
        <div>
          <label for="txtLogin" class="form-label">Courriel ou usager:</label>
          <!--Si on a un cookie du login, on l'affiche -->
          <input type="txt" class="form-control" placeholder="Entrez votre courriel ou votre usager" id="login" name="login" required value="<?php echo (!$login)?"":$login; ?>">
          <div class="invalid-feedback">
            Veuiller remplir ce champ
          </div>
        </div>
        <div>
          <label for="txtMotPasse" class="form-label">Mot de passe:</label>
          <input type="password" class="form-control" placeholder="Entrez votre mot de passe" id="mot_passe" name="mot_passe" required>
          <div class="invalid-feedback">
          Veuiller remplir ce champ
          </div>
        </div>
        <div>
          <label for="chk_rememberusername">Se souvenir de moi?</label>
          <input type="checkbox" name="seSouvenir" id="seSouvenir" value="true" <?php echo (!$login)?"":"checked"; ?>>
        </div>
        <br>
        <button class="btn btn-primary" type="submit" id="action" name="action" value="connexion_client">Connexion</button>
      </form>
      <br>
      <p>Pas de compte? <a href="creerClient">Inscrivez vous!</a></p>
      <!-- Si l'utilisateur à entrer des informations invalides -->
      <?php
        if(isset($_GET['success']) && $_GET['success'] == "false")
        {
          echo "<p class='text-danger'>Une erreur est survenue, vos informations sont invalides!</p>";

        }
      ?>  
    <!-- Si l'utilisateur est déjà connecté --> 
    <?php else:?>
      <h1>Bonjour <?php echo $client['prenom'];?>!</h1> 
      <a href="connexion?action=deconnecter">Se déconnecter</a>
      <br>
      <a href="commande">Voir les factures de vos commandes</a>
      <br>
      <a href="modifierClient">Modifier vos informations</a>
      <br>
      <h3>Vos informations:</h3>
      <?php 
        //Si on revient ici suite à une modification des infos, on affiche un message
        if(isset($_GET['success']) && $_GET['success'] == "modification_enregistre")
        {
          echo "<p>Vos modifications ont été sauvegardées avec succès!</p>";
        } 
      ?>
      <!--Affichage des informations du client -->
      <ul>
        <li>Prénom: <?php echo $client['prenom']; ?></li>
        <li>Nom: <?php echo $client['nom']; ?></li>
        <li>Courriel: <?php echo $client['courriel']; ?></li>
        <li>Usager: <?php echo $client['usager']; ?></li>
        <li>Adresse: <?php echo $client['adresse']; ?></li>
        <li>Code postal: <?php echo $client['code_postal']; ?></li>
        <li>Ville: <?php echo $client['ville']; ?></li>
        <li>Province: <?php echo $client['province']; ?></li>
      </ul>
    <?php endif;?>

  </main>

  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>