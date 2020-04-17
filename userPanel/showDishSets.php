	<h1>Dania i zestawy</h1>
<?php
if(getUserPosition()!="pracownik"):
	include("siteAccessDenied.php");
else:
?>	
	<a href="?page=addDishSet" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Dodaj danie</a>
	
	<table class="table">
	<thead class="thead-dark">
	  <tr>
		<th>Id</th>
		<th>Nazwa</th>
		<th>Cena</th>
		<th>Stan</th>
		<th></th>
		<th></th>
	  </tr>
	 <thead class="thead-dark">
	 <?php
		function ingredientsSumFromDish($dishJson)
		{
			global $mysqli;
			$suma=0;
			foreach($dishJson as $jsonElem)
			{
				if($jsonElem["type"]=="i")
				{
					$ingQ = $mysqli->query("SELECT id,price FROM ingredients WHERE `id`='".$jsonElem["id"]."'");
					if(mysqli_num_rows($ingQ) > 0)
					{
						$r = mysqli_fetch_assoc($ingQ);
						$suma+= $r["price"]*$jsonElem["amount"];
					}
				}elseif($jsonElem["type"]=="d")
				{
					$dQ = $mysqli->query("SELECT id,ingredients FROM dish_sets WHERE `id`='".$jsonElem["id"]."'");
					if(mysqli_num_rows($dQ) > 0)
					{
						$r = mysqli_fetch_assoc($dQ);
						
						$json = json_decode($r["ingredients"],true);
						$suma+= ingredientsSumFromDish($json);
					}
				}
			}
			return $suma;
		}
		$ingShowQuery = $mysqli->query("SELECT id,name,ingredients,state FROM dish_sets");
		if(mysqli_num_rows($ingShowQuery) > 0)
		{
			while($row = mysqli_fetch_assoc($ingShowQuery))
			{
				
				$json = json_decode($row["ingredients"],true);				
				$suma=ingredientsSumFromDish($json);
				echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$suma."</td><td>".($row["state"]==0?"otwarty":"zablokowany")."</td><td><a href=\"?page=editDishSet&id=".$row["id"]."\" class=\"btn btn-secondary btn-lg active\" role=\"button\" aria-pressed=\"true\">Edytuj</a></td><td><a href=\"?page=editDishSet&id=".$row["id"]."\" class=\"btn btn-secondary btn-lg active\" role=\"button\" aria-pressed=\"true\">Usuń</a></td></tr>";
			}
		}else{
			echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		}
	 ?>
	</table>
<?php
	endif;
?>