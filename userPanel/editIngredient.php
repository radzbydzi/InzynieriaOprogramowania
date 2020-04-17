<h3>Edytuj składnik</h3>
<?php
	if(getUserPosition()!="pracownik"):
		include("siteAccessDenied.php");
	else:

	$neededPosts = array("inputName","inputPrice");
	$allowedLengthPost = array(30, 10);
	$checkResult = explode(":",postContainsNeededAndNotEmpty($neededPosts, $neededPosts));
	if($checkResult[0]=="Good"):
		if(isset($_GET["id"]))
		{
			$checkForExistQuery = $mysqli->query("SELECT name FROM ingredients WHERE `name`='".getFieldFromPost("inputName")."' AND `id` != '".$mysqli->real_escape_string($_GET["id"])."'");
			if (!$checkForExistQuery) {
				echo "<h1>Błąd SQL!</h1> <br><br>";
				die($mysqli->error);
			}
			
			
			if(mysqli_num_rows($checkForExistQuery) > 0)
			{
				echo "<h3>Składnik o podanej nazwie już istnieje!</h3>";
			}
			else{
				
					$idzapytania = $mysqli->query("UPDATE ingredients SET "
							."`name`=".getFieldFromPostWithQuote("inputName").", "
							."`price`=".getFieldFromPostWithQuote("inputPrice")
							."WHERE `id`='".$mysqli->real_escape_string($_GET["id"])."'");
							
					if (!$idzapytania) {
						echo "<h1>Błąd SQL!</h1> <br><br>";
						die($mysqli->error);
					}else{
						echo "<h3>Składnik został zmieniony!</h3>";
					}
				
				
				
			}
		}else
		{
			echo "<h3>Nie przesłano id!</h3>";
		}
	else:
		if($checkResult[0]=="NeededKeyFail")
		{
			echo "<h3>Brak wymaganego pola: ".$checkResult[1]."</h3>";
		}
		else if($checkResult[0]=="NotEmptyFail")
		{
			echo "<h3>To pole nie może być puste: ".$checkResult[1]."</h3>";
		}
		
		$currentIngredientData = $mysqli->query("SELECT * FROM ingredients WHERE `id`='".$mysqli->real_escape_string($_GET["id"])."'");
		if(mysqli_num_rows($currentIngredientData) <= 0):
			echo "<h3>Składnik o podanym id nie istnieje</h3>";
		else:
			$row = mysqli_fetch_assoc($currentIngredientData);
?>
	<form method="POST" action="panel.php?page=editIngredient&id=<?php echo $_GET["id"];?>">
	<div class="form-group row">
		<label for="inputName" class="col-sm-2 col-form-label">Nazwa*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nazwa" required maxlength="30" required value="<?php echo $row["name"];?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputPrice" class="col-sm-2 col-form-label">Cena*</label>
		<div class="col-sm-10">
			<input type="number" step="0.01" class="form-control" id="inputPrice" name="inputPrice" placeholder="Cena" required value="<?php echo $row["price"];?>">
		</div>
	</div>
		<button type="submit" class="btn btn-primary">Zmień</button>
	</form>
<?php
	endif;
	endif;
endif;
?>