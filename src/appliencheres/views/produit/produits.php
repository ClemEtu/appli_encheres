<h5> Voici l'ensemble des produits de la catégorie <?=$libelle?>:</h5>
<ul>
    <?php foreach ($produits as $produit): ?>
        <li>
            <a href="<?= $slim->urlFor('/produits/recherche/:libelle/:idProduit', ['libelle' => $libelle,'idProduit' => $produit['idProduit']]) ?>"><?= $produit['nomProduit'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>