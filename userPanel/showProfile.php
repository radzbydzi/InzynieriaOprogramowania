<h3>Mój profil</h3>
<?php
//oba nie mogą być puste
$changePasswordNeeded = array("inputPassOld", "inputPassNew");
//$lenCheck = explode(":",checkPostLength($neededPosts,$allowedLengthPost));
//$neededPosts = array(     "inputLogin","inputPass","inputName","inputLastname","inputCity","inputZip","inputStreet","inputHouse","inputApartment","inputNumber","inputQuestions","inputAnswer","gridCheck");
//$allowedLengthPost = array(30,          0,          35,         40,             9,          20,        10,           35,          15,              15,           150,             150,          0);
//gdy nie ma odpowiedzi zmiana pytania nie ma znaczenia. imie nazwisko i numer muszą byc wypelnione
$changeDataNeeded = array("inputName", "inputLastname", "inputNumber", "inputQuestions", "inputAnswer");
$allowedDataLength = array (35,40,15,150,150);
$changeDataNotEmpty = array("inputName", "inputLastname", "inputNumber");

//nic nie jest obowiazkowe
$changeAddressNeeded = array("inputCity",  "inputZip", "inputStreet", "inputHouse", "inputApartment");
$allowedAddressLength = array (9,20,10,35,15);

//---------------------
$checkResultPassword = explode(":",postContainsNeededAndNotEmpty($changePasswordNeeded, $changePasswordNeeded));
$checkResultData = explode(":",postContainsNeededAndNotEmpty($changeDataNeeded, $changeDataNotEmpty));
$checkResultAddress = explode(":",postContainsNeeded($changeAddressNeeded));
//----------------------


if($checkResultPassword[0]=="Good"):
	$checkForExistQuery = $mysqli->query("SELECT login FROM users WHERE `id`='".getUserId()."' AND `password`='".sha1(getFieldFromPost("inputPassOld"))."'");
	if(mysqli_num_rows($checkForExistQuery) <= 0)
	{
		echo "<h3>Stare hasło błędne!</h3>";
	}
	else{
		$idzapytania = $mysqli->query("UPDATE users SET `password`='".getFieldFromPostSHA1("inputPassNew")."' WHERE `id`='".getUserId()."' ");
					
		if (!$idzapytania) {
			echo "<h1>Błąd SQL!</h1> <br><br>";
			die($mysqli->error);
		}else{
			echo "<h3>Pomyślnie zmieniono hasło</h3>";
		}
	}
elseif($checkResultData[0]=="Good"):
	$lenCheck = explode(":",checkPostLength($changeDataNeeded,$allowedDataLength));
	if($lenCheck[0]=="Good")
	{
		$updQuestionVal ="";
		if(getFieldFromPost("inputQuestions") != "" && getFieldFromPost("inputAnswer") != "")
		{
			$updQuestionVal = " , `question`='".getFieldFromPost("inputQuestions")."' , `answer`='".getFieldFromPostSHA1("inputAnswer")."'";
		}
		
		$queryString = "UPDATE users SET `name`='".getFieldFromPost("inputName")."' , `lastname`='".getFieldFromPost("inputLastname")."' , `phone`='".getFieldFromPost("inputNumber")."'".$updQuestionVal." WHERE `id`='".getUserId()."'";
		echo $queryString;
		$idzapytania = $mysqli->query($queryString);
		if (!$idzapytania) {
			echo "<h1>Błąd SQL!</h1> <br><br>";
			die($mysqli->error);
		}else{
			echo "<h3>Pomyślnie zmieniono dane</h3>";
		}
	}else{
		if($lenCheck[0]=="ArraysCountUnequal")
			echo "<h3>Nierówne tablice: ".$lenCheck[1]."</h3>";
		else
			echo "<h3>Nieprawidłowa długość pola: ".$lenCheck[1]."</h3>";
	}
	
elseif($checkResultAddress[0]=="Good"):
	$lenCheck = explode(":",checkPostLength($changeAddressNeeded,$allowedAddressLength));
	if($lenCheck[0]=="Good")
	{
		$queryString = "UPDATE users SET `city`='".getFieldFromPost("inputCity")."' , `zipCode`='".getFieldFromPost("inputZip")."' , `street`='".getFieldFromPost("inputStreet")."' , `houseNumber`='".getFieldFromPost("inputHouse")."' , `apartmentNumber`='".getFieldFromPost("inputApartment")."' WHERE `id`='".getUserId()."' ";
		$idzapytania = $mysqli->query($queryString);
		if (!$idzapytania) {
			echo "<h1>Błąd SQL!</h1> <br><br>";
			die($mysqli->error);
		}else{
			echo "<h3>Pomyślnie zmieniono adres</h3>";
		}
	}else{
		if($lenCheck[0]=="ArraysCountUnequal")
			echo "<h3>Nierówne tablice: ".$lenCheck[1]."</h3>";
		else
			echo "<h3>Nieprawidłowa długość pola: ".$lenCheck[1]."</h3>";
	}
else:
	$currentUserData = $mysqli->query("SELECT * FROM users WHERE `id`='".getUserId()."'");
	if(mysqli_num_rows($currentUserData) <= 0):
		echo "<h3>Użytkownik o podanym id nie istnieje</h3>";
	else:
		$row = mysqli_fetch_assoc($currentUserData);
?>
	
	<div class="form-group row">
		<label for="inputLogin" class="col-sm-2 col-form-label">Login</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputLogin" name="inputLogin"  value="<?php echo $row["login"];?>" disabled>
		</div>
	</div>
	<form method="POST" action="?page=showProfile">
	<h5>Zmień hasło</h5>
	<div class="form-group row">
		<label for="inputPassword" class="col-sm-2 col-form-label">Stare hasło</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="inputPass" name="inputPassOld">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputPassword" class="col-sm-2 col-form-label">Nowe hasło</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="inputPass" name="inputPassNew">
		</div>
	</div>
		<button type="submit" class="btn btn-primary">Zmień</button>
	</form>
	<hr>
	<h5>Zmień dane</h5>
	<form method="POST" action="?page=showProfile">
	<div class="form-group row">
		<label for="inputName" class="col-sm-2 col-form-label">Imię</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo $row["name"];?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="inputLastname" class="col-sm-2 col-form-label">Nazwisko</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputLastname" name="inputLastname" value="<?php echo $row["lastname"];?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="inputText" class="col-sm-2 col-form-label">Numer kontaktowy</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputNumber" name="inputNumber" value="<?php echo $row["phone"];?>">
		</div>
	</div>
		<div class="form-group row">
		<label for="inputText" class="col-sm-2 col-form-label">Pytanie resetujące hasło</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputQuestions" name="inputQuestions" value="<?php echo $row["question"];?>">
		</div>
	</div>
		<div class="form-group row">
		<label for="inputText" class="col-sm-2 col-form-label">Odpowiedź na pytanie</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputAnswer" name="inputAnswer" >
		</div>
	</div>
	<button type="submit" class="btn btn-primary">Zmień</button>
	</form>
	<hr>
	<h5>Zmień adres</h5>
	<form method="POST" action="?page=showProfile">
	
	
	<div class="form-group row">
		<label for="inputCity" class="col-sm-2 col-form-label">Miasto</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputCity" name="inputCity" value="<?php echo $row["city"];?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputZip" class="col-sm-2 col-form-label">Kod Pocztowy</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputZip" name="inputZip" value="<?php echo $row["zipCode"];?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputStreet" class="col-sm-2 col-form-label">Ulica</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputStreet" name="inputStreet" value="<?php echo $row["street"];?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputHouse" class="col-sm-2 col-form-label">Numer domu</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputHouse" name="inputHouse" value="<?php echo $row["houseNumber"];?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputApartment" class="col-sm-2 col-form-label">Numer mieszkania</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputApartment" name="inputApartment" value="<?php echo $row["apartmentNumber"];?>">
		</div>
	</div>
		<button type="submit" class="btn btn-primary">Zmień</button>
	</form>
<?php
	endif;
endif;
?>