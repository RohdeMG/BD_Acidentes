	<?php
	require_once("header.php");
	require_once("validacao.php");

	if(isset($_SESSION)){
	  //var_dump($_SESSION);
	?>


	<div class="col-md-6 col-sm-6 col-xs-12 pull-left"><h3>Olá, <?php echo $_SESSION["UsuarioNome"];?></h3></div>
	
	<div class="col-md-6 col-sm-6 col-xs-12 text-right"><a class="btn btn-primary" href="logout.php">Sair</a></div>

<div class="col-md-6 col-sm-6 col-xs-12">
<h2>Filtros:</h2>
<form>
  <div class="form-group col-md-2">
    <label for="exampleFormControlSelect1">Ano:</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option></option>
    </select>
  </div>
</form>
<form>
  <div class="form-group col-md-3">
    <label for="exampleFormControlSelect1">Concelho:</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option></option>
    </select>
  </div>
</form>
</div>




	<div class="col-md-10 col-sm-8 col-xs-12 text-center">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th scope="col">Concelho</th>
					<th scope="col">Datahora</th>
					<th scope="col">M</th>
					<th scope="col">FG</th>
					<th scope="col">Via</th>
					<th scope="col">Km</th>
					<th scope="col">Natureza</th>
				</tr>
			</thead>
			<tbody>

				<?php
				switch ($_SESSION["UsuarioPermissao"]) {
					case 1: // permissao 1
					$query = 'SELECT * FROM info';
					$result = pg_query($query);
					while ($line = pg_fetch_array($result)) {
					echo "<tr>
					<td>" . $line['Concelho'] . "</td>
					<td>" . $line['Datahora'] . "</td>
					</tr>";
					}
					break;
					
					case 2: // permissao 2
					$query = 'SELECT * FROM info';
					$result = pg_query($query);
					while ($line = pg_fetch_array($result)) {
					echo "<tr>
					<td>" . $line['Concelho'] . "</td>
					<td>" . $line['Datahora'] . "</td>
					<td>" . $line['M'] . "</td>
					<td>" . $line['FG'] . "</td>
					<td>" . $line['Via'] . "</td>
					<td>" . $line['Km'] . "</td>
					<td>" . $line['Natureza'] . "</td>
					</tr>";
				}
					break;

				}
				
	}else{
		header('Location:logout.php');
	}
				?>
			</tbody>
		</table>
	</div>