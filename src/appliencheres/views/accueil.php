<div id="txt-accueil">
    <h3>Bienvenue sur AppliEnchere !</h3>
    <?php if (isset($_SESSION['userConnected'])): ?>
        <p id="bonjour-accueil">Bonjour <?= $_SESSION['userConnected']->prenom ?> !</p>
    <?php else: ?>
        <a id="bonjour-accueil" class="button" href="<?= $slim->urlFor("/simplePage/inscription") ?>">
            Inscrivez-vous gratuitement !
        </a>
    <?php endif; ?>
</div>