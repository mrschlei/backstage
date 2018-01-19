<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
<title>Staff Database Admin</title>

<link rel="StyleSheet" type="text/css" href="admin.css"/>

<link rel="StyleSheet" type="text/css" href="calendar.css"/>
<script language="JavaScript" type="text/javascript" src="CalendarPopup.js"></script>

<script language="JavaScript" type="text/javascript">
function checkform() {
	if(!document.prsn.umid.value) {
		alert("You must enter a valid UMID"); document.prsn.umid.focus(); return false; }
	if(document.prsn.umid.value && /^[\d]{8}$/.test(document.prsn.umid.value)==false) {
		alert(document.prsn.umid.value+" is not a valid UMID"); document.prsn.umid.focus(); return false; }
	if(!document.prsn.uniqname.value) {
		alert("You must enter a valid uniqname"); document.prsn.uniqname.focus(); return false; }
	if(document.prsn.uniqname.value && /^[a-z]{3,8}$/i.test(document.prsn.uniqname.value)==false) {
		alert(document.prsn.uniqname.value+" is not a valid uniqname"); document.prsn.uniqname.focus(); return false; }
}
</script>

</head>

<body>

<p><a href=".">&laquo; Main Page</a></p>

<div role="main">

<h1>Staff Database Admin</h1>

<?php

include "db-inc.php";

if(isset($_REQUEST["id"]) && preg_match("/^\d{8}$/", $_REQUEST["id"]))
	{
	$id = $_REQUEST["id"];
$person_sql = "select * from staff_member where umid = $id";
$person_stmt = OCIParse($db, $person_sql);
OCIExecute($person_stmt);
while(OCIFetchInto($person_stmt, $row, OCI_ASSOC+OCI_RETURN_NULLS))
	{
	foreach($row as $key => $value)
		{
		$field = strtolower($key);
		$$field = $value;
//		echo "<p>".$key." ".$value."</p>";
		}
	}
if(!isset($uniqname))
	{
	$umid = $id;
	$action = "add";
	$start_date = "";
	$end_date = "";
	}
else	{
	$action = "update";
	}
?>

<?php if(!isset($uniqname)) { ?><p>There is no ITS staff member with UMID <strong><?php echo $id; ?></strong>.</p>

<p>If the staff member <em>should</em> be in the database, please return to the <a href=".">Main Page</a>, double-check the UMID, and try again&mdash;or look for the staff member by name.</p>

<p>If the staff member is new to ITS, you may add them below:</p><?php } ?>

<?php if(isset($_REQUEST["u"])) { ?><p><strong style="color:#cc0000;">This record has been updated.</strong></p><?php } ?>

<form name="prsn" method="post" action="prsnsave.php" onsubmit="return checkform();">
<input type="hidden" name="action" value="<?php echo $action; ?>"/>
<input type="hidden" name="current_umid" value="<?php echo $id; ?>"/>

<table class="prsn">
<tr>
<th>UMID:</th>
<td colspan="4"><input type="text" name="umid" size="8" maxlength="8" value="<?php echo @$umid; ?>"/></td>
</tr>
<tr>
<th>Uniqname:</th>
<td colspan="4"><input type="text" name="uniqname" size="8" maxlength="8" value="<?php echo @$uniqname; ?>"/></td>
</tr>
<tr>
<th>Name:</th>
<td><input type="text" name="lastname" size="20" value="<?php echo @$lastname; ?>"/></td>
<td><input type="text" name="firstname" size="20" value="<?php echo @$firstname; ?>"/></td>
<td><input type="text" name="middlename" size="12" value="<?php echo @$middlename; ?>"/></td>
<td><input type="text" name="suffix" size="6" value="<?php echo @$suffix; ?>"/></td>
</tr>
<tr>
<th></th>
<td class="smalltext">Last</td>
<td class="smalltext">First</td>
<td class="smalltext">Middle</td>
<td class="smalltext">Suffix (e.g. Jr., Sr.)</td>
</tr>
<tr>
<th>Manager Uniqname:</th>
<td colspan="4"><input type="text" name="mgr_uniqname" size="8" maxlength="8" value="<?php echo @$mgr_uniqname; ?>"/></td>
</tr>
<tr>
<th></th>
<td colspan="4"><label><input type="checkbox" name="appointment" value="T"<?php if(isset($uniqname) && $appointment=="T") { ?> checked="checked"<?php } ?>/>Temporary Appointment</label></td>
</tr>
<tr>
<th>Begin Date:</th>
<td colspan="4"><input type="text" name="start_date" id="start_date" size="10" maxlength="10" value="<?php if($start_date!="") { echo date("m/d/Y", strtotime($start_date)); } ?>" onclick="startdate.select(document.prsn.start_date,'start_date','MM/dd/yyyy');"/>
<script language="JavaScript">
var startdate = new CalendarPopup("calendardiv");
var startnow = new Date();
//startnow.setDate(startnow.getDate()-1);
//startdate.addDisabledDates(null,formatDate(startnow,"yyyy-MM-dd"));
startdate.setCssPrefix("ITCS");
</script> <span class="smalltext">(MM/DD/YYYY)</span></td>
</tr>
<tr>
<th>End Date:</th>
<td colspan="4"><input type="text" name="end_date" id="end_date" size="10" maxlength="10" value="<?php if($end_date!="") { echo date("m/d/Y", strtotime($end_date)); } ?>" onclick="enddate.select(document.prsn.end_date,'end_date','MM/dd/yyyy');"/>
<script language="JavaScript">
var enddate = new CalendarPopup("calendardiv");
enddate.setCssPrefix("ITCS");
</script> <span class="smalltext">(MM/DD/YYYY; Leave blank for permanent appointments)</span></td>
</tr>
<tr>
<th></th>
<td colspan="3"><br/><input type="submit" value="Save Changes"/></td>
<td><br/><input type="reset" value="Reset Form"/></td>
</tr>
</table>

</form>

<div id="calendardiv" style="position:absolute;visibility:hidden;background:#ffffff;"></div>

<?php
	}
else	{
?>
<p><strong style="color:#cc0000;">You did not enter a valid UMID.</strong></p>
<form name="find" method="get" action="prsn.php" onsubmit="return checkform();">
<p>Enter a UMID to find an existing record or add a new staff member: <input type="text" name="id" size="8" maxlength="8"/> <input type="submit" value="Find UMID"/></p>
</form>
<?php
	}
?>

</body>
</html>
