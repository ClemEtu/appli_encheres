<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
endif;
unset($_SESSION['errors']);
?>
<h5>Remise en vente du produit <?= $produit['nomProduit'] ?>:</h5><br>
<form id="form-revente" method="POST" action="">
    <label>Prix de départ:</label>
    <input type="number" name="prixDepart" required>
    <br>
    <label>Prix limite:</label>
    <input type="number" name="prixFixe" required>
    <br>
    <label>Date de fin:</label>
    <input type="date" name="dateFin" required>
    <br>
    <label>Mot de passe:</label>
    <input type="password" name="mdp" required>
    <br><br>
    <button class="button revente" id="btn-revente">Remettre en vente</button>
</form>