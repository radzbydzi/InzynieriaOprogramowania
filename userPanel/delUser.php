<h1>Usuwanie użytkownika</h1>
<?php
if(getUserPosition()!="pracownik"):
	include("siteAccessDenied.php");
else:
	if(!isset($_GET["id"]))
	{
		echo "<h3>Nie przesłano id!</h3>";
	}else if($_GET["id"]=="")
	{
		echo "<h3>id musi być ciągiem</h3>";
	}
	else{
		$userShowQuery = $mysqli->query("DELETE FROM users WHERE `id`='".$mysqli->real_escape_string($_GET["id"])."'");
		if (!$userShowQuery) {
			echo "<h1>Błąd SQL!</h1> <br><br>";
			die($mysqli->error);
		}else{
			echo "<h3>Użytkownik usunięty poprawnie!</h3>";
		}
	}
endif;
?>