<?php
$mysqli = null;
function getFieldFromPost($fieldName)
{
	global $mysqli;
	if($mysqli==null || !isset($_POST[$fieldName]))
	{
		return "";
	}else{
		return $mysqli->real_escape_string($_POST[$fieldName]);
	}
}
function getFieldFromPostWithQuote($fieldName)
{
	return "'".getFieldFromPost($fieldName)."'";
}
function getFieldFromPostSHA1($fieldName)
{
	return sha1(getFieldFromPost($fieldName));
}
function getFieldFromPostSHA1WithQuote($fieldName)
{
	return "'".sha1(getFieldFromPost($fieldName))."'";
}
if(!file_exists("config_scripts/db_connect_data.php"))
{
	header('Location: ../config_scripts/init.php');
	exit();
}else
{
	require_once("config_scripts/db_connect_data.php");
	$mysqli = new mysqli($dbAddress, $dbUserName, $dbUserPassword,$dbName);
	/* check connection */
	if ($mysqli->connect_errno) {
		printf("<h1>Connect failed: %s\n</h1>", $mysqli->connect_error);
		exit();
	}
}

?>