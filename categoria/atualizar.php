<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/banco.php';
include_once '../objetos/categoria.php';


$banco = new Banco();
$bd = $banco->getConexao();


$categoria = new Categoria($bd);


$dados = json_decode(file_get_contents("php://input"));

$categoria->id = $dados->id;

$categoria->nome     = $dados->nome;

if($categoria->atualizar()){
    echo '{';
        echo '"mensagem": "A categoria foi atualizado."';
    echo '}';
}

else{
    echo '{';
        echo '"mensagem": "A categoria não pôde ser atualizado."';
    echo '}';
}


 ?>
