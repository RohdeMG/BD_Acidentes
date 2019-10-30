		<?php 
		require_once("header.php");
		require_once("conexao.php");

		$mortos = "";
		$id = "";
		$feridosgraves = "";
		$feridosleves = "";
		$datahora = "";
		$vias = "";
		$km = "";
		$descricao = "";
		$gps = "";


		if(isset($_GET["del"])){
			$id = $_GET["del"];


			$query = 'SELECT *,tipoacidente.nome AS natureza,concelhos.nome AS nomeconcelho 
			FROM acidentes,concelhos,tipoacidente 
			WHERE acidentes.concelho = concelhos.concelhos_id 
			AND acidentes.tipoacidente = tipoacidente.tipoacidente_id AND acidentes_id = '.$id.'';
			$result = pg_query($query);
			$row = pg_fetch_array($result);


			$id = $row['acidentes_id'];
			$concelho = $row['concelhos_id'];
			$datahora = $row['datahora'];
			$mortos = $row['mortos'];
			$feridosgraves = $row['feridosgraves'];
			$vias = $row['vias'];
			$km = $row['km'];
			$tipoacidente = $row['natureza'];
			$descricao = $row['descricao'];
			$feridosleves = $row['feridosleves'];
			$gps = $row['gps'];

		}

		?>

		<div class="col-md-12 col-sm-12 col-xs-12 barratopo">
			<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3>Olá, <?php echo $_SESSION["UsuarioNome"];?></h3></div>
			<div class="col-md-6 col-sm-8 col-xs-12 text-right">		
				<a class="btn btn-primary space" href="logout.php">Sair</a>
			</div>
		</div>
		<div class="container">
			<h3>Deletar ocorrência <?php echo $id?> ?</h3>

		<form action="delete.php" method="post" id="form3"> 
			<div class="form-group col-md-4 col-sm-6 col-xs-12">
				<input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">	

				<input type="text" class="form-control" name="modiConcelho" value="<?php echo $concelho; ?>">
				<input type="text" class="form-control" name="modiDatahora"  value="<?php echo $datahora; ?>">
				<input type="number" class="form-control" name="modiMortos"  value="<?php echo $mortos; ?>">
				<input type="number" class="form-control" name="modiFeridosgraves"  value="<?php echo $feridosgraves; ?>">
				<input type="text" class="form-control" name="modiVias"  value="<?php echo $vias; ?>">
				<input type="text" class="form-control" name="modiKm"  value="<?php echo $km; ?>">
				<input type="text" class="form-control" name="modiTipoacidente"  value="<?php echo $tipoacidente; ?>">
				<input type="text" class="form-control" name="modiDescricao" value="<?php echo $descricao; ?>">
				<input type="number" class="form-control" name="modiFeridosleves"  value="<?php echo $feridosleves; ?>">
				<input type="text" class="form-control" name="modiGps" value="<?php echo $gps; ?>">
				<input type="submit" name="delete" class="btn btn-outline-success" value="Deletar">
			</div>
		</form>
	</div>

		<?php
		//------------------------------->>>PARTE DO DELETE<<<------------------------------------
		if (isset($_POST['delete'])) {
			$id = $_POST["id"];
			$querydelete = 'DELETE FROM acidentes WHERE acidentes_id ='.$id.''; 
			$result = pg_query($querydelete);
			
		}