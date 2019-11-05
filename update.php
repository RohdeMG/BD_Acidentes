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
					$datahoratabela = $row['datahora'];
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
		

		?>


		<div class="col-md-12 col-sm-12 col-xs-12 barratopo">
			<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3 class="colorname">Olá, <?php echo $_SESSION["UsuarioNome"];?></h3></div>
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

						<div id="datetimepicker4" class="input-append date">
							<input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="modiDatahora" placeholder="Data e hora" value="<?php echo $datahoratabela; ?>">
							<span class="add-on">
								<label for="palavrapasse">
									<i class="fas fa-calendar-alt"></i>
								</label>
							</span>
						</div>

					<!--<input type="text" class="form-control" name="modiDatahora" placeholder="Data e hora" value="<?php echo $datahoratabela; ?>">-->
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
	
<script type="text/javascript">
	$(function() {
			$('#datetimepicker4').datetimepicker({
				language: 'pt-BR',
				pickTime: false
			});
		});
</script>


	<?php
	if(isset($id)){ // se o id ainda existe, faz o update.
	//------------------------------->>>SALVAR O UPDATE<<<------------------------------------
	if(isset($_POST["update"])){ 


		if(empty($_POST["modiFeridosleves"])){
				$feridosleves = "NULL";
			}else{
				$feridosleves = '\''.$_POST["modiFeridosleves"].'\'';
			}

		if(empty($_POST["modiFeridosgraves"])){
				$feridosgraves = "NULL";
			}else{
				$feridosgraves = '\''.$_POST["modiFeridosgraves"].'\'';
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

			if(empty($_POST["modiDatahora"])){
				$datahora = "NULL";
			}else{
				$datahora = '\''.$_POST["modiDatahora"].'\'';			
			}

			if(empty($_POST["modiMortos"])){
				$mortos = "NULL";
			}else{
				$mortos = '\''.$_POST["modiMortos"].'\'';			
			}

		$id = '\''.$_POST["id"].'\'';
	    $iddoconcelho = '\''.$idconcelho[0].'\'';
	    $iddanatureza = '\''.$idnatureza[0].'\'';
		

		//FUNÇÃO UPDATE ACIDENTE
		$queryupdate = pg_exec($myPDO,'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; SELECT update_a('.$id.','.$iddoconcelho.','.$datahora.','.$mortos.','.$feridosgraves.','.$vias.','.$km.','.$iddanatureza.','.$descricao.','.$feridosleves.','.$gps.') AS result');
		
		if($queryupdate){
			echo "<div class='alert alert-success col-md-3' role='alert'>Alteração realizada com sucesso!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";	

		//INSERE NO HISTÓRICO A OPERACÃO
		$date = '\''.date('Y-m-d h:i:s A', time()).'\'';
		$operacao = "update de acidente";
		$operacaook = '\''.$operacao.'\'';

		$queryhistoric= 'INSERT INTO historico ("acidente",utilizador,"datahora","operacao") VALUES('.$id.','.$_SESSION["UsuarioID"].','.$date.','.$operacaook.')';
		$result = pg_query($queryhistoric);

		}else{
			echo "<div class='alert alert-warning col-md-3' role='alert'>Alteração não realizada, tente novamente!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";	
		}
		
	}
	
	}else{ 
	echo "<div class='alert alert-warning col-md-3' role='alert'>Essa ocorrência não existe!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 3000);</script>";
}


		
			








	