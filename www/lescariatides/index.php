<?php

require_once '../../vendor/autoload.php';
require_once 'classes/ProjectAutoload.php';


use www\lescariatides\classes\Metas;
use Gregwar\Image\Image;

\Slim\Slim::registerAutoloader();
Twig_Autoloader::register();
\www\lescariatides\classes\ProjectAutoload::registerAutoloader();


$app = new \Slim\Slim(array('debug' => true));

$app->get('/', function() use ($app)  {
     renderPage('index.html', $app);
})->name('accueil')->setParams(array('label' => "Accueil"));

$app->get('/visite-guidee', function() use ($app) {
    renderPage('visite-guidee.html', $app);
})->name('visiteguidee')->setParams(array('label' => "Visite guidée"));

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


function htmlImage($filename, $type)
{
    $path = 'uploads/home/'.$filename;
    if(file_exists($path)) {
        $img = Image::open($path)->setCacheDir('uploads/cache');

        switch($type){
            case 'home':
                $img->resize(684, 324);
                break;
            case 'inside':
                $img->resize(684, 324)->crop(0, 0, 684, 174);
                break;
            case 'thumbs':
                $img->resize(50, 50)->crop(0, 0, 50, 50);
                break;
        }

        return $img->html("", 'jpg', 100);
    }

    return false;
}

function diaporama($context, $type)
{
    $currentPage = $context['current_page'];
    $images = json_decode(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'diaporama.json'));

    $key = $currentPage->getName();
    $selectedImages = $images->$key ? $images->$key : $images->default;
    $output = array();

    foreach($selectedImages as $filename) {
        if($html = htmlImage($filename, $type)) {
            array_push($output, $html);
        }
    }

    return implode(' ', $output);
}

function renderPage($page, $app) {
    $loader = new Twig_Loader_Filesystem('./templates');
    $twig = new Twig_Environment($loader, array());

    $filter = new Twig_SimpleFilter('diaporama', 'diaporama', array('needs_context' => true));

    $twig->addFilter($filter);
    $metas = new Metas();

    echo $twig->render('pages/'.$page.'.twig', array(
            'metas' => $metas->getMetaAsHtml(),
            'current_page' => $app->router()->getCurrentRoute(),
            'routes' => $app->router()->getNamedRoutes(),
        )
    );
    die();
}
