<?php

//echo "<pre>"; print_r($_POST); echo "</pre>";

foreach($_POST as $key => $value)
	{
	$value = preg_replace("/'/","''",$value);
	$$key = $value;
	}

$uniqname = strtolower($uniqname);

if($action=="add")
	{
	$sql = "insert into staff_member fields (lastname, firstname, middlename, suffix, uniqname, umid, mgr_uniqname, appointment, start_date, end_date)
		values ('$lastname', '$firstname', '$middlename', '$suffix', '$uniqname', to_char('$umid','FM00000000'), '$mgr_uniqname', '$appointment', to_date('$start_date','MM/DD/YYYY'), to_date('$end_date','MM/DD/YYYY'))";
	}
if($action=="update")
	{
	if(!isset($appointment)) { $appointment = ""; }
	$sql = "update staff_member set lastname='$lastname', firstname='$firstname', middlename='$middlename', suffix='$suffix', uniqname='$uniqname', umid=to_char('$umid','FM00000000'), mgr_uniqname='$mgr_uniqname', appointment='$appointment', start_date=to_date('$start_date','MM/DD/YYYY'), end_date=to_date('$end_date','MM/DD/YYYY') where umid = '$current_umid'";
	}

include "db-inc.php";

$stmt = OCIParse($db, $sql);
if(!OCIExecute($stmt))
	{
	echo "<p>ERROR! Return to <a href=\".\">Main Page</a>.</p>";
//	echo $sql;
	exit;
	}
else	{
	header("location:prsn.php?id=$umid&u");
	}

?>