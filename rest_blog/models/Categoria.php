<?php

class Categoria{
	public $id;
	public $nome;
	public $descricao;

	private $conexao;

	/* Ao instanciar um objeto, passaremos a conexao.
	 * A conexao sera armazenada em $this->conexao
	 * Para uso aqui na Classe
	*/
	public function __construct($con){
		$this->conexao = $con;
	}

	/* O método read() deverá efetuar uma consulta SQL
	 * na tabela categoria, e retornar o resultado
	 * Caso seja enviado um id, asume null e consulta normal
	 * Caso seja enviado, faz a consulta com where
	 */
	public function read($id=null){
		if(!isset($id)){
			$query = "SELECT * from categoria order by nome";
			$stmt = $this->conexao->prepare($query);
		}else{
			$query = "SELECT * from categoria where id=:id";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam('id',$id);
		}
		$stmt->execute();
		$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function create(){
		$query = "INSERT INTO Categoria(nome, descricao) VALUES (:nome, :descricao)";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindParam('nome', $this->nome);
		$stmt->bindParam('descricao', $this->descricao);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function delete(){
		$query = "DELETE from categoria where id=:id";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindParam('id',$this->id);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function update(){
		$query = "UPDATE Categoria set nome = :nome, descricao = :descricao WHERE id = :id ";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindParam('id',$this->id);
		$stmt->bindParam('nome', $this->nome);
		$stmt->bindParam('descricao', $this->descricao);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}


}