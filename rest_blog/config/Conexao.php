<?php
/** 
Classe que contém os parametros para conexao e o metodo
* que retorna a conexao
*/


class Conexao{
	//credenciais de acesso ao BD
	private $host = 'localhost';
	private $dbname = 'test';
	private $user = 'root';
	private $passwd = '';
	//variavel para a conexao
	private $conexao;


	public function getConexao(){
		//estabelecer uma conexao e retornar a variavel com a conexao
		$this->conexao = null;

		try{
			$this->conexao = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->passwd);
		}catch(PDOException $e){
			echo "Erro na conexão :".$e->getMessage();
		}

		return $this->conexao;
	}
}

