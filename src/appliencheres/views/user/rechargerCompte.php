<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
endif;
unset($_SESSION['errors']);
?>

<h5>Veuillez renseigner ces champs pour augmenter votre solde :</h5>
<form id="form-rechargerCompte" method="POST" action="">
    <label>Montant de la recharge:</label>
    <input type="number" name="montant" required>
    <br>
    <label>Mot de passe:</label>
    <input type="password" name="mdp" required>
    <br>

    <button class="button recharger" id="btn-recharger">Recharger mon compte</button>
</form>