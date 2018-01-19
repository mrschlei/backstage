<?php

/**
 * @file
 * template.php
 */

function bootstrap_docs_bootstrap_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= '<div class="hidden"><a name="search"></a><label for="edit-search-block-form--2">Search</label></div>';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
  // We can be sure that the font icons exist in CDN.
  //if (theme_get_setting('bootstrap_cdn')) {
    $output .= "<span class='icon glyphicon glyphicon-search' aria-hidden='true'></span>";
 // }
  //else {
    //$output .= t('Search');
  //}
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}


//Trying to kill new user registrations
function bootstrap_docs_theme($existing, $type, $theme, $path){
  $hooks['user_register_form']=array(
    'render element'=>'form',
    'template' =>'templates/user-register',
  );
return $hooks;
}

function bootstrap_docs_preprocess_user_register(&$variables) {
  $variables['form'] = drupal_build_form('user_register_form', user_register_form(array()));
}


function bootstrap_docs_form_alter(&$form, &$form_state, $form_id) {

  if ($form_id == 'webform_client_form_568') {
	
	$db=OCILogon("itcs_backstage", "back5tag3", "kannada.world");
	$alter_date = OCIParse($db, "ALTER SESSION SET NLS_DATE_FORMAT = 'MM/DD/YYYY HH24:MI'");
	OCIExecute($alter_date);

///////////////////////
	if (isset($_REQUEST["uniqname"])) {
		
		$to_uniqname = htmlspecialchars($_REQUEST["uniqname"]);
		$from_uniqname = $_SERVER["REMOTE_USER"];
		$to_sql = "select firstname, lastname, mgr_uniqname from staff_member where uniqname = '$to_uniqname'";
		$to_stmt = OCIParse($db, $to_sql);
		OCIExecute($to_stmt);
		while(OCIFetchInto($to_stmt, $row, OCI_ASSOC+OCI_RETURN_NULLS)) {
			foreach($row as $key => $value) {
				$field = strtolower($key);
				$$field = $value;
			}
		}
		$from_sql = "select lastname as from_lastname, firstname as from_firstname from staff_member where uniqname = '$from_uniqname'";
		$from_stmt = OCIParse($db, $from_sql);
		OCIExecute($from_stmt);
		while(OCIFetchInto($from_stmt, $row, OCI_ASSOC+OCI_RETURN_NULLS)) {
			foreach($row as $key => $value) {
				$field = strtolower($key);
				$$field = $value;
			}
		}
///////////////////////
		$form["submitted"]["recipients_name"]["#default_value"] = $firstname." ".$lastname;
		$form["submitted"]["your_name"]["#default_value"] = $from_firstname." ".$from_lastname;
		$form["submitted"]["recipients_email"]["#default_value"] = $to_uniqname."@umich.edu";
		$form["submitted"]["recipients_manager_uniqname"]["#default_value"] = $mgr_uniqname."@umich.edu";
		//$form["submitted"]["recipients_manager_uniqname"]["#default_value"] = "mrschlei@umich.edu";
  	}
	else {
		//drupal_goto("hr/spirit-excellence", array());
	}
  }
}







///////////////webform themin'
///////////////default: http://www.drupalcontrib.org/api/drupal/contributions!webform!webform.module/function/theme_webform_element/7
function bootstrap_docs_webform_element($variables) {
  // Ensure defaults.
  $variables['element'] += array(
    '#title_display' => 'before',
  );

  $element = $variables['element'];

  // All elements using this for display only are given the "display" type.
  if (isset($element['#format']) && $element['#format'] == 'html') {
    $type = 'display';
  }
  else {
    $type = (isset($element['#type']) && !in_array($element['#type'], array('markup', 'textfield', 'webform_email', 'webform_number'))) ? $element['#type'] : $element['#webform_component']['type'];
  }

  // Convert the parents array into a string, excluding the "submitted" wrapper.
  $nested_level = $element['#parents'][0] == 'submitted' ? 1 : 0;
  $parents = str_replace('_', '-', implode('--', array_slice($element['#parents'], $nested_level)));

  $wrapper_attributes = isset($element['#wrapper_attributes']) ? $element['#wrapper_attributes'] : array('class' => array());
  $wrapper_classes = array(
    'form-item',
    'webform-component',
    'webform-component-' . $type,
  );
  if (isset($element['#title_display']) && strcmp($element['#title_display'], 'inline') === 0) {
    $wrapper_classes[] = 'webform-container-inline';
  }
  if(isset($wrapper_attributes['class'])) {$wrapper_attributes['class'] = array_merge($wrapper_classes, $wrapper_attributes['class']);}
  if(isset($wrapper_attributes['id'])) {$wrapper_attributes['id'] = 'webform-component-' . $parents;}
  $output = '<div ' . drupal_attributes($wrapper_attributes) . '>' . "\n";

  // If #title_display is none, set it to invisible instead - none only used if
  // we have no title at all to use.
  if ($element['#title_display'] == 'none') {
    $variables['element']['#title_display'] = 'invisible';
    $element['#title_display'] = 'invisible';
    if (empty($element['#attributes']['title']) && !empty($element['#title'])) {
      $element['#attributes']['title'] = $element['#title'];
    }
  }
  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . _webform_filter_xss($element['#field_prefix']) . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . _webform_filter_xss($element['#field_suffix']) . '</span>' : '';

  $desc = "";
  if (!empty($element['#description'])) {
    $desc = ' <div class="description help-block">' . $element['#description'] . "</div>\n";
  }

  switch ($element['#title_display']) {
    case 'inline':
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= $desc;
	  $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }



  $output .= "</div>\n";

  return $output;
}
///////////////end webform themin'