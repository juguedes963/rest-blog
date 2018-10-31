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


//garante que só funcione com PUT
if ($_SERVER['REQUEST_METHOD']=='PUT'){

	$dados = json_decode(file_get_contents('php://input'), true);

//Instancia o objeto de conexao
$db = new Conexao();
//Recebe a conexao feita
$conexao = $db->getConexao();


//Instancia o objeto categoria
//Passa a conexao
$cat = new Categoria($conexao);

$cat->id = $dados['id'];
$cat->nome = $dados['nome'];
$cat->descricao = $dados['descricao'];

//INVOCA O MÉTODO UPDATE
if ($cat->update()){
		$dados = ['mensagem'=>'Categoria alterada com sucesso!'];
		//http_response_code(201);
	}else{
		$dados = ['mensagem'=>'Não foi possível alterar a categoria!'];
	}
	//APRESENTA OS DADOS EM JSON
	echo json_encode($dados);

}else{
	echo json_encode(['mensagem'=>'Método não suportado']);
}

}