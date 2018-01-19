<?

if(!extension_loaded("oci8"))
	{
	if(!dl("oci8.so")) { exit("Cannot load oci8 extension"); }
	}

if(preg_match("/sdev/", $_SERVER["HTTP_HOST"]))
	{
	$db=OCILogon("itcs_backstage", "itcs_backstage", "babel.world");
	}
else	{
	$db=OCILogon("itcs_backstage", "back5tag3", "kannada.world");
	}

$alter_date = OCIParse($db, "ALTER SESSION SET NLS_DATE_FORMAT = 'MM/DD/YYYY HH24:MI'");
OCIExecute($alter_date);

?>