<?

include "db-inc.php";

if(isset($_REQUEST["id"]))
	{
	$id = $_REQUEST["id"];
	}
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
	header("location:form.php?id=$id");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
<title>Staff Database Admin</title>

<link rel="StyleSheet" type="text/css" href="admin.css"/>

<link rel="StyleSheet" type="text/css" href="calendar.css"/>
<script language="JavaScript" type="text/javascript" src="CalendarPopup.js"></script>

</head>

<body>

<p><a href=".">&laquo; Main Page</a></p>

<div role="main">

<h1>Staff Database Admin</h1>

<? if(isset($_REQUEST["u"])) { ?><p><strong style="color:#cc0000;">This record has been updated.</strong></p><? } ?>

<table class="prsn">
<tr>
<th>UMID:</th>
<td><? echo $umid; ?></td>
</tr>
<tr>
<th>Uniqname:</th>
<td><? echo $uniqname; ?></td>
</tr>
<tr>
<th>Name:</th>
<td><? echo $lastname; ?>, <? echo $firstname; ?> <? echo $middlename; ?> <? echo $suffix; ?></td>
</tr>
<tr>
<th>Manager Uniqname:</th>
<td><? echo $mgr_uniqname; ?></td>
</tr>
<? if($appointment=="T") { ?>
<tr>
<th></th>
<td><em>Temporary Appointment</em></td>
</tr>
<? } ?>
<tr>
<th>Begin Date:</th>
<td><? if($start_date!="") { echo date("m/d/Y", strtotime($start_date)); } ?></td>
</tr>
<tr>
<th>End Date:</th>
<td><? if($end_date!="") { echo date("m/d/Y", strtotime($end_date)); } else { ?>N/A<? } ?></td>
</tr>
<tr>
<th></th>
<td><br/><form method="get" action="form.php"><input type="hidden" name="id" value="<? echo $umid; ?>"/><input type="submit" value="Update Record"/></form></td>
</tr>
</table>

</form>

<div id="calendardiv" style="position:absolute;visibility:hidden;background:#ffffff;"></div>

</body>
</html>
