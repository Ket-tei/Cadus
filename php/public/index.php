<?php
if(!session_id())
  session_start();

$title = "Site sécurisé";
require_once './header.php';

?>

  <div class="container mt-5">
    <h2>Site sécurisé</h2>
    <div class="container">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="signin-tab" data-bs-toggle="tab" href="#signin" role="tab"
             aria-controls="signin" aria-selected="true">Authentification</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="signup-tab" data-bs-toggle="tab" href="#signup" role="tab" aria-controls="signup"
             aria-selected="false">Enregistrement</a>
        </li>
      </ul>


      <div class="tab-content mt-3">
        <!-- Contenu de l'onglet "Authentification" -->
        <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
          <h3>Authentification</h3>
          <form class="row g-3 needs-validation" action="signin.php" method="post">
            <div class="col-md-4 ">
              <label for="signin-email" class="form-label">email</label>
              <input type="text" name="email" class="form-control" id="signin-email"
                     placeholder="Votre adresse email..."
                     required>
            </div>
            <div class="col-md-4">
              <label for="signin-pwd" class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" id="signin-pwd"
                     placeholder="Votre mot de passe"
                     required>
            </div>
            <div class="row g-3">
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit">Se connecter</button>
              </div>
              <div class="col-md-4">
                <a class="text-primary" type="submit">Vous avez oublié votre mot de passe ?</a>
              </div>
            </div>
          </form>
        </div>
        <!-- Contenu de l'onglet "Enregistrement" -->
        <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
          <h3>Enregistrement</h3>
          <form class="row g-3 needs-validation" action="signup.php" method="post">
            <div class="row g-3">
            </div>
            <div class="row g-3">
              <div class="col-md-8">
                <label for="signup-email" class="form-label">Identifiant</label>
                <input type="email" name="email" class="form-control" id="signup-email"
                       placeholder="Votre adresse email..."
                       required>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-md-8">
                <label for="signup-pwd" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" id="signup-pwd"
                       placeholder="Votre mot de passe..."
                       required>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-md-8">
                <label for="signup-repwd" class="form-label">Saisir à nouveau</label>
                <input type="password" name="repassword" class="form-control" id="signup-repwd"
                       placeholder="Votre mot de passe..."
                       required>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-2">
                <button class="btn btn-outline-danger " type="reset">Annuler</button>
              </div>
              <div class="col-md-3">

                <button class="btn btn-primary " type="submit">S'inscrire</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php
require_once './footer.php';