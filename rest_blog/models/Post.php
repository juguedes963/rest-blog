<?php

class Post{
	public $id;
	public $titulo;
	public $texto;
	public $id_categoria;
	public $autor;
	public $dt_criacao;


	private $conexao;

	public function __construct($con){
		$this->conexao = $con;
	}

	public function read($id=null){
		if(!isset($id)){
			$query = "SELECT * from post order by titulo";
			$stmt = $this->conexao->prepare($query);
		}else{
			$query = "SELECT * from post where id=:id";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam('id',$id);
		}
		$stmt->execute();
		$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function create(){
		$query = "INSERT INTO Post(titulo, texto, id_categoria, autor, dt_criacao) VALUES (:titulo, :texto, :id_categoria, :autor, :dt_criacao)";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindParam('titulo', $this->titulo);
		$stmt->bindParam('texto', $this->texto);
		$stmt->bindParam('id_categoria', $this->id_categoria);
		$stmt->bindParam('autor', $this->autor);
		$stmt->bindParam('dt_criacao', $this->dt_criacao);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function delete(){
		$query = "DELETE from post where id=:id";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindParam('id',$this->id);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function update(){
	    $query = "UPDATE Post set titulo = :titulo, texto = :texto, id_categoria = :id_categoria, autor = :autor, dt_criacao = :dt_criacao  WHERE id = :id ";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindParam('id',$this->id);
		$stmt->bindParam('titulo', $this->titulo);
		$stmt->bindParam('texto', $this->texto);
		$stmt->bindParam('id_categoria', $this->id_categoria);
		$stmt->bindParam('autor', $this->autor);
		$stmt->bindParam('dt_criacao', $this->dt_criacao);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
}














