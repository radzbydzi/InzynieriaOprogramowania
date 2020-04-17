<?php
if(isset($_POST["inputLogin"]) && isset($_POST["inputPass"])):
	$loginCheckQuery = $mysqli->query("SELECT id FROM users WHERE `login`='".getFieldFromPost("inputLogin")."' AND `password`='".getFieldFromPostSHA1("inputPass")."'");
	if(mysqli_num_rows($loginCheckQuery) > 0)
	{
		$row = mysqli_fetch_assoc($loginCheckQuery);
		$_SESSION["userId"] = $row["id"];
		header('Location: index.php');
	}else{
		echo "<h3>Błąd logowania</h3>";
	}
else:
?>

<h3>zaloguj się</h3>
<form method="POST" action="?page=login">
<div class="form-group row">
	<label for="loginLabel" class="col-sm-2 col-form-label">Login</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" name="inputLogin" placeholder="Login">
	</div>
</div>
<div class="form-group row">
	<label for="inputPassword3" class="col-sm-2 col-form-label">Hasło</label>
	<div class="col-sm-10">
		<input type="password" class="form-control" name="inputPass" placeholder="Hasło">
	</div>
</div>
	<p></p>
	<button type="submit" class="btn btn-primary">Zaloguj</button>
</form>
<?php
endif;
?>