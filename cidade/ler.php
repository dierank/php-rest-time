<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/banco.php';
include_once '../objetos/cidade.php';

$banco = new Banco();
$conexao = $banco->getConexao();

$cidade = new Cidade($conexao);

$stmt = $cidade->read();
$count = $stmt->rowCount();


if ($count > 0)
{
	$cidade_vet = array();
	$cidade_vet["cidades"] = array();

	while ($col = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($col);
		$cidade_item = array(
			"id" => $id_cidade,
			"nome" => $nome_cidade
		);
		array_push($cidade_vet["cidades"], $cidade_item);
	}
	echo json_encode($cidade_vet);
}
else 
{
	echo json_encode(
		array("mensagem" => "Nenhuma cidade encontrada.")
	);
}

?>