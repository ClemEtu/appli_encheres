<?php if (isset($_SESSION['userConnected'])): ?>
    <h4>Bienvenue dans votre espace <?= $_SESSION['userConnected']->prenom ?></h4>
    <div class="manage-user">
        <h5>Gérer votre argent :</h5>
        <div class="manage-user-in">
            Votre solde actuel: <?= $_SESSION['userConnected']->solde ?> €<br>
            <a href="<?= $slim->urlFor("/user/rechargerCompte") ?>">Recharger mon compte</a><br>
            Votre argent réellement disponible: <?= $_SESSION['userConnected']->argentDispo ?> €
        </div>
    </div>
    <div class="manage-user-in">
        <h5>Vos enchères en cours :</h5>
        <?php foreach ($encheresPlusElevees as $e): ?>
        <div class="manage-user-in">
            <a href="<?= $slim->urlFor('/produits/:idProduit', ['idProduit' => ($produits[$e['idVente']])->idProduit]) ?>">
                <?= ($produits[$e['idVente']])->nomProduit ?>
            </a>
            <br>
            <span class="span-montant">Montant de votre enchère: <?= $e['montant'] ?>€</span>
            <br>
            <span>Vous
                <?php if ($e['idEnchere']==($ventes[$e['idVente']])->idEnchereMax): ;?>
                    avez l'enchère la plus élevée
                <?php else :?>
                    n'avez plus l'enchère la plus élevée, une personne a fait une enchère plus importante !
                <?php endif; ?>

            </span>
            <br>
            <span>Date de fin : <?= \appliencheres\models\Vente::where('idVente', $e->idVente)->first()->dateLimite ?></span>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <h5>
        Inscrivez-vous <a href="<?= $slim->urlFor("/simplePage/inscription") ?>">ici</a> pour accéder à cet espace !
    </h5>
<?php endif; ?>
