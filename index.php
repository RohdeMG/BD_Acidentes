	<?php
	require_once("header.php");
	require_once("conexao.php");
	?>
	<div class="col-md-12 col-xs-12">
		<div class="login">
			<h1>Sinistralidade Rodoviária PT</h1>
			<form action="validacao.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Usuário" id="username" required>
				<label for="palavrapasse">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="palavrapasse" placeholder="Senha" id="palavrapasse" required>
				<input type="submit" name="clicou" value="Login">
			</form>
		</div>
	</div>
		<div class="col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-md-4 col-sm-4 col-xs-12 text-right">
			<button type="button" class="btn btn-info btn-sm space" id="btnuser">Adicionar Utilizador</button>
			<form action="?" method="post" id="form8">
				<div class="form-group">
					<input type="text" class="form-control" name="nomeuser" placeholder="Usuário" required>
					<input type="text" class="form-control" name="nameuser" placeholder="Username" required>
					<input type="password" class="form-control" name="senhauser" placeholder="Senha" required>
					<input type="number" class="form-control" name="grupouser" id="grupouser"  placeholder="Grupo: 1 ou 2" required>
					<input type="submit" class="btn btn-outline-primary space" name="adduser" value="Adicionar">
				</div>
			</div>
		<div class="col-md-4 col-sm-4 col-xs-12"></div>


		<?php 
		if(isset($_POST["adduser"])){
			$adnome = '\''.$_POST["nomeuser"].'\'';
			$adusername = '\''.$_POST["nameuser"].'\'';
			$adsenha = '\''.$_POST["senhauser"].'\'';
			$adgrupo = '\''.$_POST["grupouser"].'\'';

			$queryuser = 'INSERT INTO utilizadores ("nome","username","palavrapasse","grupo") VALUES('.$adnome.','.$adusername.','.$adsenha.','.$adgrupo.')';
			$result = pg_query($queryuser);
			echo "<div class='alert alert-success col-md-3' role='alert'>Utilizador adicionado com sucesso!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'index.php';}, 3000);</script>";	
		}
		?>

	</body>
	</html>


	<script type="text/javascript">
		$(document).ready(function() {
			$("#btnuser").click(function() {
				$("#form8").toggle();
			});
			$("#grupouser").keyup(function() {
				$("#grupouser").val(this.value.match(/[1-2]*/));
			});
		});
	</script>