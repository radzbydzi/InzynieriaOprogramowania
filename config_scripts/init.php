<html>
	<head>
		<meta charset="utf-8">
		<!-- Bootstrap -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<title>Pizzeria</title>
	</head>
	<body>
		
		<div class="container">
			<div class="jumbotron">
				<h1 class="display-4">Konfiguracja bazy danych</h1>
				<p class="lead">Podaj wymagane dane do bazy danych</p>
				
				<hr class="my-4">
				<?php
					if(file_exists("db_connect_data.php"))//if PHP file with variables containing database connection data exists 
					{
						echo "<h3>Baza danych jest już skonfigurowana.</h3>";//db configureted before notification
					}else{
						if(isset($_POST["addressInput"]) && isset($_POST["userInput"]) && isset($_POST["passInput"]) && isset($_POST["dbnameInput"]))//if every of field are filled or empty but exists
						{
							if($_POST["addressInput"]=="" || $_POST["userInput"]=="" || $_POST["dbnameInput"]=="")//if one or more of fields that should not be empty string are empty
							{
								if($_POST["addressInput"]=="")
								{
									echo "<h3>Adres serwera nie może być pusty</h3>";
								}
								if($_POST["userInput"]=="")
								{
									echo "<h3>Użytkownik bazy danych nie może być pusty</h3>";
								}
								if($_POST["dbnameInput"]=="")
								{
									echo "<h3>Nazwa bazy danych nie może być pusta</h3>";
								}
							}else{//if everything is good
								$stringToBeSaved = "<?php\n
													    \$dbAddress='".htmlspecialchars($_POST["addressInput"])."';\n
													    \$dbUserName='".htmlspecialchars($_POST["userInput"])."';\n
													    \$dbUserPassword='".htmlspecialchars($_POST["passInput"])."';\n
													    \$dbName='".htmlspecialchars($_POST["dbnameInput"])."';\n
													?>";
								$myfile = fopen("db_connect_data.php", "w") or die("Nie można otworzyć pliku db_connect_data.php!");
								fwrite($myfile, $stringToBeSaved);
								fclose($myfile);
								
								$mysqli = new mysqli(htmlspecialchars($_POST["addressInput"]),htmlspecialchars($_POST["userInput"]),htmlspecialchars($_POST["passInput"]),htmlspecialchars($_POST["dbnameInput"]));

								if ($mysqli -> connect_errno) {
								  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
								  exit();
								}
								$sql = file_get_contents('base.sql');
								
								$idzapytania = $mysqli -> multi_query($sql);
								if (!$idzapytania) {
									echo "<h1>Błąd SQL!</h1> <br><br>";
									die($mysqli->error);
								}
								
								echo "<h4>Zapisano zmiany. Możesz ponownie wczytać index.php</h4>";
							}
						}else{//if one or more field was not sent
							echo '<form method="POST" action="#">
								  <div class="form-group">
									<label for="addressLabel">Adres bazy danych</label>
									<input type="text" class="form-control" name="addressInput">
								  </div>
								  <div class="form-group">
									<label for="userLabel">Użytkownik</label>
									<input type="text" class="form-control" name="userInput">
								  </div>
								  <div class="form-group">
									<label for="passLabel">Hasło</label>
									<input type="password" class="form-control" name="passInput">
								  </div>
								  <div class="form-group">
									<label for="dbnameLabel">Nazwa bazy danych</label>
									<input type="text" class="form-control" name="dbnameInput">
								  </div>				  
								  <div class="form-group form-check">
									<input type="checkbox" class="form-check-input" name="fillCheck">
									<label class="form-check-label" for="fillCheckLabel">Wypełnić przykładowymi danymi?</label>
								  </div>
								  <button type="submit" class="btn btn-primary">Submit</button>
								</form>';
						}
						
					}
					
				?>
				
				
			</div>
		</div>
		
		
		
		
		<!-- Bootstrap -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>