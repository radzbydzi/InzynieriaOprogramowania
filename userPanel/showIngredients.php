
	<h1>Składniki</h1>
<?php
if(getUserPosition()!="pracownik"):
	include("siteAccessDenied.php");
else:
?>	
	<a href="?page=addIngredient" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Dodaj składnik</a>
	
	<table class="table">
	<thead class="thead-dark">
	  <tr>
		<th>Id</th>
		<th>Nazwa</th> 
		<th>Cena</th>
		<th></th>
		<th></th>
	  </tr>
	 <thead class="thead-dark">
	 <?php
		$ingShowQuery = $mysqli->query("SELECT id,name,price FROM ingredients");
		if(mysqli_num_rows($ingShowQuery) > 0)
		{
			while($row = mysqli_fetch_assoc($ingShowQuery))
			{
				echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["price"]."</td><td><a href=\"?page=editIngredient&id=".$row["id"]."\" class=\"btn btn-secondary btn-lg active\" role=\"button\" aria-pressed=\"true\">Edytuj</a></td><td><a href=\"?page=delIngredient&id=".$row["id"]."\" class=\"btn btn-secondary btn-lg active\" role=\"button\" aria-pressed=\"true\">Usuń</a></td></tr>";
			}
		}else{
			echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		}
	 ?>
	</table>
<?php
	endif;
?>