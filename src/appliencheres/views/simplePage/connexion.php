<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
endif;
unset($_SESSION['errors']);
?>

<h3>Connexion</h3>

<form id="form-inscription" method="POST" action="">
    <label>Pseudo</label>
    <input type="text" name="pseudo" required>
    <label>Mot de passe</label>
    <input type="password" name="mdp" required>
    <button class="button confirmation" id="btn-inscription">Se connecter</button>
</form>

<div id="txt-connexion">
    <h5>Vous n'avez pas de compte ? </h5>
    <p>
        <a class="button confirmation" href="<?= $slim->urlFor('/simplePage/inscription') ?>">
            Inscrivez-vous ici !
        </a>
    </p>
</div>