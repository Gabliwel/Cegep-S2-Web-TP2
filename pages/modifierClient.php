<?php
  session_start();
  $db = connecterDb();
  if(!lire_session("estConnecte"))
  {
    redirect();
  }
  $estConnecte = lire_session("estConnecte");
  $client = obtenirClientEnSession($db, $estConnecte);
?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body class="text-light" style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">

  <?php require DOCROOT.'/includes/header.inc.php';?>
  <!-- Add your site or application content here  -->
  <main class="container">
    <h1>Modifier mon compte</h1>

    <form id="rendered-form" method="post" action="/actions/modifier_client.php" class="needs-validation" novalidate 
    oninput='mot_passe_confirmation.setCustomValidity(mot_passe.value != mot_passe_confirmation.value ? "Les mots de passes doivent être identiques" : "")'>
      <div class="rendered-form">
        <label for="txtPrenom" class="form-label"><span class="text-danger">*</span>Prénom:</label>
        <input type="txt" class="form-control" placeholder="Entrez votre prénom" id="prenom" name="prenom" value="<?php if(isset($client['prenom'])){ echo $client['prenom'];};?>"  maxlength="150"  required>
        <div class="invalid-feedback">
          Le prénom est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtNom" class="form-label"><span class="text-danger">*</span>Nom:</label>
        <input type="txt" class="form-control" placeholder="Entrez votre nom" id="nom" name="nom" value="<?php if(isset($client['nom'])){ echo $client['nom'];};?>"  maxlength="200" required>
        <div class="invalid-feedback">
          Le nom est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtMot_passe" class="form-label"><span class="text-danger">*</span>Mot de passe:</label> 
        <input type="password" class="form-control" placeholder="Entrez votre mot de passe" id="mot_passe" name="mot_passe" value="<?php if(isset($client['mot_passe'])){ echo $client['mot_passe'];};?>"  maxlength="255" required>
        <div class="invalid-feedback">
          Le mot de passe est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtMot_passe_confirmation" class="form-label"><span class="text-danger">*</span>Validation du mot de passe:</label>
        <input type="password" class="form-control" placeholder="Confirmez votre mot de passe" id="mot_passe_confirmation" name="mot_passe_confirmation"  maxlength="255" required>
        <div class="invalid-feedback">
          La confirmation de mot de passe est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtAdresse" class="form-label"><span class="text-danger">*</span>Adresse:</label>
        <input type="txt" class="form-control" placeholder="Entrez votre adresse" id="adresse" name="adresse" value="<?php if(isset($client['adresse'])){ echo $client['adresse'];};?>" required>
        <div class="invalid-feedback">
          L'adresse est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtCode_postal" class="form-label"><span class="text-danger">*</span>Code postal:</label>
        <input type="txt" class="form-control" placeholder="Entrez votre courriel" id="code_postal" name="code_postal" value="<?php if(isset($client['code_postal'])){ echo $client['code_postal'];};?>"  maxlength="6" pattern="[A-Za-z][0-9][A-Za-z][0-9][A-Za-z][0-9]" required>
        <div id="code_postalHelp" class="form-text">Le code postal doit sous la forme: A1A1A1.</div>
        <div class="invalid-feedback">
          Le code postal est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtVille" class="form-label"><span class="text-danger">*</span>Ville:</label>
        <input type="txt" class="form-control" placeholder="Entrez votre ville" id="ville" name="ville" value="<?php if(isset($client['ville'])){ echo $client['ville'];};?>"  maxlength="150" required>
        <div class="invalid-feedback">
          La ville est obligatoire.
        </div>
      </div>
      <div>
        <label for="txtProvince" class="form-label"><span class="text-danger">*</span>Province:</label>
        <input type="txt" class="form-control" placeholder="Entrez votre province" id="province" name="province" value="<?php if(isset($client['province'])){ echo $client['province'];};?>"  maxlength="100" required>
        <div class="invalid-feedback">
          La province est obligatoire.
        </div>
      </div>
      <br>
      <div>
        <label for="ancienMdp" class="form-label"><span class="text-danger">*</span>Pour enregistrer les modifications, veuiller entrer votre ancien mots de passe:</label>
        <input type="password" class="form-control" placeholder="Entrez votre ancien mot de passe" id="ancienMdp" name="ancienMdp" maxlength="255" required>
        <div class="invalid-feedback">
          L'ancien mot de passe est obligatoire.
        </div>
      </div>
      <br>
      <button class="btn btn-primary" type="submit" name="action" id="action" value="modifier_client">Mettre à jour les informations.</button>
    </form>
    <!-- Si l'utilisateur à entrer des informations invalides -->
    <?php
        if(isset($_GET['success']) && $_GET['success'] == "false")
        {
          echo "<p class='text-danger'>Une erreur est survenu! Si ce n'est pas encore fait, nous vous recommendons <a href='https://support.google.com/adsense/answer/12654?hl=fr' class='link-danger'>d'activer le Javascript</a> dans votre navigateur et d'essayer avec un différent email ou différent numéro usager!</p>";
        }
        elseif(isset($_GET['success']) && $_GET['success'] == "mauvais_mot_de_passe")
        {
          echo "<p class='text-danger'>Une erreur est survenu! Vous avez mal inséré votre ancien mot de passe.</p> ";
        }
      ?> 

  </main>

  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
