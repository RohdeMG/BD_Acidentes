<?php 
require_once("header.php");
require_once("conexao.php");

switch ($_SESSION["UsuarioID"]) {
	case 1:
	$_SESSION["imagem"] = "PSP.png";
	break;
	case 2:
	$_SESSION["imagem"] = "GNR.png";
	break;
}

$mortos = "";
$id = "";
$feridosgraves = "";
$feridosleves = "";
$datahora = "";
$vias = "";
$km = "";
$descricao = "";
$gps = "";
$tipoacidente = "";
$concelho = "";


if(isset($_GET["del"]) && $_SESSION["UsuarioGrupo"] == 1){ //pega o id do get e verifica se é grupo 1
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
	<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3 class="colorname"><img src="images/<?php echo $_SESSION["imagem"];?>" class="imgspace" width="8%"> Olá, <?php echo $_SESSION["UsuarioNome"]." - ".$_SESSION["Gruponome"];?></h3>
	</div>
	<div class="col-md-6 col-sm-8 col-xs-12 text-right">		
		<a class="btn btn-primary space" href="logout.php">Sair</a>
	</div>
</div>


<div class="container">
	<h3>Deletar ocorrência <?php echo $id?>?</h3>

	<form action="delete.php" method="post" id="form5"> 
		<div class="form-group col-md-4 col-sm-6 col-xs-12">
			<input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">	

			<input type="text" class="form-control" name="modiConcelho" readonly placeholder="Concelho" value="<?php echo $concelho; ?>">
			<input type="text" class="form-control" name="modiDatahora" readonly placeholder="Data e hora" value="<?php echo $datahora; ?>">
			<input type="number" class="form-control" name="modiMortos" readonly placeholder="Número de Mortos" value="<?php echo $mortos; ?>">
			<input type="number" class="form-control" name="modiFeridosgraves" readonly placeholder="Feridos graves" value="<?php echo $feridosgraves; ?>">
			<input type="text" class="form-control" name="modiVias" readonly placeholder="Vias" value="<?php echo $vias; ?>">
			<input type="text" class="form-control" name="modiKm" readonly placeholder="Km" value="<?php echo $km; ?>">
			<input type="text" class="form-control" name="modiTipoacidente" readonly placeholder="Tipo acidente" value="<?php echo $tipoacidente; ?>">
			<input type="text" class="form-control" name="modiDescricao" readonly placeholder="Descrição" value="<?php echo $descricao; ?>">
			<input type="number" class="form-control" name="modiFeridosleves" readonly placeholder="Número de feridos leves" value="<?php echo $feridosleves; ?>">
			<input type="text" class="form-control" name="modiGps" readonly placeholder="GPS" value="<?php echo $gps; ?>">
			<input type="submit" name="delete" class="btn btn-outline-success space" value="Deletar">
		</div>
	</form>
</div>

<?php

if (isset($_POST['delete'])) {
	$id = $_POST["id"];

//FUNÇÃO DELETE ACIDENTE
	$querydelete = pg_exec($myPDO,'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; SELECT delete_a('.$id.') AS result');

	if($querydelete){
		echo "<div class='alert alert-success col-md-3' role='alert'>Exclusão realizada com sucesso!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";


	//INSERE NO HISTÓRICO A OPERACÃO
		$date = '\''.date('Y-m-d h:i:s A', time()).'\'';
		$operacao = "exclusão de acidente";
		$operacaook = '\''.$operacao.'\'';

		$queryhistoric= 'INSERT INTO historico ("acidente",utilizador,"datahora","operacao") VALUES('.$id.','.$_SESSION["UsuarioID"].','.$date.','.$operacaook.')';
		$result = pg_query($queryhistoric);


	}else{
		echo "<div class='alert alert-warning col-md-3' role='alert'>Ocorrência não existe!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";
	}


}
