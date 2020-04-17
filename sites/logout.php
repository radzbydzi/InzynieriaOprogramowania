<?php
	if(isLoggedIn())
	{
		$_SESSION["userId"]="";
		header('Location: index.php');
	}else{
		echo "<h3>Nie byłeś zalogowany!</h3>";
	}
?>