<?php
class Banco
{
	private $host     = "localhost";
	private $bd_nome  = "gtempo";
	private $usuario  = "root";
	private $senha    = "";
	public $conexao;

	public function getConexao()
	{
		$this->conexao = null;
		try
		{
			$this->conexao = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->bd_nome, $this->usuario, $this->senha);
			$this->conexao->exec("set names utf8");
		}
		catch(PDOException $ex)
		{
			echo "Erro de conexão: " . $ex->getMessage();
		}
		return $this->conexao;
	}
}
?>