<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
endif;
unset($_SESSION['errors']);
?>

<h3>Inscription</h3>

<form id="form-inscription" method="POST" action="">
    <label>Pseudo</label>
    <input type="text" name="pseudo" required>
    <label>Mot de passe</label>
    <input type="password" name="mdp1" required>
    <label>Confirmation du mot de passe</label>
    <input type="password" name="mdp2" required>
    <label>Nom</label>
    <input type="text" name="nom" required>
    <label>Prénom</label>
    <input type="text" name="prenom" required>
    <label>Adresse mail</label>
    <input type="email" name="mail" required>
    <label>Adresse postale</label>
    <input type="text" name="adresse" required>
    <button class="button confirmation" id="btn-inscription">S'inscrire</button>
</form>