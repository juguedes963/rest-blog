<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//As classes usadas
include_once '../../config/Conexao.php';
include_once '../../models/Post.php';



//garante que só funcione com GET
if ($_SERVER['REQUEST_METHOD']=='GET'){

	//Instancia o objeto de conexao
	$db = new Conexao();
	//Recebe a conexao feita
	$conexao = $db->getConexao();


	//Instancia o objeto categoria
	//Passa a conexao
	$post = new Post($conexao);

	//Invoca o método read
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = null;
	}

	$resultado = $post->read($id);
	if (sizeof($resultado)>0){
		echo json_encode($resultado);
	}else{
		echo json_encode(['mensagem'=>'Nenhum post encontrado']);
	}

}else{
	echo json_encode(['mensagem'=>'Método não suportado']);
}