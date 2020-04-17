
	<h1>Użytkownicy</h1>
<?php
if(getUserPosition()!="pracownik"):
	include("siteAccessDenied.php");
else:
?>	
	<a href="?page=addUser" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Dodaj użytkownika</a>
	
	<table class="table">
	<thead class="thead-dark">
	  <tr>
		<th>Id</th>
		<th>Login</th> 
		<th>Imię</th>
		<th>Nazwisko</th>
		<th>Numer Telefonu</th>
		<th>Pozycja</th>
		<th></th>
	  </tr>
	 <thead class="thead-dark">
	 <?php
		$userShowQuery = $mysqli->query("SELECT id,login,name,lastname,phone,position FROM users");
		if(mysqli_num_rows($userShowQuery) > 0)
		{
			while($row = mysqli_fetch_assoc($userShowQuery))
			{
				echo "<tr><td>".$row["id"]."</td><td>".$row["login"]."</td><td>".$row["name"]."</td><td>".$row["lastname"]."</td><td>".$row["phone"]."</td><td>".$row["position"]."</td><td><a href=\"?page=delUser&id=".$row["id"]."\" class=\"btn btn-secondary btn-lg active\" role=\"button\" aria-pressed=\"true\">Usuń</a></td></tr>";
			}
		}else{
			echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		}
	 ?>
	</table>
<?php
	endif;
?>