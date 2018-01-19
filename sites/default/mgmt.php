<?php

if(!extension_loaded("oci8"))
	{
	if(!dl("oci8.so")) { exit("Cannot load OCI8 extension"); }
	}
if(preg_match("/^develop.www.umich.edu$/", $_SERVER["HTTP_HOST"]))
	{
	include "db-inc.php";
	}
else	{
	include "/afs/umich.edu/group/itd/itcsweb/Private/backstage/includes/db-inc.php";
	}

$managers = array(
	"doughb",
	"bing",
	"adavoux",
	"brimill",
	"cgreguri",
	"crislitt",
	"danafair",
	"danapf",
	"ghazalah",
	"jdebusk",
	"joanneh",
	"joelange",
	"kastrole",
	"lpoulson",
	"lwmsn",
	"markpugh",
	"mclancy",
	"rssroni",
	"ssytch",
	"woodsm",
	"yinthai","mrschlei");

$managers_sql =  "select distinct p.mgr_uniqname as manager_uniqname, m.lastname as manager_lastname, m.firstname as manager_firstname ".
	"from staff_member p, staff_member m ".
	"where (p.end_date is null or p.end_date > SYSDATE) and ".
	"m.uniqname = p.mgr_uniqname ".
	"order by p.mgr_uniqname";
$managers_sql_BAD =  "select distinct mgr_uniqname from staff_member where (end_date is null or end_date > SYSDATE) order by mgr_uniqname";
$managers_stmt = OCIParse($db, $managers_sql);
OCIExecute($managers_stmt);
while(OCIFetchInto($managers_stmt, $row, OCI_ASSOC))
	{
	foreach($row as $key => $value)
		{
		$field = strtolower($key);
		$$field = $value;
		}
	array_push($managers, $manager_uniqname);
	}

$admins = array(
	"doughb",
//	"raddis",
//	"nancym",
//	"dfero",
	"kjsloan",
	"cgreguri",
	"woodsm",
	"yinthai",
	"jdebusk",
	"joanneh",
	"kastrole","mrschlei");

//echo "<pre>"; print_r($managers); echo "</pre>";

?>