<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 15/04/2018
 * Time: 11:57
 */
?>
<h5>Vous souhaitez mettre en vente un nouveau produit?</h5>
<p>C'est <a href="<?= $slim->request->getRootUri(); ?>/miseEnVente">ici</a> !</p>
<h5>Voici vos ventes en cours :</h5>
<ul>
<?php foreach ($produitsEnCours as $pec) : ?>
    <li>
        <a href="<?= $slim->request->getRootUri(); ?>/produits/<?= $pec['idProduit']?>"><?=$pec['nomProduit'] ?></a>
        <br>
        <span>Enchère maximale :
            <?php if (isset($encheresPlusElevees[$pec['idProduit']])): ?>
                <?= ($encheresPlusElevees[$pec['idProduit']])->montant ?>
            <?php else : ?>
                ---
            <?php endif; ?>
        </span>
    </li>
<?php endforeach; ?>
</ul>

<h5>Voici vos ventes qui n'ont pas abouties :</h5>
<ul>
    <?php foreach ($produitsNonVendus as $pec) : ?>
    <li>
        <?=$pec['nomProduit'] ?><br>
        <a href="<?= $slim->request->getRootUri(); ?>/remiseEnVente/<?= $pec['idProduit']?>">Remettre en vente !</a>
    </li>
<?php endforeach; ?>
</ul>

<h5>Voici vos ventes qui se sont terminées avec succès :</h5>
<ul>
<?php foreach ($produitsVendus as $pec) : ?>
    <li>
        <span><?=$pec['nomProduit'] ?></span>
        <br>
        <span>montant final :
            <?php if (isset($encheresPlusElevees[$pec['idProduit']])): ?>
                <?= ($encheresPlusElevees[$pec['idProduit']])->montant ?>
            <?php else : ?>
                ---
            <?php endif; ?>
        </span>
    </li>
<?php endforeach; ?>
</ul>