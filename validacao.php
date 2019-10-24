<?php
require_once("conexao.php");


// Verifica se houve POST e se o usuário e senha estão preenchidos
if (isset($_POST['clicou']) && isset($_POST['username']) && isset($_POST['password'])){


	$username = $_POST['username'];
	$password = $_POST['password'];

// Validação do usuário/senha digitados
	$query = "SELECT * FROM utilizadores WHERE username='$username' AND password='$password' LIMIT 1";
	$result = pg_query($query);

	if(pg_num_rows($result) != 1){
		header('Location:index.php');
	}else{
	 // Salva os dados encontrados na variável $resultado
		$resultado = pg_fetch_assoc($result);

		
 // Salva os dados encontrados na sessão
		$_SESSION["UsuarioID"] = $resultado['utilizador_id'];
		$_SESSION["UsuarioNome"] = $resultado['nome'];
		$_SESSION["UsuarioPermissao"] = $resultado['permissao'];
		$_SESSION["UsuarioGrupo"] = $resultado['grupo'];

		header('Location:trazdados.php');

	}

}
?>