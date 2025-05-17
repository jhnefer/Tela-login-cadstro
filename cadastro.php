<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Pegando os dados da URL (simulando validações)
$erro = $_GET['erro'] ?? null;
$sucesso = $_GET['sucesso'] ?? null;

// Renderiza o template com os dados
echo $twig->render('cadastro.twig', [
    'erro' => $erro,
    'sucesso' => $sucesso
]);
 