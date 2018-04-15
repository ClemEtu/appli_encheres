<?php
if (isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) : ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach;
endif;
unset($_SESSION['errors']);
?>
<h5>Mise en vente d'un nouveau produit:</h5><br>
<form id="form-vente" method="POST" action="">
    <label>Nom du produit:</label>
    <input type="text" name="nomProduit" required>
    <br>
    <label>Description:</label>
    <input type="text" name="description" required>
    <br>
    <label>Mots clés (séparez chaque mot clé par une virgule):</label>
    <input type="text" name="motsCles" required>
    <br>
    <label>Image du produit (url):</label>
    <input type="url" name="img" required>
    <br>
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
    <button class="button vente" id="btn-revente">Mettre en vente</button>
</form>