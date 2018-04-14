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
        <div id="head-appli">
            <h1 id="header-title">AppliEncheres</h1>
            <h5 id="header-quote">"vente aux enchères de vêtements et accessoires de luxe !"</h5>
            <div id="header-con-inscr">
            <?php if (isset($_SESSION['userConnected'])): ?>
                <a class="header-deconnexion" href="<?= $slim->request->getRootUri(); ?>/simplePage/deconnexion">Se déconnecter</a>
            <?php else: ?>
                <a class="header-connection-inscription" href="<?= $slim->request->getRootUri(); ?>/simplePage/inscription">S'inscrire</a>
                |
                <a class="header-connection-inscription" href="<?= $slim->request->getRootUri(); ?>/simplePage/connexion">Se connecter</a>
            <?php endif; ?>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= $slim->request->getRootUri(); ?>/">AppliEncheres</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= $slim->request->getRootUri(); ?>/">Accueil<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $slim->request->getRootUri(); ?>/produits/recherche">Nos produits</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['userConnected'])): ?>
                            <a class="nav-link" href="<?= $slim->request->getRootUri(); ?>/user/info">Mon compte</a>
                        <?php else: ?>
                            <a class="nav-link disabled" href="#">Mon compte</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<div id="global">