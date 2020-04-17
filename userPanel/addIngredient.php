<h3>Dodaj składnik</h3>
<?php
if(getUserPosition()!="pracownik"):
	include("siteAccessDenied.php");
else:

$neededPosts = array("inputName","inputPrice");
$allowedLengthPost = array(30, 10);
$checkResult = explode(":",postContainsNeededAndNotEmpty($neededPosts, $neededPosts));
if($checkResult[0]=="Good"):
	$checkForExistQuery = $mysqli->query("SELECT name FROM ingredients WHERE `name`='".getFieldFromPost("inputName")."'");
	if(mysqli_num_rows($checkForExistQuery) > 0)
	{
		echo "<h3>Składnik o podanej nazwie już istnieje!</h3>";
	}
	else{
		$idzapytania = $mysqli->query("INSERT INTO ingredients(`name`,`price`) VALUES ("
					.getFieldFromPostWithQuote("inputName").", "
					.getFieldFromPostWithQuote("inputPrice")
					.")");
					
		if (!$idzapytania) {
			echo "<h1>Błąd SQL!</h1> <br><br>";
			die($mysqli->error);
		}else{
			echo "<h3>Składnik został dodany!</h3>";
		}
		
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
?>
<form method="POST" action="panel.php?page=addIngredient">
<div class="form-group row">
	<label for="inputName" class="col-sm-2 col-form-label">Nazwa*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nazwa" required maxlength="30" required>
	</div>
</div>
<div class="form-group row">
	<label for="inputPrice" class="col-sm-2 col-form-label">Cena*</label>
	<div class="col-sm-10">
		<input type="number" step="0.01" class="form-control" id="inputPrice" name="inputPrice" placeholder="Cena" required>
	</div>
</div>
	<button type="submit" class="btn btn-primary">Dodaj</button>
</form>
<?php
endif;
endif;
?>