<h5> Voici l'ensemble des catégories de produit que nous proposons:</h5>
<ul>
<?php foreach ($motsCles as $motCle): ?>
    <li><a href="<?= $slim->urlFor('/produits/recherche/:libelle', ['libelle' => $motCle]) ?>"><?= $motCle ?></a></li>
<?php endforeach; ?>
</ul>