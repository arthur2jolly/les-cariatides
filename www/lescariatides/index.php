<?php

require_once '../../vendor/autoload.php';
require_once 'classes/ProjectAutoload.php';

use www\lescariatides\classes\Metas;

\Slim\Slim::registerAutoloader();
Twig_Autoloader::register();
\www\lescariatides\classes\ProjectAutoload::registerAutoloader();



$app = new \Slim\Slim(array('debug' => true));

$app->get('/', function() use ($app)  {
     renderPage('index.html', $app);
})->name('accueil')->setParams(array('label' => "Accueil"));

$app->get('/visite-guidee', function() use ($app) {
    renderPage('visite-guidee.html', $app);
})->name('visite-guidee')->setParams(array('label' => "Visite guidée"));

$app->get('/decouvrir', function() use ($app) {
    renderPage('decouvrir.html', $app);
})->name('decouvrir')->setParams(array('label' => "À Découvrir"));

$app->get('/tarifs', function() use ($app) {
    renderPage('tarifs.html', $app);
})->name('tarifs')->setParams(array('label' => "Réservations - tarifs"));

$app->get('/liens', function() use ($app) {
    renderPage('liens.html', $app);
})->name('liens')->setParams(array('label' => "Liens Utiles"));

$app->get('/contact', function() use ($app) {
    renderPage('contact.html', $app);
})->name('contact')->setParams(array('label' => "Contact"));

$app->run();


function renderPage($page, $app) {
    $loader = new Twig_Loader_Filesystem('./templates');
    $twig = new Twig_Environment($loader, array());
    $metas = new Metas();

    echo $twig->render('pages/'.$page.'.twig', array(
            'metas' => $metas->getMetaAsHtml(),
            'current_page' => $app->router()->getCurrentRoute(),
            'routes' => $app->router()->getNamedRoutes(),
        )
    );
    die();
}
