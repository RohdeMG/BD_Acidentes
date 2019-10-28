		<?php
		require_once("header.php");
		require_once("validacao.php");

		if(isset($_SESSION)){
		  //var_dump($_SESSION); ***no insert colocar os nomes(concelho,natureza) mas insere com o id 
			?>

		<div class="col-md-12 col-sm-12 col-xs-12 barratopo">
			<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3>Olá, <?php echo $_SESSION["UsuarioNome"];?></h3></div>
			<div class="col-md-6 col-sm-8 col-xs-12 text-right">		
				<a class="btn btn-primary space" href="logout.php">Sair</a>
			</div>
		</div>





	<div class="col-md-8 col-sm-6 col-xs-12">
		<h3>Filtros:</h3>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<form action="?" method="post">
						<div class="form-group">
							Concelho
							<select class="form-control" name="filtroConcelho" placeholder="Concelho" required="">
								
				<?php
				$query = 'SELECT DISTINCT "nome","concelhos_id" FROM concelhos ORDER BY "nome" ASC';
				$result = pg_query($query);

				while ($row = pg_fetch_array($result)) {
					echo '<option>'.$row["nome"].'</option>'; 
				}?>
							</select>
Natureza
							<select class="form-control" name="filtroNatureza" placeholder="Natureza" required="">
								
				<?php
				$query = 'SELECT * FROM tipoacidente ORDER BY "nome" ASC';
				$result = pg_query($query);

				while ($row = pg_fetch_array($result)) {
					echo '<option>'.$row["nome"].'</option>'; 
				}?>
							</select>
						</div>  

						<input type="number" class="form-control" name="filtroMortos" placeholder="Mortos" required="">
						<input type="number" class="form-control" name="filtroFeridos" min="0" max="50" placeholder="Feridos" required="">

						<input type="submit" name="filtro" class="btn btn-outline-success" value="Filtrar">
					</form>
				</div>			
	</div>






<!-- Form de adicionar ocerrências -->
	<div class="col-md-4 col-sm-6 col-xs-12">
		<button type="button" class="btn btn-success" id="btnadd">Adicionar Ocorrência</button>
		<form action="?" method="post" id="form1">
			<div class="form-group">
				<select class="form-control" name="addConcelho" placeholder="Concelho" required="">
			<?php
			$query = 'SELECT nome,concelhos_id FROM concelhos ORDER BY nome ASC';
			$result = pg_query($query);

			while ($row = pg_fetch_array($result)) {
				echo '<option>'.$row["concelhos_id"].'</option>'; 
			}?>
						</select>
			
			<input type="number" class="form-control" name="addMortos" placeholder="Mortos">
			<input type="number" class="form-control" name="addFeridos" placeholder="Feridos Graves">
			<input type="text" class="form-control" name="addVia" placeholder="Via">
			<input type="text" class="form-control" name="addKm" placeholder="Km">
			<input type="text" class="form-control" name="addLatlong" placeholder="GPS">
			<input type="text" class="form-control" name="addDescricao" placeholder="Descrição">
			<input type="number" class="form-control" name="addFeridosleves" placeholder="Feridos leves">

<input type="hidden" class="form-control" name="idconcelho">

				<select class="form-control" name="addNatureza" placeholder="Concelho" required="">
			<?php
			$query = 'SELECT nome,tipoacidente_id FROM tipoacidente ORDER BY nome ASC';
			$result = pg_query($query);

			while ($row = pg_fetch_array($result)) {
				echo '<option>'.$row["tipoacidente_id"].' - '.$row["nome"].'</option>'; 
			}?>
						</select>



						<div id="datetimepicker1" class="input-append date">
							<input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="addDatahora"></input>
							<span class="add-on">
								<label for="palavrapasse">
									<i class="fas fa-calendar-alt"></i>
								</label>
							</span>
						</div>
	
		

			<input type="submit" name="add" class="btn btn-outline-success" value="Adicionar">
			</div>
		</form>
	</div>







	<div class="col-md-10 col-sm-8 col-xs-12 text-center">
		<?php
		switch ($_SESSION["UsuarioGrupo"]) {
						case 1: // grupo 1, pode adicionar

						if(isset($_POST['add'])){
							$addConcelho= '\''.$_POST["addConcelho"].'\'';
							$addDatahora= '\''.$_POST["addDatahora"].'\'';
							$addMortos= '\''.$_POST["addMortos"].'\'';
							$addFeridos= '\''.$_POST["addFeridos"].'\'';
							$addVia= '\''.$_POST["addVia"].'\'';
							$addKm= '\''.$_POST["addKm"].'\'';
							$addNatureza= '\''.$_POST["addNatureza"].'\'';
							$addLatlong= '\''.$_POST["addLatlong"].'\'';
							$addDescricao= '\''.$_POST["addDescricao"].'\'';
							$addFeridosleves= '\''.$_POST["addFeridosleves"].'\'';

							//$idconcelho= '\''.$_POST["idconcelho"].'\'';

							$query = 'INSERT INTO acidentes ("concelho","datahora","mortos","feridosgraves","vias","km","tipoacidente","descricao","feridosleves","gps") VALUES('.$addConcelho.','.$addDatahora.','.$addMortos.','.$addFeridos.','.$addVia.','.$addKm.','.$addNatureza.','.$addDescricao.','.$addFeridosleves.','.$addLatlong.');';
							$result = pg_query($query);
							
						}


						break;





						case 2: // grupo 2
						if(isset($_POST['filtro'])){
							$filtroConcelho= '\''.$_POST["filtroConcelho"].'\'';
							$filtroNatureza= '\''.$_POST["filtroNatureza"].'\'';
							$filtroMortos= '\''.$_POST["filtroMortos"].'\'';
							$filtroFeridos= '\''.$_POST["filtroFeridos"].'\'';
							//$filtroData= '\''.$_POST["filtroData"].'\'';


							// if(isset($_POST["filtroConcelho"])){
							// 	$conceadd = ''.$filtroConcelho.' AND ';
							// }

							// if(isset($_POST["filtroMortos"])){
							// 	$moradd = ''.$filtroMortos.' AND ';
							// }

							// if(isset($_POST["filtroFeridos"])){
							// 	$feriadd = ''.$filtroFeridos.'';
							// }


	
							$queryfiltro = 'SELECT *,tipoacidente.nome AS natureza,concelhos.nome AS nomeconcelho 
							FROM acidentes,concelhos,tipoacidente 
							WHERE acidentes.concelho = concelhos.concelhos_id AND concelhos.nome ='.$filtroConcelho.' AND mortos = '.$filtroMortos.' AND feridosgraves = '.$filtroFeridos.' AND acidentes.tipoacidente = tipoacidente.tipoacidente_id AND tipoacidente.nome = '.$filtroNatureza.'';

							$result = pg_query($queryfiltro);
							
							if(pg_num_rows($result) == null){
								echo "Nenhuma ocorrência encontrada.";
							}else{
							echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                	<th scope='col'>ID</th>
                                    <th scope='col'>Concelho</th>
                                    <th scope='col'>Datahora</th>
                                    <th scope='col'>Mortos</th>
                                    <th scope='col'>Feridos Grave</th>
                                    <th scope='col'>Via</th>
                                    <th scope='col'>Km</th>
                                    <th scope='col'>Natureza</th>
                                    <th scope='col'>Modificar</th>
                                </tr>
                            </thead>
                            <tbody>";

							while ($row = pg_fetch_array($result)) {
								echo "<tr>
								<td>" . $row["acidentes_id"]. "</td>
								<td>" . $row["nomeconcelho"]. "</td>
								<td>" . $row["datahora"]. "</td>
								<td>" . $row["mortos"]. "</td>
								<td>" . $row["feridosgraves"]. "</td>
								<td>" . $row["km"]. "</td>
								<td>" . $row["vias"]. "</td>
								<td>" . $row["natureza"]. "</td>
								<td><button type='button' class='btn btn-success' id='btnmodificar'>Alterar</button></td>
								</tr>";
							}}?>
							  </tbody>
       						</table>
       		





       		<form action="?" method="post" id="form2">
			<div class="form-group">
			<input type="number" class="form-control" name="modiID" placeholder="ID">
			<input type="text" class="form-control" name="modiConcelho" placeholder="Concelho">
			<input type="number" class="form-control" name="modiMortos" placeholder="Mortos">
			<input type="number" class="form-control" name="modiFeridos" placeholder="Feridos Graves">
			<input type="text" class="form-control" name="modiVia" placeholder="Via">
			<input type="text" class="form-control" name="modiKm" placeholder="Km">
			<input type="text" class="form-control" name="modiNatureza" placeholder="Natureza">
			<input type="submit" name="btnmodificar" class="btn btn-outline-success" value="Modificar">
			</div>
			</form>
							<?php
						// 	}
						// 	if(isset($_POST['btnmodificar'])){
						// 	$modiID= '\''.$_POST["modiID"].'\'';
						// 	$modiConcelho= '\''.$_POST["modiConcelho"].'\'';
						// 	$modiMortos= '\''.$_POST["modiMortos"].'\'';
						// 	$modiFeridos= '\''.$_POST["modiFeridos"].'\'';
						// 	$modiVia= '\''.$_POST["modiVia"].'\'';
						// 	$modiKm= '\''.$_POST["modiKm"].'\'';
						// 	$modiNatureza= '\''.$_POST["modiNatureza"].'\'';


						// 	$query = 'UPDATE info SET "Concelho" = '.$modiConcelho.',"M"='.$modiMortos.',"FG"='.$modiFeridos.',"Via"='.$modiVia.',"Km"='.$modiKm.',"Natureza" ='.$modiNatureza.' WHERE "ID"='.$modiID.'';
						// 	$result = pg_query($query);

						}

								break;
						
						
		}



					
				}else{
					header('Location:logout.php');
				}
				?>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#btnadd").click(function() {
				$("#form1").toggle();
			});
		});
		$(document).ready(function() {
			$("#btnmodificar").click(function() {
				$("#form2").toggle();
			});
		});

  $(function() {
    $('#datetimepicker1').datetimepicker({
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