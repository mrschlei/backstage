<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>

<?php

include "db-inc.php";

if(isset($_REQUEST["nm"]))
	{
	$nm = $_REQUEST["nm"];
	}
else	{
	$nm = "A";
	}
if(isset($_REQUEST["all"]) && $_REQUEST["all"]==1)
	{
	$nm = "";
	$all = 1;
	}
else	{
	$all = 0;
	}
if(isset($_REQUEST["ct"]))
	{
	$ct = $_REQUEST["ct"];
	}
else	{
	$ct = 1;
	}
$listtype = array("Former", "Current");

?>

<title>Staff Database Admin: <?php echo $listtype[$ct]; ?> Staff</title>

<link rel="StyleSheet" type="text/css" href="admin.css"/>

<script language="JavaScript" type="text/javascript">
function checkform() {
	if(!document.find.id.value) {
		alert("Please enter a UMID to find or add a staff member"); document.find.id.focus(); return false; }
	if(document.find.id.value && /^\d{8}$/.test(document.find.id.value)==false) {
		alert(document.find.id.value+" is not a valid UMID"); document.find.id.focus(); return false; }
}
</script>

</head>

<body>

<div role="main">

<h1>Staff Database Admin</h1>

<p>List by Last Name: <span class="az"><?php 
foreach(range("A","Z") as $letter)
	{
 if($nm!=$letter) { ?>
		<a href="
		<?php 
		echo $_SERVER["PHP_SELF"]; ?>
		?nm=
		<?php echo $letter; ?>&ct=
		<?php echo $ct; ?>">
	<?php } ?>

	<span class="ltr"><?php echo $letter; ?></span>

	<?php if($nm!=$letter) { ?>
		</a>
	<?php } ?>
<?php
	}
?> 

<?php if($all!=1) { ?><a href="index.php?all=1&ct=<?php echo $ct; ?>"><?php } ?><span class="ltr">Show All</span><?php if($all!=1) { ?></a><?php } ?></span></p>

<form name="find" method="get" action="prsn.php" onsubmit="return checkform();">
<p>Enter a UMID to find an existing record or add a new staff member: <input type="text" name="id" size="8" maxlength="8"/> <input type="submit" value="Find UMID"/></p>
</form>

<p>Or find a staff member by browsing the list below:</p>

<h2><?php echo $listtype[$ct]; ?> Staff &nbsp; <span class="filter"><?php if($ct==1) { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?all=<?php echo $all; ?>&nm=<?php echo $nm; ?>&ct=0">Show Former Staff</a><?php } else { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?all=<?php echo $all; ?>&nm=<?php echo $nm; ?>&ct=1">Show Current Staff</a><?php } ?></span></h2>

<table class="staffmanager">
<tr>
<th>Staff Member</th>
<th>Uniqname</th>
<th>Primary Manager</th>
</tr>
<?php

$filter = "";
if($ct==1)
	{
	$filter .= " (end_date is null or end_date > SYSDATE) and ";
	}
else	{
	$filter .= " end_date < SYSDATE and ";
	}

$count = 0;
$person_sql = "select umid, lastname, firstname, middlename, suffix, uniqname, mgr_uniqname, appointment from staff_member where ".$filter." lastname like '$nm%' order by lastname, firstname";
$person_stmt = OCIParse($db, $person_sql);
OCIExecute($person_stmt);
while(OCIFetchInto($person_stmt, $row, OCI_ASSOC+OCI_RETURN_NULLS))
	{
	foreach($row as $key => $value)
		{
		$field = strtolower($key);
		$$field = $value;
		}
	if($count % 2) { echo "<tr bgcolor=\"#f5f5f5\">\n"; } else { echo "<tr>\n"; }
?>
<td><a href="prsn.php?id=<?php echo $umid; ?>"><?php echo $lastname; ?>, <?php echo $firstname; ?> <?php echo $middlename; ?> <?php echo $suffix; ?></a><?php if(strtoupper($appointment)=="T") { echo " *"; } ?></td>
<td><?php echo $uniqname; ?></td>
<td><?php

	$manager_sql = "select lastname as mgr_lastname, firstname as mgr_firstname from staff_member where uniqname = '$mgr_uniqname'";
	$manager_stmt = OCIParse($db, $manager_sql);
	OCIExecute($manager_stmt);
	while(OCIFetchInto($manager_stmt, $manager_row, OCI_ASSOC+OCI_RETURN_NULLS))
		{
		foreach($manager_row as $manager_key => $manager_value)
			{
			$manager_field = strtolower($manager_key);
			$$manager_field = $manager_value;
			}
		echo $mgr_firstname." ".$mgr_lastname;
		}
	echo " (<em>".$mgr_uniqname."</em>)";
?></td>
</tr>
<?php
	$count++;
	}

if(!isset($lastname)) { echo "<tr>\n<td colspan=\"3\">There are no ITS Staff Members with last names beginning with $nm</td>\n</tr>\n"; }

?>
</table>

<p><a href="/hr/farm-admin/">&laquo; Staff Database Admin Main</a></p>

</body>
</html>
