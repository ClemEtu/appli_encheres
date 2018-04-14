<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
    elseif (isset($messageConfirmation)): ?>
        <p><?= $messageConfirmation ?></p>
<?php endif;
unset($_SESSION['errors']);
?>
<h5><?= $produit['nomProduit'] ?>:</h5>
<p><?= $produit['description'] ?></p>
<p>enchère actuelle : <?= $montantEnchere ?>€ </p>
<?php if (isset($_SESSION['userConnected'])) : ?>
    <form id="form-enchere" method="POST" action="">
        <label>Montant:</label>
        <input type="number" name="montant" required>
        <br>
        <label>Mot de passe:</label>
        <input type="password" name="mdp" required>
        <br>
        <button class="button encherir" id="btn-encherir">Encherir</button>
    </form>
<?php else: ?>
    <p>Vous devez être inscrit et vous connecter pour pouvoir enchérir !</p>
<?php endif; ?>
