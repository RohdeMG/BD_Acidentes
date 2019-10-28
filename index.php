	<?php
	require_once("header.php");
	?>
	<div class="col-md-12 col-xs-12">
	       <div class="login">
				<h1>Proteção Civil</h1>
				<form action="validacao.php" method="post">
					<label for="username">
						<i class="fas fa-user"></i>
					</label>
					<input type="text" name="username" placeholder="Username" id="username" required>
					<label for="palavrapasse">
						<i class="fas fa-lock"></i>
					</label>
					<input type="password" name="palavrapasse" placeholder="Password" id="palavrapasse" required>
					<input type="submit" name="clicou" value="Login">
				</form>
			</div>
	  
	</div>
	</body>
	</html>