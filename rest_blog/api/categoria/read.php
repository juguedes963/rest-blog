<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//As classes usadas
include_once '../../config/Conexao.php';
include_once '../../models/Categoria.php';



//garante que só funcione com GET
if ($_SERVER['REQUEST_METHOD']=='GET'){

	//Instancia o objeto de conexao
	$db = new Conexao();
	//Recebe a conexao feita
	$conexao = $db->getConexao();


	//Instancia o objeto categoria
	//Passa a conexao
	$cat = new Categoria($conexao);

	//Invoca o método read
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = null;
	}

	$resultado = $cat->read($id);
	if (sizeof($resultado)>0){
		echo json_encode($resultado);
	}else{
		echo json_encode(['mensagem'=>'Nenhuma categoria encontrada']);
	}

}else{
	echo json_encode(['mensagem'=>'Método não suportado']);
}