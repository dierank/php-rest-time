<?php

// Cabeçalhos obrigatórios
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/banco.php';
include_once '../objetos/usuario.php';

$banco = new Banco();
$bd = $banco->getConexao();

$usuario = new Usuario($bd);

// Buscar dados recebidos
$dados = json_decode(file_get_contents("php://input"));


// setar os dados do usuário
$usuario->setNome($dados->nome);
$usuario->setEmail($dados->email);
$usuario->setUsuario($dados->usuario);
$usuario->setSenha($dados->senha);
$usuario->setTelefone($dados->telefone);

// cria o usuário
if($usuario->criar()){
    echo '{';
        echo '"mensagem": "O usuário foi criado."';
    echo '}';
} else {
    echo '{';
        echo '"mensagem": "Não foi possível criar o usuário."';
    echo '}';
}
?>
