<?php

/**
 * @file
 * template.php
 */


/**
* Add / modify variables before the page renders.
*/
function bootstrap_parkwood_preprocess_page(&$vars) {
// custom content type page template
  // Renders a new page template to the list of templates used if it exists
  if (isset($vars['node']->type)) {
// This code looks for any page--custom_content_type.tpl.php page
    $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;
  }
}


/* This function not working - a way to change bootstrap content column class //

function bootstrap_parkwood_preprocess_page(&$variables) {
  // Add information about the number of sidebars.
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-4"';
  }
  elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-8"';
  }
  else {
    $variables['content_column_class'] = ' class="col-sm-12"';
  }
} */




/* This function not working for some reason //

function bootstrap_parkwood_preprocess_page(&$variables) {
	drupal_add_js(drupal_get_path('theme', 'bootstrap_parkwood') . 'jquery.smartmenus.js');
}

function bootstrap_parkwood_preprocess_page(&$variables) {
	drupal_add_js(drupal_get_path('theme', 'bootstrap_parkwood') . '/addons/bootstrap/jquery.smartmenus.bootstrap.js');
} */

/**
 * Overrides theme_menu_link().
 */
function bootstrap_parkwood_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
 
  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    //Here we need to change from ==1 to >=1 to allow for multilevel submenus
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] >= 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      //$element['#title'] .= ' <span class="caret"></span>'; Smartmenus plugin add's caret
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;
 
      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      //comment element bellow if you want your parent menu links to be "clickable"
      //$element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}


function bootstrap_parkwood_date_nav_title($params) {
	$granularity = $params['granularity'];
	$view = $params['view'];
	$date_info = $view->date_info;
	$link = !empty($params['link']) ? $params['link'] : FALSE;
	$format = !empty($params['format']) ? $params['format'] : NULL;
	switch ($granularity) {
	case 'year':
	$title = $date_info->year;
	$date_arg = $date_info->year;
	break;
	case 'month':
	$format = !empty($format) ? $format : (empty($date_info->mini) ? 'F Y' : 'F Y');
	$title = date_format_date($date_info->min_date, 'custom', $format);
	$date_arg = $date_info->year .'-'. date_pad($date_info->month);
	break;
	case 'day':
	$format = !empty($format) ? $format : (empty($date_info->mini) ? 'l, F j Y' : 'l, F j');
	$title = date_format_date($date_info->min_date, 'custom', $format);
	$date_arg = $date_info->year .'-'. date_pad($date_info->month) .'-'. date_pad($date_info->day);
	break;
	case 'week':
	$format = !empty($format) ? $format : (empty($date_info->mini) ? 'F j Y' : 'F j');
	$title = t('Week of @date', array('@date' => date_format_date($date_info->min_date, 'custom', $format)));
	$date_arg = $date_info->year .'-W'. date_pad($date_info->week);
	break;
	}
	if (!empty($date_info->mini) || $link) {
	// Month navigation titles are used as links in the mini view.
	$attributes = array('title' => t('View full page month'));
	$url = date_pager_url($view, $granularity, $date_arg, TRUE);
	return l($title, $url, array('attributes' => $attributes));
	}
	else {
	return $title;
	}
}


// Add img-responsive class to newsflash image style
function bootstrap_parkwood_preprocess_image_style(&$vars) {
     if($vars['style_name'] == 'newsflash'){
            $vars['attributes']['class'][] = 'img-responsive'; // http://getbootstrap.com/css/#overview-responsive-images
        }
}