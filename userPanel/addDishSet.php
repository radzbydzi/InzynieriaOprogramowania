<h3>Dodaj danie</h3>
<?php
if(getUserPosition()!="pracownik"):
	include("siteAccessDenied.php");
else:

 
if(
	isset($_POST["inputTypes"]) && isset($_POST["inputNames"]) && isset($_POST["inputAmounts"])  &&
	(count($_POST["inputTypes"]) == count($_POST["inputNames"]) == count($_POST["inputAmounts"]))
	):
	
	$arrRes = array();
	for($i=0; $i<count($_POST["inputTypes"]); $i++)
	{
		$arrRes[count($arrRes)] = array( "type"=>$mysqli->real_escape_string($_POST["inputTypes"][$i]), $mysqli->real_escape_string($_POST["inputNames"][$i]), $mysqli->real_escape_string($_POST["inputAmounts"][$i]));
	}
	
	$jsonSave = json_encode($arrRes);
	
	$idzapytania = $mysqli->query("INSERT INTO dish_sets(`name`,`ingredients`,`state`) VALUES ("
					"'".$mysqli->real_escape_string($_POST["inputName"]).", "
					"'".$jsonSave.", "
					."'0'"
					.")");
					
	if (!$idzapytania) {
		echo "<h1>Błąd SQL!</h1> <br><br>";
		die($mysqli->error);
	}else{
		echo "<h3>Danie zostało dodane!</h3>";
	}

else:
	echo "<h3>Błąd</h3>";
?>

<?php
//ingredients to JSON visible in js
	$ingQ = $mysqli->query("SELECT * FROM ingredients");
	$ingArray = array();
	while($row = mysqli_fetch_assoc($ingQ))
	{
		$elArr = array("id"=>$row["id"],"name"=>$row["name"]);		
		$ingArray[count($ingArray)]=$elArr;
	}
	echo "<script> var ing = JSON.parse('".json_encode($ingArray)."')</script>";
	
	$dQ = $mysqli->query("SELECT * FROM dish_sets");
	$dArray = array();
	while($row = mysqli_fetch_assoc($dQ))
	{
		$elArr = array("id"=>$row["id"],"name"=>$row["name"]);		
		$dArray[count($dArray)]=$elArr;
	}
	echo "<script> var dish = JSON.parse('".json_encode($dArray)."')</script>";
?>
<script>
	console.log(ing);
	console.log(dish);
</script>

<div class="form-group row">
    <label for="inputType">Rodzaj</label>
    <select id="inputType" name="inputType" class="form-control" onchange="changeItemsSelect()" required>
		<option value="i" selected>składniki</option>
        <option value="d">dania</option>
    </select>
</div>
<div class="form-group row">
    <label for="inputElement">Element</label>
    <select id="inputElement" name="inputElement" class="form-control" required >
		
    </select>
</div>
<div class="form-group row">
	<label for="inputAmount" class="col-sm-2 col-form-label">Ilość</label>
	<div class="col-sm-10">
		<input type="number" step="1" min="1" value="1" class="form-control" id="inputAmount" name="inputAmount" required>
		
	</div>
</div>

<p onclick="addToTable()" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Dodaj element</p>

<hr>

<form method="POST" action="panel.php?page=addDishSet">
<div class="form-group row">
	<label for="inputDishName" class="col-sm-2 col-form-label">Nazwa dania*</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="inputDishName" name="inputDishName" placeholder="Nazwa Dania" required maxlength="30">
	</div>
</div>
<button type="submit" class="btn btn-primary">Utwórz danie</button>


<table class="table" id="interior">
		<tr><td>-</td><td>-</td><td>-</td><td>-</td></tr>
</table>
	
</form>

<script>
	var tableContent = [];
	function changeItemsSelect()
	{
		var type= document.getElementById("inputType");
		var selectedOption = type.options[type.selectedIndex].text;
		
		var insideElement= document.getElementById("inputElement");
		insideElement.innerHTML="";
		if(selectedOption=="składniki")
		{
			for(x of ing)
			{
				insideElement.innerHTML+="<option value='"+x["id"]+"'>"+x["name"]+"</option>";
			}
		}else if(selectedOption=="dania")
		{
			for(x of dish)
			{
				insideElement.innerHTML+="<option value='"+x["id"]+"'>"+x["name"]+"</option>";
			}
		}
	}
	changeItemsSelect();
	
	function addToTable(){
		var t1=document.getElementById("inputType");
		var type = t1.options[t1.selectedIndex];
		var i1=document.getElementById("inputElement");
		var element = i1.options[i1.selectedIndex];
		var amount = document.getElementById("inputAmount").value;
		tableContent[tableContent.length]=[type.value, element.value, amount];
		
		refreshTable();
	}
	
	function delFromTable(id){
		tableContent.splice(id, 1);
		
		refreshTable();
	}
	
	function refreshTable(){
		var interior = document.getElementById("interior");
		interior.innerHTML="<thead class=\"thead-dark\"><tr><th>Typ</th><th>Nazwa</th> <th>Ilość</th><th></th></tr></thead>";
		
		for(x in tableContent)
		{
			interior.innerHTML+="<tr>"
								+"<td><input type=\"text\" class=\"form-control\" name=\"inputTypes[]\" required readonly value=\""+tableContent[x][0]+"\"></td>"
								+"<td><input type=\"text\" class=\"form-control\" name=\"inputNames[]\" required readonly value=\""+tableContent[x][1]+"\"></td>"
								+"<td><input type=\"text\" class=\"form-control\" name=\"inputAmounts[]\" required readonly value=\""+tableContent[x][2]+"\"></td>"
								+"<td><p onclick=\"delFromTable("+x+");\" class=\"btn btn-secondary btn-lg active\" role=\"button\" aria-pressed=\"true\">Usuń</p></td>"
								+"<tr>";
		}
	}
</script>
<?php
endif;
endif;
?>