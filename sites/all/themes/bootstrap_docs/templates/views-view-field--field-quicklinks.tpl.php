<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>

<script src="/sites/all/themes/bootstrap_docs/scripts/jquery.responsiveTabs.js"></script>
<link type="text/css" rel="stylesheet" href="/sites/all/themes/bootstrap_docs/css/responsive-tabs.css" />

  <script>
(function ($) {
$(document).ready(function() {
	console.log("test");
	$('#tabs').responsiveTabs({
    	startCollapsed: 'accordion'
	});
  });
    });
  </script>

<?php 
//print $output; 
echo "<div id='tabs'>";
echo "<ul>
    <li><a href='#tab-1'>Quicklinks</a></li>
	<li><a href='#tab-2'>Human Resources</a></li>
	<li><a href='#tab-3'>People &amp; Groups</a></li>
	<li><a href='#tab-4'>Places</a></li>
	<li><a href='#tab-5'>Policies</a></li>
    <li><a href='#tab-6'>Projects &amp; Priorities</a></li>
	<li><a href='#tab-7'>Support</a></li>
	<li><a href='#tab-8'>Systems</a></li>
	<li><a href='#tab-9'>Tools</a></li>
	<li><a href='#tab-10'>Where We're Going</a></li>
  </ul>";

//Quicklinks
echo "<div id='tab-1'>";

echo "<h2>Quicklinks</h2>";

echo "<a href='/user/".$user->uid."/edit' class='btn btn-primary'>Edit your Quicklinks</a>";

echo "<ul class='splitter'>";

foreach ($row->field_field_quicklinks as $mess) {
	foreach ($mess['rendered']['node'] as $smallermess) {
		if (isset($smallermess["field_url"]["#object"]->title)) {
			$titler = $smallermess["field_url"]["#object"]->title;
		}
		if (isset($smallermess["field_url"]["#object"]->field_url['und'][0]['url'])) {	
			$urler = $smallermess["field_url"]["#object"]->field_url['und'][0]['url'];
		}
	}
	echo "<li><a href='$urler'>$titler</a></li>";
}

echo "</ul>";

global $user;

echo "</div>";
//end Quicklinks

//random junk it
writegroups("Human Resources",2,array (
        'Hiring Process' => '/hr/hiring',
        'HR Policies' => '/policies/human-resources',
		'Staff Recognition' => '/hr/awards',
		'Time Reporting' => '/hr/time-reporting',
        'More' => '/hr'
    ));
writegroups("People &amp; Groups",3,array (
        'Organizational Charts' => 'https://umich.app.box.com/s/3qohcv4a5lrb9yja472jma1cxdfpa2qi',
        'Staff Directories' => '/people/directories',
        'More' => '/people'
    ));
writegroups("Places",4,array (
        'Building Plans' => '/places/plans',
        'Conference Rooms' => '/places/conference-rooms',
        'More' => '/places'
    ));
writegroups("Policies",5,array (
        'Business' => '/policies/business',
        'Finance &amp; Purchasing' => '/policies/finance-purchasing',
        'Human Resources' => '/policies/human-resources',
        'Incident Management &amp; SI' => '/policies/incident-management',
        'IT Policies &amp; Regulatory Compliance' => '/policies/it-policies'
    ));
writegroups("Projects &amp; Priorities",6,array (
        'Priority Projects FY18' => 'http://its.umich.edu/about/projects',
        'ITS Project Health Dashboard' => 'https://tableau.dsc.umich.edu/t/UM/views/ProjectDashboardStandardizedScorecard/ProjectDashboard',
        'Portfolio, Project and Resource Management' => '/ppm',
        'Planview Help and Support' => '/ppm/help',        'More' => '/projects'
    ));
writegroups("Support",7,array (
        'For Your Computer' => '/computing',
        'For Printing' => 'http://its.umich.edu/miworkspace/how-do-i/print-scan-fax',
        'For Communicating' => '/communication',
        'More' => '/support'
    ));
writegroups("Systems",8,array (
        'Launchpad' => 'https://collaborate.adsroot.itcs.umich.edu/mais/Pages/launchpad.aspx',
        'Production Freezes' => 'http://its.umich.edu/about/production-freezes',
        'Service Portfolio &amp; Catalog' => '/service-catalog/',
        'Disaster Recovery' => '/systems/disaster-recovery',
        'More' => '/systems/'
    ));
writegroups("Tools",9,array (
        'Planview Login' => '/planview-login',
        'ServiceLink' => 'http://servicelink.it.umich.edu/',
        'Jira Login' => '/jira-login',
        'Service Status' => 'http://status.its.umich.edu/',
		'Service Status Reporting Tool' => 'https://status.its.umich.edu/',
        'More' => '/tools/'
    ));
writegroups("Where We're Going",10,array (
        'ITS Service Portfolio Re-evaluation' => '/wheregoing/service-reevalutaion/',
        'Service Excellence Program' => '/service-excellence',
        '2016 IT Strategic Plan' => 'http://cio.umich.edu/it-strategy',
        'Diversity, Equity &amp; Inclusion' => '/dei',
        'More' => '/wheregoing'
    ));

echo "</div>";//tabs wrapper

function writegroups($heading, $order, $links) {
	$randomlinksarray = array();
	$randomlinksarray[0] = array("Organizational","https://backstage.its.umich.edu/people/orgcharts/");
	$randomlinksarray[1] = array("Building Plans","https://backstage.its.umich.edu/places/plans/");
	$randomlinksarray[2] = array("Finance &amp; Purchasing","https://backstage.its.umich.edu/policies/index.php#finance");
	$randomlinksarray[3] = array("Disaster Recovery","https://backstage.its.umich.edu/systems/disaster-recovery.php");
	$randomlinksarray[4] = array("Portfolio, Project and Resource Management","https://backstage.its.umich.edu/ppm/");
	shuffle($randomlinksarray);
	echo "<div id='tab-$order'>";
	echo "<h2>$heading</h2>";
	echo "<ul>";
foreach ($links as $key=>$value) {
		echo "<li>";
		echo "<a href='".$value."'>".$key."</a>";
		echo "</li>";
	}
	echo "</ul>";
	echo "</div>";
}
?>
