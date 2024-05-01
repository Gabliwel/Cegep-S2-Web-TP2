<?php
  session_start();
  $db = connecterDb();
?>

<!doctype html>
<html class="no-js" lang="">

<?php require DOCROOT.'/includes/head.inc.php'; ?>

<body style="background-image: url('/img/fond3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">

  <?php require DOCROOT.'/includes/header.inc.php';?>
  <!-- Formulaire de création de client -->
  <main class="container text-light">
  <h1>Créer votre compte</h1>
    <form id="rendered-form" method="post" action="/actions/creer_client.php" class="needs-validation" novalidate oninput='mot_passe_confirmation.setCustomValidity(mot_passe.value != mot_passe_confirmation.value ? "Les mots de passes doivent être identiques" : "")'>
      <div class="row">
        <div class="col-12 col-md-4">
          <label for="txtPrenom" class="form-label"><span class="text-danger">*</span>Prénom:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre prénom" id="prenom" name="prenom" maxlength="150" required>
          <div class="invalid-feedback">
            Le prénom est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="txtNom" class="form-label"><span class="text-danger">*</span>Nom:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre nom" id="nom" name="nom" maxlength="200" required>
          <div class="invalid-feedback">
            Le nom est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="txtCourriel" class="form-label"><span class="text-danger">*</span>Courriel:</label>
          <input type="email" class="form-control" placeholder="Entrez votre courriel" id="courriel" name="courriel" maxlength="200" required>
          <div class="invalid-feedback">
            Le courriel est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="txtMot_passe" class="form-label"><span class="text-danger">*</span>Mot de passe:</label>
          <input type="password" class="form-control" placeholder="Entrez votre courriel" id="mot_passe" name="mot_passe" maxlength="255" required>
          <div class="invalid-feedback">
            Le mot de passe est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="txtMot_passe_confirmation" class="form-label"><span class="text-danger">*</span>Validation du mot de passe:</label>
          <input type="password" class="form-control" placeholder="Confirmez votre mot de passe" id="mot_passe_confirmation" name="mot_passe_confirmation" maxlength="255" required>
          <div class="invalid-feedback">
            La confirmation de mot de passe est obligatoire et doit être identique au précédent.
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="txtUsager" class="form-label"><span class="text-danger">*</span>Usager:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre numéro d'usager" id="usager" name="usager" maxlength="50" required>
          <div class="invalid-feedback">
            L'usager est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-6">
          <label for="txtAdresse" class="form-label"><span class="text-danger">*</span>Adresse:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre adresse" id="adresse" name="adresse" required>
          <div class="invalid-feedback">
            L'adresse est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-6">
          <label for="txtCode_postal" class="form-label"><span class="text-danger">*</span>Code postal:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre courriel" id="code_postal" name="code_postal" pattern="[A-Za-z][0-9][A-Za-z][0-9][A-Za-z][0-9]" minlength="6" maxlength="6" required>
          <div id="code_postalHelp" class="form-text">Le code postal doit sous la forme: A1A1A1.</div>
          <div class="invalid-feedback">
            Le code postal est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-6">
          <label for="txtVille" class="form-label"><span class="text-danger">*</span>Ville:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre ville" id="ville" name="ville" maxlength="150" required>
          <div class="invalid-feedback">
            La ville est obligatoire.
          </div>
        </div>
        <div class="col-12 col-md-6">
          <label for="txtProvince" class="form-label"><span class="text-danger">*</span>Province:</label>
          <input type="txt" class="form-control" placeholder="Entrez votre province" id="province" name="province" maxlength="100" required>
          <div class="invalid-feedback">
            La province est obligatoire.
          </div>
        </div>
      </div>
      <br>

      <button class="btn btn-primary" type="submit" name="action" id="action" value="creer_client">Créer le compte</button>
    </form>
      <!-- Si l'utilisateur à entrer des informations invalides, on affiche un message -->
      <?php
        if(isset($_GET['success']) && $_GET['success'] == "false")
        {
          echo "<p class='text-danger'>Une erreur est survenu! Nous vous recommendons <a href='https://support.google.com/adsense/answer/12654?hl=fr' class='link-danger'>d'activer le Javascript</a> dans votre navigateur si ce n'est pas fait. Sinon, essayez avec un différent email ou numéro usager!</p>";
        }
      ?>  
  </main>

  <?php require DOCROOT.'/includes/footer.inc.php';?>
  <?php require DOCROOT.'/includes/javascript.inc.php';?>
</body>

</html>
