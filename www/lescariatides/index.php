<?php

require_once '../../vendor/autoload.php';
\Slim\Slim::registerAutoloader();
Twig_Autoloader::register();


$app = new \Slim\Slim();


$app->get('/', function ($name) {
    $page = "index.html";
});

$tpl_path = 'templates';

$loader = new Twig_Loader_Filesystem($tpl_path);
$twig = new Twig_Environment($loader, array(
    //'cache' => '../../compilation_cache',
));

$page = ltrim($_SERVER['REQUEST_URI'], '/');
$page = $page ? $page : 'index.html';

if(!file_exists($tpl_path.'/pages/'.$page.'.twig')) {
  $page = 'index.html';
}

$metas_definition = array(
    array('name' => "robots", 'content' => "index,follow"),
    array('content' => "MetaExtensions", 'name' => "collection"),
    array('name' => "subject", 'content' => "residence LES CARIATIDES des maisons de plain-pied entierement meublees et equipees hebergement la cotiniere  ile d'oleron plage tennis piscine ile d'oleron"),
    array('content' => "residence LES CARIATIDES des maisons de plain-pied entierement meublees et equipees hebergement la cotiniere  ile d'oleron plage tennis piscine ile d'oleron", 'name' => "Description"),
    array('content' => "residence ile d'oleron, hebergement oleron, residence charente maritime, location ile d'oleron, residence poitou charentes, location charente maritime, residence cote atlantique, location poitou charentes, residence france, residence LES CARIATIDES, location cote atlantique, residence pays d'arvert, residence ferme equestre, location france, residence cote atlantique, residence pays royannais, residence bord de mer, residence francais, piscine, hebergement, locatif, emplacement, tente, caravane, residence car, sejour, vacances, tourisme, la rochelle, fort boyard, plage, pays royannais", 'name' => "keywords"),
    array('name' => "FSLanguage", 'content' => "FR"),
    array('http-equiv' => "Expires", 'content' => "604800"),
    array('http-equiv' => "Cache-Control", 'content' => "max-age=604800, must-revalidate"),
    array('http-equiv' => "imagetoolbar", 'content' => "no"),
    array('http-equiv' => "x-dns-prefetch-control", 'content' => "off"),
    array('name' => "copyright", 'content' => "© Résidence Les Cariatides"),
    array('content' => "Lieu de vacances", 'name' => "Classification"),
    array('content' => "Document", 'name' => "Category"),
    array('content' => "Document", 'name' => "Page-topic"),
    array('content' => "France, FRANCE", 'name' => "Geography"),
    array('content' => "general", 'name' => "Rating"),
    array('content' => "global", 'name' => "Distribution"),
    array('content' => "never", 'name' => "Expires"),
    array('name' => "author", 'content' => "Arthur Jolly"),
    array('name' => "coverage", 'content' => "Worldwide"),
    array('name' => "distribution", 'content' => "Global"),
    array('name' => "rating", 'content' => "General"),
    array('name' => "HandheldFriendly", 'content' => "True"),
    array('name' => "MobileOptimized", 'content' => "320"),
    array('name' => "date", 'content' => "Fev. 27, 2015"),
    array('name' => "search_date", 'content' => date("Y-m-d")),
    array('name' => "medium", 'content' => "blog"),
    array('content' => "14 days", 'name' => "Revisit-After"),
    array('content' => date("dmY"), 'name' => "date-revision-ddmmyyyy"),
    array('content' => "General", 'name' => "Audience"),
    array('content' => "chateaumesnil@gmail.com", 'name' => "reply-To"),
    array('content' => "all", 'name' => "audience"),
    array('content' => "chateaumesnil@gmail.com", 'name' => "dc.Reply-To"),
    array('name' => "google-site-verification", "content" => "w_DXYPPsFSJJE7fC5NKXLMlNuELqxM9SC1rvLxU9fLc"
);

$metas = "";

foreach ($metas_definition as $meta) {

  $metas .= "<meta ";
  foreach ($meta as $key => $value) {
    $metas .= ''.$key.'="'.$value.'" ';
  }
  $metas .= ">\n";
}



echo $twig->render('pages/'.$page.'.twig', array('thumbs' => $thumbs, 'metas' => $metas, 'current_page' => rtrim($page, '.html')));
