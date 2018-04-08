<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
endif;
unset($_SESSION['errors']);
?>

<form id="form-inscription" method="POST" action="">
    <label>Pseudo</label>
    <input type="text" name="pseudo" required>
    <label>Mot de passe</label>
    <input type="password" name="mdp" required>
    <button class="button confirmation" id="btn-inscription">Se connecter</button>
</form>

<h3>Vous n'avez pas de compte ? </h3>

<p>
    <a class="button confirmation" href="<?= $slim->urlFor('/simplePage/inscription') ?>">
        S'inscrire
    </a>
</p>