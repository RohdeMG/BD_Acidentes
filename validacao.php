<?php
require_once("conexao.php");


// Verifica se houve POST e se o usuário e senha estão preenchidos
if (isset($_POST["clicou"])){


	$username = $_POST["username"];
	$palavrapasse = $_POST["palavrapasse"];


// Validação do usuário/senha digitados
	$query = "SELECT *,utilizadores.nome AS utilinome,grupos.nome AS grupnome FROM utilizadores,grupos WHERE utilizadores.grupo = grupos.grupos_id AND utilizadores.username='".$username."' AND utilizadores.palavrapasse='".$palavrapasse."'";
	$result = pg_query($query);

	if(pg_num_rows($result) != null){
		 // Salva os dados encontrados na variável $resultado
		$resultado = pg_fetch_assoc($result);
	
		
 // Salva os dados encontrados na sessão
		$_SESSION["UsuarioID"] = $resultado["utilizadores_id"];
		$_SESSION["UsuarioNome"] = $resultado["utilinome"];
		$_SESSION["UsuarioGrupo"] = $resultado["grupo"];
		$_SESSION["Gruponome"] = $resultado["grupnome"];


		header("Location:trazdados.php");
	}else{
	
		header("Location:index.php");
	}

}
?>