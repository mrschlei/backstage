<?php

if(!extension_loaded("oci8"))
	{
	if(!dl("oci8.so")) { exit("Cannot load oci8 extension"); }
	}

if(preg_match("/dev/", $_SERVER["HTTP_HOST"]))
	{
	$db=OCILogon("itcs_backstage", "itcs_backstage", "babel.world");
//	$farmdb = OCILogon("farm_read", "farmread01", "progress.world");
	}
else	{
	$db=OCILogon("itcs_backstage", "back5tag3", "kannada.world");
//	$farmdb = OCILogon("farm_read", "farmread01", "progress.world");
	}

$alter_date = OCIParse($db, "ALTER SESSION SET NLS_DATE_FORMAT = 'MM/DD/YYYY HH24:MI'");
OCIExecute($alter_date);

function makeName($name)
{
$find = array(
	"/,\s?([A-Z]\s)?[A-Z]?,?$/",
	"/,[A-Z]$/",
	"/\s?\(.*\)/",
	"/,$/",
	"/,/",
	"/\s[A-Z],/",
	"/-/",
	"/\'/",
	"/^MC/",
	"/^MAC/");
$replace = array(
	"",
	"",
	"",
	"",
	", ",
	"",
	"- ",
	"' ",
	"MC ",
	"MAC ");
$newname = preg_replace($find, $replace, $name);
$newname = ucwords(strtolower($newname));
$newname = preg_replace("/- /", "-", $newname);
$newname = preg_replace("/\' /", "'", $newname);
$newname = preg_replace("/^Mc /", "Mc", $newname);
$newname = preg_replace("/^Mac /", "Mac", $newname);
return explode(", ", $newname);
//$newname = explode(", ", $newname);
//echo $newname[1]; if(isset($newname[2])) { echo " ".$newname[2]; } echo " ".$newname[0];
}

?>