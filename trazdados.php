		<?php
		require_once("header.php");
		require_once("validacao.php");
		

		if(isset($_SESSION)){
		  //var_dump($_SESSION); 
				?>



		<div class="col-md-12 col-sm-12 col-xs-12 barratopo">
			<div class="col-md-6 col-sm-8 col-xs-12 pull-left"><h3>Olá, <?php echo $_SESSION["UsuarioNome"];?></h3></div>
			<div class="col-md-6 col-sm-8 col-xs-12 text-right">		
				<a class="btn btn-primary space" href="logout.php">Sair</a>
			</div>
		</div>



		<div class="col-md-12 col-sm-12 col-xs-12">
			<h3>Filtro de busca:</h3>			
			<form action="?" method="post">
				<div class="form-group">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<h4>Concelho</h4>
						<select class="form-control" name="filtroConcelho" placeholder="Concelho" required="">

							<?php
							$query = 'SELECT DISTINCT "nome","concelhos_id" FROM concelhos ORDER BY "nome" ASC';
							$result = pg_query($query);

							while ($row = pg_fetch_array($result)) {
								echo '<option>'.$row["nome"].'</option>'; 
							}?>
						</select>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<h4>Natureza</h4>
						<select class="form-control" name="filtroNatureza" placeholder="Natureza" required="">

							<?php
							$query = 'SELECT * FROM tipoacidente ORDER BY "nome" ASC';
							$result = pg_query($query);

							while ($row = pg_fetch_array($result)) {
								echo '<option>'.$row["nome"].'</option>'; 
							}?>
						</select>
					</div>  
					
					<div class="col-md-2"><input type="number" class="form-control" name="filtroMortos" placeholder="Nº Mortos"></div>
					<div class="col-md-2"><input type="number" class="form-control" name="filtroFeridos" placeholder="Nº Feridos Graves"></div>

					<div id="datetimepicker2" class="input-append date col-md-2">
						<input data-format="yyyy-MM-dd" type="text" class="form-control" name="data1" placeholder="Data inicial"></input>
						<span class="add-on">
							<label for="palavrapasse">
								<i class="fas fa-calendar-alt"></i>
							</label>
						</span>
					</div>

					<div id="datetimepicker3" class="input-append date col-md-2">
						<input data-format="yyyy-MM-dd" type="text" class="form-control" name="data2" placeholder="Data final"></input>
						<span class="add-on">
							<label for="palavrapasse">
								<i class="fas fa-calendar-alt"></i>
							</label>
						</span>
					</div>
					
					<input type="submit" name="filtro" class="btn btn-outline-success space" value="Filtrar">
				</form>		
			</div>






<!-- Form de adicionar ocerrências -->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<button type="button" class="btn btn-success" id="btnadd">Adicionar Ocorrência</button>
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
						<input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="addDatahora" placeholder="Data e hora"></input>
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
						case 1: 

//function alterar concelho - pegar os 3 parametros pelo POST
//$query = pg_exec($myPDO,"SELECT alterar_d('18', 'Setúbal') AS result") ;
//$rows = pg_num_rows($query);





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

						

							$query = 'INSERT INTO acidentes ("concelho","datahora","mortos","feridosgraves","vias","km","tipoacidente","descricao","feridosleves","gps") VALUES('.$idconcelho[0].','.$addDatahora.','.$addMortos.','.$addFeridos.','.$addVia.','.$addKm.','.$idnatureza[0].','.$addDescricao.','.$addFeridosleves.','.$addLatlong.');';
							$result = pg_query($query);
							echo $query;
						}?>
</div>


<!--====================================================================================-->
					
<?php

						
						if(isset($_POST['filtro'])){
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
							echo $queryfiltro;

							if(pg_num_rows($result) == null){
								echo "Nenhuma ocorrência encontrada.";
							}else{
							echo "<table class='table table-bordered'>
                            <thead>
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
                                    <th scope='col'>Editar</th>
                                    <th scope='col'>Deletar</th>
                                </tr>
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
								<td><a href='update.php?edit=".$row["acidentes_id"]."' class='edit_btn btn btn-info' >Editar</a></td>
								<td><a href='delete.php?del=".$row["acidentes_id"]."' class='del_btn btn btn-danger' >Deletar</a></td>
								</tr>";


								
							}}?>
							  </tbody>
       						</table>
		
       		
<!--==================================================================================== -->    		




							<?php
							}

								break;
						
						
		}



					
				}else{
					header('Location:logout.php');
				}
				?>
	




















	<script type="text/javascript">
		$(document).ready(function() {
			$("#btnadd").click(function() {
				$("#form1").toggle();
			});
		});
		$(document).ready(function() {
			$("#botaoalterar").click(function() {
				$("#form2").toggle();
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