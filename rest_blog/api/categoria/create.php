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
//As classes usadas
include_once '../../config/Conexao.php';
include_once '../../models/Categoria.php';


//garante que só funcione com POST
if ($_SERVER['REQUEST_METHOD']=='POST'){

	//Instancia o objeto de conexao
	$db = new Conexao();
	//Recebe a conexao feita
	$conexao = $db->getConexao();


	//Instancia o objeto categoria
	//Passa a conexao
	$cat = new Categoria($conexao);

	$dados = json_decode(file_get_contents('php://input'), true);

	$cat->nome = $dados['nome'];
	$cat->descricao = $dados['descricao'];


	if ($cat->create()){
		echo json_encode(['mensagem'=>'Categoria criada com sucesso!']);
		http_response_code(201);
	}else{
		echo json_encode(['mensagem'=>'Não foi possível criar a categoria!']);
	}

}else{
	echo json_encode(['mensagem'=>'Método não suportado']);
}

}