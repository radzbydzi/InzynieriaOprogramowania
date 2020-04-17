<?php
session_start();
//require_once("db_connect.php");
function isLoggedIn()
{
	if(isset($_SESSION["userId"]))
	{
		if($_SESSION["userId"]!="")
		{
			return true;
		}
	}
	return false;
}

function getUserId()
{
	if(isset($_SESSION["userId"]))
	{
		if($_SESSION["userId"]!="")
		{
			return $_SESSION["userId"];
		}
	}
	return null;
}
function getUserPosition()
{
	if(getUserId()!=null)
	{
		global $mysqli;
		$posCheckQuery = $mysqli->query("SELECT position FROM users WHERE `id`='".getUserId()."'");
		if(mysqli_num_rows($posCheckQuery) > 0)
		{
			$row = mysqli_fetch_assoc($posCheckQuery);
			return $row["position"];
		}else{
			return null;
		}
	}
	return null;
}

function showAccessDenied()
{
	include("siteAccessDenied.php");
	exit();
}
function postContainsNeededAndNotEmpty($neededKeys,$notEmpty)//jak nie jest potrzebne a znajduje sie w pustych to atrybut pustosci nie ma znaczenia
{
	$postNames = array_keys($_POST);
	foreach($neededKeys as $value)
	{
		$doItHasNeededKey=false;
		foreach($postNames as $postVal)
		{
			if($postVal == $value)//jesli istnieje klucz
			{
				foreach($notEmpty as $notEmptyElement)//sprawdzamy czy nie jest pustym stringiem jesli nie powinien byc
				{					
					if($notEmptyElement == $postVal)
					{
						//echo $notEmptyElement."(".$_POST[$notEmptyElement].")<br>";
						if($_POST[$notEmptyElement]=="")
						{							
							return "NotEmptyFail:".$notEmptyElement;
						}
						break;
					}
				}
				$doItHasNeededKey=true;
				break;
			}			
		}
		if($doItHasNeededKey==false)
		{
			return "NeededKeysFail:".$value;
		}
	}
	return "Good";
}
function postContainsNeeded($neededKeys)
{
	return postContainsNeededAndNotEmpty($neededKeys,array());
}
function checkPostLength($postArr, $lenArr)//0 w len to teoretyczny brak limitu
{
	if(count($postArr)!=count($lenArr))
	{
		return "ArraysCountUnequal:".count($postArr)." To ".count($lenArr);
	}else{
		for($i=0; $i<count($postArr); $i++)
		{
			if(strlen(getFieldFromPost($postArr[$i])) > $lenArr[$i] && $lenArr[$i]!=0)
			{
				return "IncorrectLengthOf:".$postArr[$i];
			}
		}
		return "Good";
	}
}

function blockDishSetsAndOrderThatUsesGiven($type, $givenId)
{
	global $mysqli;
	//block dishsets
	$dishsetQ = $mysqli->query("SELECT id,name,ingredients FROM dish_sets");
	if(mysqli_num_rows($dishsetQ) > 0)
	{
		while($row = mysqli_fetch_assoc($dishsetQ))
		{
			$json = json_decode($row["ingredients"],true);
			
			foreach($json as $jsonElem)
			{
				if($jsonElem["type"]==$type && $jsonElem["id"]==$givenId)
				{
					$idzapytania = $mysqli->query("UPDATE dish_sets SET `state`='1' WHERE `id`='".$row["id"]."'");
					if (!$idzapytania) {
						echo "<h1>Błąd SQL!</h1> <br><br>";
						die($mysqli->error);
					}
					break;
				}
			}
		}
	}
	//block order
	
	$dishsetQ = $mysqli->query("SELECT id,items FROM orders");
	if(mysqli_num_rows($dishsetQ) > 0)
	{
		while($row = mysqli_fetch_assoc($dishsetQ))
		{
			$json = json_decode($row["items"],true);
			
			foreach($json as $jsonElem)
			{
				if($jsonElem["type"]==$type && $jsonElem["id"]==$givenId)
				{
					$idzapytania = $mysqli->query("UPDATE orders SET `status`='5' WHERE `id`='".$row["id"]."'");
					if (!$idzapytania) {
						echo "<h1>Błąd SQL!</h1> <br><br>";
						die($mysqli->error);
					}
					break;
				}
			}
		}
	}
}

function test()
{
	
}
?>