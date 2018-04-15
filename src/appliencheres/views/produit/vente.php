<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
    unset($_SESSION['errors']);
    elseif (isset($_SESSION['messageConfirmation'])): ?>
        <p><?= $_SESSION['messageConfirmation'] ?></p>
        <?php unset($_SESSION['messageConfirmation']) ?>
<?php endif;?>

<h5><?= $produit['nomProduit'] ?>:</h5>
<div id="desc-vente">
    <img src="<?=$produit['image'] ?>" alt="<?=$produit['nomProduit'] ?>">
<p><?= $produit['description'] ?></p>
<p>Enchère actuelle : <?= $montantEnchere ?>€ </p>
<?php if (isset($_SESSION['userConnected'])) : ?>
    <form id="form-enchere" method="POST" action="">
        <label>Montant:</label>
        <input type="number" name="montant" required>
        <br>
        <label>Mot de passe:</label>
        <input type="password" name="mdp" required>
        <br><br>
        <button class="button encherir" id="btn-encherir">Encherir</button>
    </form>
<?php else: ?>
    <p>Vous devez être inscrit et vous connecter pour pouvoir enchérir !</p>
<?php endif; ?>
</div>
