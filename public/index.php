<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../config/banco.php';


$app = new \Slim\App;

// Rotas usuários
require_once '../src/routes/usuario.php';
require_once '../src/routes/categoria.php';
require_once '../src/routes/atividade.php';
require_once '../src/routes/evento.php';



$app->run();
