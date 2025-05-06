<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

echo $twig->render ('login.twig',[
    'css_path' => '../css/style.css',
    'imagem_path' => '../assets/login.png'
]);