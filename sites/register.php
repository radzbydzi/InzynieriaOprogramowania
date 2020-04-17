<h3>Zarejestruj się</h3>
<?php
$neededPosts = array("inputLogin","inputPass","inputName","inputLastname","inputCity","inputZip","inputStreet","inputHouse","inputApartment","inputNumber","inputQuestions","inputAnswer","gridCheck");
$allowedLengthPost = array(30, 0, 35, 40, 9, 20, 10, 35, 15, 15, 150, 150,0);
$notEmptyPosts = array("inputLogin","inputPass","inputName", "inputLastname", "inputNumber", "inputQuestions","inputAnswer");
$checkResult = explode(":",postContainsNeededAndNotEmpty($neededPosts, $notEmptyPosts));
if($checkResult[0]=="Good"):
	$lenCheck = explode(":",checkPostLength($neededPosts,$allowedLengthPost));
	if($lenCheck[0]=="Good")
	{
		$checkForExistQuery = $mysqli->query("SELECT login FROM users WHERE `login`='".getFieldFromPost("inputLogin")."'");
		if(mysqli_num_rows($checkForExistQuery) > 0)
		{
			echo "<h3>Login już istnieje. Wybierz inny!</h3>";
		}
		else{
			$idzapytania = $mysqli->query("INSERT INTO users(`login`,`password`,`name`,`lastname`,`phone`,`question`,`answer`,`position`, `city`, `street`, `houseNumber`, `apartmentNumber`, `zipCode`) VALUES ("
						.getFieldFromPostWithQuote("inputLogin").", "
						.getFieldFromPostSHA1WithQuote("inputPass").", "
						.getFieldFromPostWithQuote("inputName").", "
						.getFieldFromPostWithQuote("inputLastname").", "
						.getFieldFromPostWithQuote("inputNumber").", "
						.getFieldFromPostWithQuote("inputQuestions").", "
						.getFieldFromPostSHA1WithQuote("inputAnswer").", "
						."'klient', "
						.getFieldFromPostWithQuote("inputCity").", "
						.getFieldFromPostWithQuote("inputStreet").", "
						.getFieldFromPostWithQuote("inputHouse").", "
						.getFieldFromPostWithQuote("inputApartment").", "
						.getFieldFromPostWithQuote("inputZip")." "
						.")");
						
			if (!$idzapytania) {
				echo "<h1>Błąd SQL!</h1> <br><br>";
				die($mysqli->error);
			}else{
				echo "<h3>Użytkownik założony! Możesz teraz się zalogować!</h3>";
			}
		}
	}else{
		if($lenCheck[0]=="ArraysCountUnequal")
			echo "<h3>Nierówne tablice: ".$lenCheck[1]."</h3>";
		else
			echo "<h3>Nieprawidłowa długość pola: ".$lenCheck[1]."</h3>";
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
<form method="POST" action="?page=register">
<div class="form-group row">
	<label for="inputLogin" class="col-sm-2 col-form-label">Login*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputLogin" name="inputLogin" placeholder="Login" required maxlength="30">
	</div>
</div>
<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label">Hasło*</label>
	<div class="col-sm-10">
		<input type="password" class="form-control" id="inputPass" name="inputPass" placeholder="Hasło" required>
	</div>
</div>
<div class="form-group row">
	<label for="inputName" class="col-sm-2 col-form-label">Imię*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputName" name="inputName" placeholder="Imię" required maxlength="35">
	</div>
</div>
<div class="form-group row">
	<label for="inputLastname" class="col-sm-2 col-form-label">Nazwisko*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputLastname" name="inputLastname" placeholder="Nazwisko" required maxlength="40">
	</div>
</div>
<div class="form-group row">
	<label for="inputText" class="col-sm-2 col-form-label">Numer kontaktowy*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputNumber" name="inputNumber" placeholder="Numer Kontaktowy" required maxlength="9">
	</div>
</div>
<div class="form-group row">
	<label for="inputCity" class="col-sm-2 col-form-label">Miasto</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="Miasto" maxlength="20">
	</div>
</div>
<div class="form-group row">
	<label for="inputZip" class="col-sm-2 col-form-label">Kod Pocztowy</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputZip" name="inputZip" placeholder="Kod pocztowy" maxlength="10">
	</div>
</div>
<div class="form-group row">
	<label for="inputStreet" class="col-sm-2 col-form-label">Ulica</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputStreet" name="inputStreet" placeholder="Ulica" maxlength="35">
	</div>
</div>
<div class="form-group row">
	<label for="inputHouse" class="col-sm-2 col-form-label">Numer domu</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputHouse" name="inputHouse" placeholder="Numer domu" maxlength="15">
	</div>
</div>
<div class="form-group row">
	<label for="inputApartment" class="col-sm-2 col-form-label">Numer mieszkania</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputApartment" name="inputApartment" placeholder="Numer mieszkania" maxlength="15">
	</div>
</div>

	<div class="form-group row">
	<label for="inputText" class="col-sm-2 col-form-label">Pytanie resetujące hasło*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputQuestions" name="inputQuestions" placeholder="Pytanie" maxlength="150" required>
	</div>
</div>
	<div class="form-group row">
	<label for="inputText" class="col-sm-2 col-form-label">Odpowiedź na pytanie*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputAnswer" name="inputAnswer" placeholder="Odpowiedź" maxlength="150" required>
	</div>
</div>
<div class="form-group">
	<div class="form-check">
		<input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck">
		<label class="form-check-label" for="gridCheck">
			Jestem świadomy założenia konta oraz akceptuję regulamin
		</label>
	</div>
</div>
<p>*Pola obowiązkowe</p>
KOD PATCHA DODAĆ!!! Bo spam
<p></p>
	<button type="submit" class="btn btn-primary">Utwórz konto</button>
</form>
<?php
endif;
?>