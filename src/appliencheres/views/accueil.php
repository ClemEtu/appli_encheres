<h3>Bienvenue sur AppliEnchere !</h3>

<div class="texte texte-accueil">
    <?php if (isset($_SESSION['userConnected'])): ?>
        <p id="bonjour">Bonjour <?= $_SESSION['userConnected']->prenom ?> !</p>
    <?php else: ?>
        <a id="bonjour" class="button" href="<?= $slim->urlFor("/simplePage/inscription") ?>">
            Inscrivez-vous gratuitement !
        </a>
    <?php endif; ?>
</div>