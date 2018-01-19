<?php

/**
 * @file
 * template.php
 */

function bootstrap_its_bootstrap_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= '<div class="hidden"><a name="search"></a><label for="edit-search-block-form--2">Search</label></div>';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
  // We can be sure that the font icons exist in CDN.
  if (theme_get_setting('bootstrap_cdn')) {
    $output .= _bootstrap_icon('search');
  }
  else {
    $output .= t('Search');
  }
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}

//Trying to kill new user registrations
function bootstrap_its_theme($existing, $type, $theme, $path){
  $hooks['user_register_form']=array(
    'render element'=>'form',
    'template' =>'templates/user-register',
  );
return $hooks;
}

function bootstrap_its_preprocess_user_register(&$variables) {
  $variables['form'] = drupal_build_form('user_register_form', user_register_form(array()));
}