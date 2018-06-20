<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/banco.php';
include_once '../objetos/usuario.php';

$banco = new Banco();
$conexao = $banco->getConexao();

$usuario = new Usuario($conexao);

$stmt = $usuario->ler();
$count = $stmt->rowCount();

if ($count > 0)
{
	$usuario_vet = array();
	$usuario_vet['usuarios'] = array();

	while ($col = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($col);
		$usuario_item = array(
			"id"       => $id,
			"nome"     => $nome,
			"email"    => $email,
			"usuario"  => $usuario,
			"senha"    => $senha,
			"telefone" => $telefone
		);
		array_push($usuario_vet["usuarios"], $usuario_item);
	}
	echo json_encode($usuario_vet);
}
else
{
	echo json_encode(
		array("mensagem" => "Nenhum usuario encontrado.")
	);
}

?>
