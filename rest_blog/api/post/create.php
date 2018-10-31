<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if(!isset($_SERVER['PHP_AUTH_USER'])){
	header('WWW-Authenticate: Basic realm="Página restrita"');

	header('HTTP/1.0 401 Unauthorized');

	echo json_encode(["mensagem" => "Autenticação necessária"]);

	exit;
}elseif(!($_SERVER['PHP_AUTH_USER'] == 'admin' && $_SERVER['PHP_AUTH_PW'] == 'admin')){
	header('HTTP/1.0 401 Unauthorized');
	echo json_encode(["mensagem" => "Dados incorretos!"]);
}else{
	//echo json_encode(["mensagem" => "Bem vindo!"]);

//As classes usadas
include_once '../../config/Conexao.php';
include_once '../../models/Post.php';


if ($_SERVER['REQUEST_METHOD']=='POST'){

	//Instancia o objeto de conexao
	$db = new Conexao();
	//Recebe a conexao feita
	$conexao = $db->getConexao();


	//Instancia o objeto categoria
	//Passa a conexao
	$post = new Post($conexao);

	$dados = json_decode(file_get_contents('php://input'), true);

	$post->titulo = $dados['titulo'];
	$post->texto = $dados['texto'];
	$post->id_categoria = $dados['id_categoria'];
	$post->autor = $dados['autor'];
	$post->dt_criacao = $dados['dt_criacao'];


	if ($post->create()){
		echo json_encode(['mensagem'=>'Post criado com sucesso!']);
		http_response_code(201);
	}else{
		echo json_encode(['mensagem'=>'Não foi possível criar o post!']);
	}
}else{
	echo json_encode(['mensagem'=>'Método não suportado']);
}

}