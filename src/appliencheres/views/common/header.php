<!DOCTYPE html>
<html lang="fr">
<!-- header content -->
<head>
    <link rel="stylesheet" href="<?= $slim->request->getRootUri(); ?>/css/appliencheres.css">
    <link rel="stylesheet" href="<?= $slim->request->getRootUri(); ?>/css/bootstrap.min.css">
    <title>AppliEncheres</title>
</head>

<body>
    <header>
        <h1 id="header-title">AppliEncheres</h1>
        <h5 id="header-quote">vente aux enchères de vêtements et accessoires de luxe </h5>
        <nav id="header-nav">
            <a class="header-connection-inscription" href="<?= $slim->request->getRootUri(); ?>/simplePage/connexion">Se connecter</a>
            <a class="header-connection-inscription" href="<?= $slim->request->getRootUri(); ?>/simplePage/inscription">S'inscrire</a>
        </nav>
    </header>