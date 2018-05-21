<?php
class Cidade
{
	private $conexao;
	private $tabela_nome = "cidades";

	public $id;
	public $nome;

	public function __construct($bd)
	{
		$this->conexao = $bd;
	}

	function ler()
	{
		$query = "SELECT * FROM " . $this->tabela_nome;

		$stmt = $this->conexao->prepare($query);

		$stmt->execute();

		return $stmt;
	}
}
?>