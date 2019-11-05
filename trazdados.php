	<?php
	require_once("header.php");
	require_once("validacao.php");
	

	if(isset($_SESSION)){
//var_dump($_SESSION);
		// if($_SESSION["UsuarioID"] == 1){
		// 	$_SESSION["imagem"] = "indice.png";
		// 	//<img src="images/<?php echo $_SESSION["imagem"]" width="10%">
		// }
		?>


		<div class="col-md-12 col-sm-12 col-xs-12 barratopo">
			<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3 class="colorname">Olá, <?php echo $_SESSION["UsuarioNome"];?></h3>
			</div>
			<div class="col-md-6 col-sm-8 col-xs-12 text-right">		
				<a class="btn btn-primary space" href="logout.php">Sair</a>
			</div>
		</div>



<!-- FORMULÁRIO DE FILTRO -->
		<div class="container shadowbox">
			<h4>Filtro de busca:</h4>			
			<form action="?" method="post">
				<div class="form-group">
					<div class="col-md-2 col-sm-3 col-xs-12">
						<h5>Concelho</h5>
						<select class="form-control" name="filtroConcelho" placeholder="Concelho" required="">

							<?php
							$query = 'SELECT DISTINCT "nome","concelhos_id" FROM concelhos ORDER BY "nome" ASC';
							$result = pg_query($query);

							while ($row = pg_fetch_array($result)) {
								echo '<option>'.$row["nome"].'</option>'; 
							}?>
						</select>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-12">
						<h5>Natureza</h5>
						<select class="form-control" name="filtroNatureza" placeholder="Natureza" required="">

							<?php
							$query = 'SELECT * FROM tipoacidente ORDER BY "nome" ASC';
							$result = pg_query($query);

							while ($row = pg_fetch_array($result)) {
								echo '<option>'.$row["nome"].'</option>'; 
							}?>
						</select>
					</div>  

					<div class="col-md-2 col-sm-2 col-xs-12"><h5>Nº Mortos</h5><input type="number" class="form-control" name="filtroMortos"></div>
					<div class="col-md-2 col-sm-2 col-xs-12"><h5>Nº Feridos Graves</h5><input type="number" class="form-control" name="filtroFeridos"></div>

					<div id="datetimepicker2" class="input-append date col-md-2 col-sm-4 col-xs-12">
						<h5>Data Inicial</h5>
						<input data-format="yyyy-MM-dd" type="text" class="form-control" name="data1">
						<span class="add-on">
							<label for="palavrapasse">
								<i class="fas fa-calendar-alt"></i>
							</label>
						</span>
					</div>

					<div id="datetimepicker3" class="input-append date col-md-2 col-sm-4 col-xs-12">
						<h5>Data Final</h5>
						<input data-format="yyyy-MM-dd" type="text" class="form-control" name="data2">
						<span class="add-on">
							<label for="palavrapasse">
								<i class="fas fa-calendar-alt"></i>
							</label>
						</span>
					</div>

					<input type="submit" name="filtro" class="btn btn-outline-success space" value="Filtrar">
				</div>
				</form>		
		</div>

<div class="container text-right">
	<button type="button" class="btn btn-info btn-sm space" id="btnadd">Adicionar Ocorrência</button>
	<button type="button" class="btn btn-info btn-sm space" id="btnaddumconcelho">Adicionar Concelho</button>
	<button type="button" class="btn btn-info btn-sm space" id="btnaddtipoacidente">Adicionar Tipo de Acidente</button>
</div>


		<!-- FORMULÁRIO DE ADIÇÃO DE CONCELHOS -->
	<div class="container">

		<div class="col-md-3 col-sm-4 col-xs-12 text-right pull-right">
			<form action="?" method="post" id="form3">
				<div class="form-group">
					<input type="text" class="form-control" name="addOnlyConcelho" placeholder="Concelho" required="">

					<select class="form-control" name="adddistrito" placeholder="Distrito" required="">
						<?php
						$query = 'SELECT nome,distritos_id FROM distritos ORDER BY nome ASC';
						$result = pg_query($query);
							 //pega o id do distrito!

						while ($row = pg_fetch_assoc($result)) {

							echo '<option value="'.$row["distritos_id"].' | '.$row["nome"].'">'.$row["nome"].'</option>';
							$iddistrito = explode(" | ", $_POST["adddistrito"]);

						}
						;?>
					</select>
					<input type="submit" name="addSoConcelho" class="btn btn-outline-success space" value="Adicionar">
				</div>
				<hr></hr> 
			</form>
		


		<!-- FORMULÁRIO DE ADIÇÃO DE TIPOS DE ACIDENTES -->
		
			<form action="?" method="post" id="form2">
				<div class="form-group">
					<input type="text" class="form-control" name="addOnlyTAcidente" placeholder="Tipo de Acidente" required="">
					<input type="submit" name="addTipoAcidente" class="btn btn-outline-success space" value="Adicionar">
				</div>
				<hr></hr>
			</form>
		


<!-- FORMULÁRIO DE ADIÇÃO DE OCORRÊNCIAS -->
						
				<form action="?" method="post" id="form1">
					<div class="form-group">
						<select class="form-control" name="addConcelho" placeholder="Concelho" required="">
							<?php
							$query = 'SELECT nome,concelhos_id FROM concelhos ORDER BY nome ASC';
							$result = pg_query($query);
							$concepost = $_POST["addConcelho"];
							while ($row = pg_fetch_assoc($result)) {

								echo '<option value="'.$row["concelhos_id"].' | '.$row["nome"].'">'.$row["nome"].'</option>';
								$idconcelho = explode(" | ", $concepost );

							}?>
						</select>

						<input type="number" class="form-control" name="addMortos" placeholder="Mortos">
						<input type="number" class="form-control" name="addFeridos" placeholder="Feridos Graves">
						<input type="text" class="form-control" name="addVia" placeholder="Via">
						<input type="text" class="form-control" name="addKm" placeholder="Km">
						<input type="text" class="form-control" name="addLatlong" placeholder="GPS">
						<input type="text" class="form-control" name="addDescricao" placeholder="Descrição">
						<input type="number" class="form-control" name="addFeridosleves" placeholder="Feridos leves">



						<select class="form-control" name="addNatureza" placeholder="Concelho" required="">
							<?php
							$query = 'SELECT nome,tipoacidente_id FROM tipoacidente ORDER BY nome ASC';
							$result = pg_query($query);
							$natupost = $_POST["addNatureza"];

							while ($row = pg_fetch_assoc($result)) {		
								echo '<option value="'.$row["tipoacidente_id"].' | '.$row["nome"].'">'.$row["nome"].'</option>';
								$idnatureza = explode(" | ", $natupost);

							}?>
						</select>



						<div id="datetimepicker1" class="input-append date">
							<input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="addDatahora" placeholder="Data e hora">
							<span class="add-on">
								<label for="palavrapasse">
									<i class="fas fa-calendar-alt"></i>
								</label>
							</span>
						</div>

						<input type="submit" name="add" class="btn btn-outline-success" value="Adicionar">
					</div>
					<hr></hr>
				</form>
			</div>
	</div>




			
				<?php
				switch ($_SESSION["UsuarioGrupo"]) {
					case 1:
					case 2: 


//PARA INSERIR OS DADOS DE CONCELHO
				if(isset($_POST['addSoConcelho'])){
						$addOnlyConcelho= '\''.$_POST["addOnlyConcelho"].'\'';

						// $query = 'INSERT INTO concelhos ("nome","distrito") VALUES('.$addOnlyConcelho.','.$iddistrito[0].');';
						// $result = pg_query($query);

						//FUNÇÃO INSERT CONCELHO
						$queryinsert = pg_exec($myPDO,'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; SELECT insert_c('.$addOnlyConcelho.','.$iddistrito[0].') AS result; SELECT pg_sleep(6)');


						if($queryinsert){
						//INSERE NO HISTÓRICO A OPERACÃO
						$lastid = 'SELECT max(concelhos_id) AS lid FROM concelhos'; 
						$resulta = pg_query($lastid);
						$row = pg_fetch_assoc($resulta);
						$lastinsert = $row["lid"];
					

						$date = '\''.date('Y-m-d h:i:s A', time()).'\'';
						$operacao = "inserção de concelho";
						$operacaook = '\''.$operacao.'\'';

						$queryhistoric= 'INSERT INTO historico ("acidente","utilizador","datahora","operacao") VALUES('.$lastinsert.','.$_SESSION["UsuarioID"].','.$date.','.$operacaook.')';
						$result = pg_query($queryhistoric);

						echo "<div class='alert alert-success col-md-3' role='alert'>Concelho adicionado com sucesso!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";
					}else{

						echo "<div class='alert alert-warning col-md-3' role='alert'>Concelho não adicionado, tente novamente!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";
					}
				}

//PARA INSERIR OS DADOS TIPO DE ACIDENTE
				if(isset($_POST['addTipoAcidente'])){
						$addOnlyTAcidente= '\''.$_POST["addOnlyTAcidente"].'\'';

						// $query = 'INSERT INTO tipoacidente ("nome") VALUES('.$addOnlyTAcidente.');';
						// $result = pg_query($query);

						//FUNÇÃO INSERT TIPO ACIDENTE
						$queryinsert = pg_exec($myPDO,'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; SELECT insert_ta('.$addOnlyTAcidente.') AS result; SELECT pg_sleep(6)');

						if($queryinsert){
							echo "<div class='alert alert-success col-md-3' role='alert'>Tipo de Acidente adicionado com sucesso!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";
							
						//INSERE NO HISTÓRICO A OPERACÃO
						$lastid = 'SELECT max(tipoacidente_id) AS lid FROM tipoacidente'; 
						$resulta = pg_query($lastid);
						$row = pg_fetch_assoc($resulta);
						$lastinsert = $row["lid"];
					

						$date = '\''.date('Y-m-d h:i:s A', time()).'\'';
						$operacao = "inserção de tipo de acidente";
						$operacaook = '\''.$operacao.'\'';

						$queryhistoric= 'INSERT INTO historico ("acidente","utilizador","datahora","operacao") VALUES('.$lastinsert.','.$_SESSION["UsuarioID"].','.$date.','.$operacaook.')';
						$result = pg_query($queryhistoric);

						
					}else{
						echo "<div class='alert alert-warning col-md-3' role='alert'>Tipo de Acidente não adicionado, tente novamente!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";
					}
				}




//PARA INSERIR OS DADOS DA ADIÇÃO
					if(isset($_POST['add'])){

						if(empty($_POST["addMortos"])){
							$addMortos = "NULL";

						}else{
							$addMortos = '\''.$_POST["addMortos"].'\'';
						}

						if(empty($_POST["addFeridos"])){
							$addFeridos = "NULL";

						}else{
							$addFeridos = '\''.$_POST["addFeridos"].'\'';
						}

						if(empty($_POST["addVia"])){
							$addVia = "NULL";

						}else{
							$addVia = '\''.$_POST["addVia"].'\'';
						}

						if(empty($_POST["addKm"])){
							$addKm = "NULL";

						}else{
							$addKm = '\''.$_POST["addKm"].'\'';
						}

						if(empty($_POST["addLatlong"])){
							$addLatlong = "NULL";

						}else{
							$addLatlong = '\''.$_POST["addLatlong"].'\'';
						}

						if(empty($_POST["addFeridosleves"])){
							$addFeridosleves = "NULL";

						}else{
							$addFeridosleves = '\''.$_POST["addFeridosleves"].'\'';
						}

						if(empty($_POST["addDescricao"])){
							$addDescricao = "NULL";

						}else{
							$addDescricao = '\''.$_POST["addDescricao"].'\'';
						}


						$addConcelho= '\''.$_POST["addConcelho"].'\'';
						$addDatahora= '\''.$_POST["addDatahora"].'\'';
						$addNatureza= '\''.$_POST["addNatureza"].'\'';



						//FUNÇÃO DE INSERT ACIDENTES
						$queryinsert = pg_exec($myPDO,'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; SELECT insert_a('.$idconcelho[0].','.$addDatahora.','.$addMortos.','.$addFeridos.','.$addVia.','.$addKm.','.$idnatureza[0].','.$addDescricao.','.$addFeridosleves.','.$addLatlong.') AS result; SELECT pg_sleep(6)');

						if($queryinsert){
							echo "<div class='alert alert-success col-md-3' role='alert'>Ocorrência adicionada com sucesso!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";

						//INSERE NO HISTÓRICO A OPERACÃO
						$lastid = 'SELECT max(acidentes_id) AS lid FROM acidentes'; 
						$resulta = pg_query($lastid);
						$row = pg_fetch_assoc($resulta);
						$lastinsert = $row["lid"];
					

						$date = '\''.date('Y-m-d h:i:s A', time()).'\'';
						$operacao = "inserção de acidente";
						$operacaook = '\''.$operacao.'\'';

						$queryhistoric= 'INSERT INTO historico ("acidente","utilizador","datahora","operacao") VALUES('.$lastinsert.','.$_SESSION["UsuarioID"].','.$date.','.$operacaook.')';
						$result = pg_query($queryhistoric);

						}else{
							echo "<div class='alert alert-warning col-md-3' role='alert'>Ocorrência não adicionada, tente novamente!</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 5000);</script>";
						}


					}
			


//PARA FILTRAR OS DADOS E MOSTRAR NA TABELA
				if(isset($_POST['filtro']) && isset($_SESSION['UsuarioID'])){
					$filtroConcelho= '\''.$_POST["filtroConcelho"].'\'';
					$filtroNatureza= '\''.$_POST["filtroNatureza"].'\'';
					$tratadata1 = '\''.$_POST["data1"].'\'';
					$tratadata2 = '\''.$_POST["data2"].'\'';

					if(empty($_POST["filtroMortos"])){
						$filtroMortos= '';
					}else{
						$filtroMortos = ' AND mortos = '.$_POST["filtroMortos"].' ';
					}

					if(empty($_POST["filtroFeridos"])){
						$filtroFeridos= '';
					}else{
						$filtroFeridos = ' AND feridosgraves = '.$_POST["filtroFeridos"].' ';
					}

					if(empty($_POST["data1"]) || empty($_POST["data2"])){
						$datas= '';
						$dt = '';
					}else{
						$datas = ' AND datahora BETWEEN '.$tratadata1.' AND '.$tratadata2.' ';
						$dt =',date(datahora) ';
					}




					$queryfiltro = 'SELECT *,tipoacidente.nome AS natureza,concelhos.nome AS nomeconcelho '.$dt.' FROM acidentes,concelhos,tipoacidente 
					WHERE acidentes.concelho = concelhos.concelhos_id 
					AND concelhos.nome ='.$filtroConcelho.' '.$filtroMortos.' '.$filtroFeridos.' AND acidentes.tipoacidente = tipoacidente.tipoacidente_id AND tipoacidente.nome = '.$filtroNatureza.' '.$datas.' ORDER BY acidentes_id ASC';
					$result = pg_query($queryfiltro);


					if(pg_num_rows($result) == null){
						echo "<div class='container spacetopo alert alert-warning' role='alert'>Nenhuma ocorrência encontrada.</div><script type='text/javascript'>window.setTimeout(function() {window.location.href = 'trazdados.php';}, 2000);</script>";
					}else{
						echo "<div class='container spacetopo'><table class='table table-bordered table-striped'>
						<thead class='fundotable'>
						<tr>
						<th scope='col'>ID</th>
						<th scope='col'>Concelho</th>
						<th scope='col'>Data e hora</th>
						<th scope='col'>Mortos</th>
						<th scope='col'>Feridos Graves</th>
						<th scope='col'>Km</th>
						<th scope='col'>Via</th>
						<th scope='col'>Natureza</th>
						<th scope='col'>Descrição</th>
						<th scope='col'>Feridos Leves</th>
						<th scope='col'>GPS</th>
						<th scope='col'>Editar</th>";
						if($_SESSION["UsuarioGrupo"] == 1){
						echo "<th scope='col'>Deletar</th>";
						}
						echo"</tr>
						</thead>
						<tbody>";

						while ($row = pg_fetch_array($result)) {
							$_SESSION["idparaupdate"] = $row["acidentes_id"];
							echo "<tr>
							<td>" . $row["acidentes_id"]. "</td>
							<td>" . $row["nomeconcelho"]. "</td>
							<td>" . $row["datahora"]. "</td>
							<td>" . $row["mortos"]. "</td>
							<td>" . $row["feridosgraves"]. "</td>
							<td>" . $row["km"]. "</td>
							<td>" . $row["vias"]. "</td>
							<td>" . $row["natureza"]. "</td>
							<td>" . $row["descricao"]. "</td>
							<td>" . $row["feridosleves"]. "</td>
							<td>" . $row["gps"]. "</td>
							<td><a href='update.php?edit=".$row["acidentes_id"]."' class='edit_btn btn btn-info btn-sm'><i class='far fa-edit'></i></a></td>";
							if($_SESSION["UsuarioGrupo"] == 1){
							echo "<td><a href='delete.php?del=".$row["acidentes_id"]."' class='del_btn btn btn-danger btn-sm'><i class='far fa-trash-alt'></i></a></td>";
							}
							echo"</tr>";
							
						}}?>
					</tbody>
				</table>
			</div>

				<?php
			}

			break;
		} //chave do switch case

	}else{ //chave do isset SESSION
		header('Location:logout.php');
	}
	?>






<!--JQUERY-->
	<script type="text/javascript">
		$(document).ready(function() {
			$("#btnadd").click(function() {
				$("#form1").toggle();
				$("#form2").hide();
				$("#form3").hide();
			});
		});
		$(document).ready(function() {
			$("#btnaddtipoacidente").click(function() {
				$("#form2").toggle();
				$("#form1").hide();
				$("#form3").hide();
			});
		});
		$(document).ready(function() {
			$("#btnaddumconcelho").click(function() {
				$("#form3").toggle();
				$("#form1").hide();
				$("#form2").hide();
			});
		});
		$(function() {
			$('#datetimepicker1').datetimepicker({
				language: 'pt-BR',
				pickTime: false
			});
		});
		$(function() {
			$('#datetimepicker2').datetimepicker({
				language: 'pt-BR',
				pickTime: false
			});
		});
		$(function() {
			$('#datetimepicker3').datetimepicker({
				language: 'pt-BR',
				pickTime: false
			});
		});
		;(function($){
			$.fn.datetimepicker.dates['pt-BR'] = {
				days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
				daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"],
				daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa", "Do"],
				months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
				today: "Hoje"
			};
		}(jQuery));
	</script>

	</body>
</html>