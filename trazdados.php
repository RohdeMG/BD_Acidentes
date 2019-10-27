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





<div class="col-md-8 col-sm-6 col-xs-12">
	<h3>Filtros:</h3>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<form action="?" method="post">
					<div class="form-group">
						<select class="form-control" name="filtroConcelho" placeholder="Concelho" required="">
			<?php
			$query = 'SELECT DISTINCT "Concelho" FROM info ORDER BY "Concelho" ASC';
			$result = pg_query($query);

			while ($row = pg_fetch_array($result)) {
				echo '<option>'.$row["Concelho"].'</option>'; 
			}?>
						</select>
					</div>  

					<input type="number" class="form-control" name="filtroMortos"  min="0" max="50" placeholder="Mortos" required="">
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
			<input type="text" class="form-control" name="addConcelho" placeholder="Concelho">
			<input type="number" class="form-control" name="addMortos" placeholder="Mortos">
			<input type="number" class="form-control" name="addFeridos" placeholder="Feridos Graves">
			<input type="text" class="form-control" name="addVia" placeholder="Via">
			<input type="text" class="form-control" name="addKm" placeholder="Km">
			<input type="text" class="form-control" name="addNatureza" placeholder="Natureza">
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
							$addMortos= '\''.$_POST["addMortos"].'\'';
							$addFeridos= '\''.$_POST["addFeridos"].'\'';
							$addVia= '\''.$_POST["addVia"].'\'';
							$addKm= '\''.$_POST["addKm"].'\'';
							$addNatureza= '\''.$_POST["addNatureza"].'\'';

							$query = 'INSERT INTO info ("Concelho","M","FG","Via","Km","Natureza") VALUES('.$addConcelho.','.$addMortos.','.$addFeridos.','.$addVia.','.$addKm.','.$addNatureza.');';
							$result = pg_query($query);
						}
						break;





						case 2: // grupo 2
						if(isset($_POST['filtro'])){
							$filtroConcelho= '\''.$_POST["filtroConcelho"].'\'';
							$filtroMortos= '\''.$_POST["filtroMortos"].'\'';
							$filtroFeridos= '\''.$_POST["filtroFeridos"].'\'';


							// if(isset($_POST["filtroConcelho"])){
							// 	$conceadd = ''.$filtroConcelho.' AND ';
							// }

							// if(isset($_POST["filtroMortos"])){
							// 	$moradd = ''.$filtroMortos.' AND ';
							// }

							// if(isset($_POST["filtroFeridos"])){
							// 	$feriadd = ''.$filtroFeridos.'';
							// }



							$queryfiltro = 'SELECT * FROM info WHERE "Concelho" ='.$filtroConcelho.' AND "M" = '.$filtroMortos.'AND "FG" = '.$filtroFeridos.';';
							echo $queryfiltro;
							$result = pg_query($queryfiltro);
							if($result < 1){
								echo "Nenhuma ocorrência encontrada.";
							}else{
							echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th scope='col'>Concelho</th>
                                    <th scope='col'>Datahora</th>
                                    <th scope='col'>M</th>
                                    <th scope='col'>FG</th>
                                    <th scope='col'>Via</th>
                                    <th scope='col'>Km</th>
                                    <th scope='col'>Natureza</th>
                                </tr>
                            </thead>
                            <tbody>";

							while ($row = pg_fetch_array($result)) {
								echo "<tr>
								<td>" . $row["Concelho"]. "</td>
								<td>" . $row["Datahora"]. "</td>
								<td>" . $row["M"]. "</td>
								<td>" . $row["FG"]. "</td>
								<td>" . $row["Km"]. "</td>
								<td>" . $row["Via"]. "</td>
								<td>" . $row["Natureza"]. "</td>
								</tr>";
							}}?>
							  </tbody>
       						</table>
							<?php
								break;
						}
						
					

						case 3: //grupo 3
						
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
	</script>