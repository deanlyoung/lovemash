<?php
function mysqlc()
{
	$con=mysql_connect("localhost","XXX","XXX");
	if(!$con)
	{
		die("Could not connect to MySQL");
	}
	mysql_select_db("thisnort_luvmash",$con) or die ("could not open database");
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
switch ($theType) {
case "text":
$theValue = ($theValue != "") ? "'" . $theValue . "'" : "''";
break;
case "long":
case "int":
$theValue = ($theValue != "") ? intval($theValue) : "''";
break;
case "double":
$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "''";
break;
case "date":
$theValue = ($theValue != "") ? "'" . $theValue . "'" : "''";
break;
case "defined":
$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
break;
}
return $theValue;
}

?>