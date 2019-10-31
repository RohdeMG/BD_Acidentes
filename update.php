	<?php
	require_once("conexao.php");
	require_once("header.php");

	$mortos = "";
	$id = "";
	$feridosgraves = "";
	$feridosleves = "";
	$datahora = "";
	$vias = "";
	$km = "";
	$descricao = "";
	$gps = "";

switch ($_SESSION["UsuarioGrupo"]) {
					case 1:
					case 2:

	//------------------------------->>>PARTE PARA SALVAR O UPDATE<<<------------------------------------
	if(isset($_GET["edit"])){
					$id = $_GET["edit"];


					$query = 'SELECT *,tipoacidente.nome AS natureza,concelhos.nome AS nomeconcelho 
								FROM acidentes,concelhos,tipoacidente 
								WHERE acidentes.concelho = concelhos.concelhos_id 
								AND acidentes.tipoacidente = tipoacidente.tipoacidente_id AND acidentes_id = '.$id.'';
					$result = pg_query($query);
					$row = pg_fetch_array($result);

					
					$id = $row['acidentes_id'];
					$concelho = $row['concelhos_id'];
					$concelhonome = $row['nomeconcelho'];
					$datahora = $row['datahora'];
					$mortos = $row['mortos'];
					$feridosgraves = $row['feridosgraves'];
					$vias = $row['vias'];
					$km = $row['km'];
					$tipoacidente = $row['natureza'];
					$tipoacidenteid = $row['tipoacidente_id'];
					$descricao = $row['descricao'];
					$feridosleves = $row['feridosleves'];
					$gps = $row['gps'];
					
				}
				
				
		}		
		if(isset($id)){ //VERIFICA SE O ID AINDA EXISTE PARA ALTERAR

		?>


		<div class="col-md-12 col-sm-12 col-xs-12 barratopo">
			<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3>Olá, <?php echo $_SESSION["UsuarioNome"];?></h3></div>
			<div class="col-md-6 col-sm-8 col-xs-12 text-right">		
				<a class="btn btn-primary space" href="logout.php">Sair</a>
			</div>
		</div>


		<div class="container">
			<h3>Alterar ocorrência <?php echo $id?>?</h3>

			<form action="update.php" method="post" id="form4">
				<div class="form-group col-md-4 col-sm-6 col-xs-12">
					<input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">	

					<select class="form-control" name="modiConcelho" placeholder="Concelho">
						<?php
						$query = 'SELECT nome,concelhos_id FROM concelhos ORDER BY nome ASC';
						$result = pg_query($query);
						$concepost = $_POST["modiConcelho"];
						echo '<option value="'.$concelho.' | '.$concelhonome.'">'.$concelhonome.'</option>';
						while ($row = pg_fetch_assoc($result)){

							echo '<option value="'.$row['concelhos_id'].' | '.$row['nome'].'">'.$row['nome'].'</option>';
							$idconcelho = explode(" | ", $concepost );

						}	
						?>
					</select>

					<input type="text" class="form-control" name="modiDatahora" placeholder="Data e hora" value="<?php echo $datahora; ?>">
					<input type="number" class="form-control" name="modiMortos" placeholder="Nº Mortos"  value="<?php echo $mortos; ?>">
					<input type="number" class="form-control" name="modiFeridosgraves" placeholder="Feridos graves" value="<?php echo $feridosgraves; ?>">
					<input type="text" class="form-control" name="modiVias" placeholder="Via" value="<?php echo $vias; ?>">
					<input type="text" class="form-control" name="modiKm" placeholder="Km" value="<?php echo $km; ?>">

					<select class="form-control" name="modiTipoacidente" placeholder="Natureza">
						<?php
						$query = 'SELECT nome,tipoacidente_id FROM tipoacidente ORDER BY nome ASC';
						$result = pg_query($query);
						$natupost = $_POST["modiTipoacidente"];
						echo '<option value="'.$tipoacidenteid.' | '.$tipoacidente.'">'.$tipoacidente.'</option>';
						while ($row = pg_fetch_assoc($result)) {		
							echo '<option value="'.$row['tipoacidente_id'].' | '.$row['nome'].'">'.$row['nome'].'</option>';
							$idnatureza = explode(" | ", $natupost);

						}?>
					</select>

					<input type="text" class="form-control" name="modiDescricao" placeholder="Descrição" value="<?php echo $descricao; ?>">
					<input type="number" class="form-control" name="modiFeridosleves" placeholder="Feridos leves"  value="<?php echo $feridosleves; ?>">
					<input type="text" class="form-control" name="modiGps" placeholder="GPS" value="<?php echo $gps; ?>">
					<input type="submit" name="update" class="btn btn-outline-success space" value="Salvar">
				</div>
			</form>
		</div>
	



	<?php
	//------------------------------->>>SALVAR O UPDATE<<<------------------------------------
	if(isset($_POST["update"])){


		if(empty($_POST["modiFeridosleves"])){
				$feridosleves = "NULL";
			}else{
				$feridosleves = '\''.$_POST["modiFeridosleves"].'\'';
			}


		if(empty($_POST["modiKm"])){
				$km = "NULL";
			}else{
				$km = '\''.$_POST["modiKm"].'\'';
			}


		if(empty($_POST["modiGps"])){
				$gps = "NULL";

			}else{
				$gps = '\''.$_POST["modiGps"].'\'';
			}

		if(empty($_POST["modiVias"])){
				$vias = "NULL";

			}else{
				$vias = '\''.$_POST["modiVias"].'\'';
			}

		if(empty($_POST["modiDescricao"])){
				$descricao = "NULL";

			}else{
				$descricao = '\''.$_POST["modiDescricao"].'\'';
			}



		$datahora = '\''.$_POST["modiDatahora"].'\'';
		$feridosgraves = '\''.$_POST["modiFeridosgraves"].'\'';
		//$vias = '\''.$_POST["modiVias"].'\'';
	    $iddoconcelho = '\''.$idconcelho[0].'\'';
	    $iddanatureza = '\''.$idnatureza[0].'\'';
	    //$descricao = '\''.$_POST["modiDescricao"].'\'';
	    $mortos = '\''.$_POST["modiMortos"].'\'';
		$id = '\''.$_POST["id"].'\'';

		//$km = '\''.$_POST["modiKm"].'\'';
		//$tipoacidente = '\''.$_POST["modiTipoacidente"].'\'';
		//$gps = '\''.$_POST["modiGps"].'\'';
		//$feridosleves = '\''.$_POST["modiFeridosleves"].'\'';
		//$concelho = '\''.$_POST["modiConcelho"].'\'';
		



		//NÃO EXCLUIR ESSA UPDATE COMENTADO
		// $queryupdate = 'UPDATE acidentes SET concelho = '.$iddoconcelho.', datahora ='.$datahora.',mortos ='.$mortos.',feridosgraves ='.$feridosgraves.',vias ='.$vias.', km = '.$km.', tipoacidente ='.$iddanatureza.', descricao ='.$descricao.',feridosleves ='.$feridosleves.',gps='.$gps.' WHERE acidentes_id ='.$id.';';
		// $result = pg_query($queryupdate);

        $query1 = pg_exec($myPDO,'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
		$query = pg_exec($myPDO,'SELECT alterar_aci('.$id.','.$iddoconcelho.','.$datahora.','.$mortos.','.$feridosgraves.','.$vias.','.$km.','.$iddanatureza.','.$descricao.','.$feridosleves.','.$gps.') AS result');
		$rows = pg_num_rows($query);
		?>

		<script type="text/javascript">
			window.location = "trazdados.php";
		</script>

	<?php	

	}

}else{
	echo"nao exsite mais";
}






	