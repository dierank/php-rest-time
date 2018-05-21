<?php


class Usuario
{
	private $conexao;
	private $nome_tabela = "usuarios";

	private $id;
	private $nome;
	private $email;
	private $usuario;
	private $senha;
	private $telefone;

	public function __construct($bd)
	{
		$this->conexao = $bd;
	}

	public function read()
	{
		$query = "SELECT * FROM " . $this->nome_tabela;
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	// Getters + Setters

	// ID
	public function getId()
	{
		return $this->id;
	}

	// Nome
	public function getNome()
	{
		return $this->nome;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	// Email
	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		$this->email = $email;
	}

	// Usuário
	public function getUsuario()
	{
		return $this->usuario;
	}
	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}

	// Senha
	public function getSenha()
	{
		return $this->senha;
	}
	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	// Telefone
	public function getTelefone()
	{
		return $this->telefone;
	}
	public function setTelefone($telefone)
	{
		$this->telefone = $telefone;
	}
}
?>