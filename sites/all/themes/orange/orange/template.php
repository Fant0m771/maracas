<?php

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */

/**
 * Implements hook_theme 
 */
function orange_theme() {
  return array (
    'contact_site_form' => array(
      'render element' => 'form',
      'template' => 'contact-site-form',
      'path' => drupal_get_path('theme', 'orange') . '/templates',
    ),
  );
} 
 

 
/**
 * Override or insert variables into the html template.
 */
function orange_preprocess_html(&$vars) {  
  drupal_add_css(path_to_theme() . '/css/style.css', array('weight' => CSS_THEME));
  // Add conditional CSS for IE7.
  drupal_add_css(path_to_theme() . '/css/ie-7.css', array('weight' => CSS_THEME, 'browsers' => array('IE' => 'IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  // Add conditional CSS for IE6.
  drupal_add_css(path_to_theme() . '/css/ie-6.css', array('weight' => CSS_THEME, 'browsers' => array('IE' => 'lt IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
}
/**
 * Implements hook_preprocess_block().
 */
function orange_preprocess_block(&$vars) {
  // Set "first" and "last" classes.
  if ($vars['block']->position_first){
     $vars['classes_array'][] = 'first';
  }
  if ($vars['block']->position_last){
    $vars['classes_array'][] = 'last';
  }
}

/**
 * Implements hook_preprocess_comment_wrapper().
 */
function orange_preprocess_comment_wrapper(&$vars) {
  // Provide contextual information.
  $vars['node'] = $vars['content']['#node'];
    
  if($vars['node']->comment_count == 0) {
    $vars['classes_array'][] = 'no-comments';
  } else {
    $vars['classes_array'][] = 'has-comments';
    if($vars['node']->type == 'forum') {
      $vars['title'] = t('Replies (@count)', array('@count' => $vars['node']->comment_count));
    } else {
    $vars['title'] = t('Comments (@count)', array('@count' => $vars['node']->comment_count));
    }
  }
}

/**
 * Implements hook_preprocess_comment_wrapper().
 */
function orange_preprocess_comment(&$vars) {
  $comment = $vars['elements']['#comment'];

  $timestamp = $comment->created;

  $vars['created'] = format_date($timestamp, 'custom', 'd.m.Y,  H:i');

  if($vars['picture']) {
    $vars['classes_array'][] = 'photo';
  } else {
    $vars['classes_array'][] = 'no-photo';
  }
}

/**
 * Implements hook_preprocess_node().
 */
function orange_preprocess_node(&$vars) {
  if($vars['date']) {
    $date_day = format_date($vars['node']->created, 'custom', 'j');
    $date_month = format_date($vars['node']->created, 'custom', 'F');
    $date_year = format_date($vars['node']->created, 'custom', 'Y');

    $vars['date'] = '<span class="date"><strong>'. $date_month . '</strong> ';
    $vars['date'] .= $date_day .', ';
    $vars['date'] .= $date_year .'</span>';
  }
  
  if ($vars['node']->type == "poleznue-sovetu" && $vars['view_mode'] == "full") {
    drupal_add_js(path_to_theme(). "/js/custom-orange.js");
  }  
}

/**
 * Implements hook_preprocess_comment_wrapper().
 */
function orange_preprocess_page(&$vars) {
  // Prepare header.
  
  //$bread = array();
  //$bread = $vars['page']['content_inner']['easy_breadcrumb_easy_breadcrumb']['easy_breadcrumb']['#breadcrumb'];
  //kpr($bread);
  
  /*foreach($bread as $key => $br) {
    $vars['page']['content_inner']['easy_breadcrumb_easy_breadcrumb']['easy_breadcrumb']['#breadcrumb'][$key] = str_replace("Stroitelstvo", "Строительство", $br);
  }
  
  if ($vars["node"]->type == "work_types") {
    drupal_add_js(path_to_theme() . '/js/hoverPulse.js');
    drupal_add_js("jQuery(document).ready(function () { 
                     jQuery('#block-views-work-type-images-block img').hoverpulse({
	                   size: 20,  
	                   speed: 400
                     });                     
                   });", array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
                  );
                    
  }
  */
  
   
  if ($vars['theme_hook_suggestions'][0] == "page__contact") {
    drupal_set_title(t("Напишите нам"));
  }
  $site_fields = array();
  if (!empty($vars['site_name'])) {
    $site_fields[] = check_plain($vars['site_name']);
  }
  if (!empty($vars['site_slogan'])) {
    $site_fields[] = check_plain($vars['site_slogan']);
  }
  $vars['site_title'] = implode(' ', $site_fields);
  if (!empty($site_fields)) {
    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
  }
  
  if($vars['logged_in']) {
    $vars['signup'] = l(t('My Account'), 'user');
    $vars['signup'] .= ' | ';
    $vars['signup'] .= l(t('Log Out'), 'user/logout');
  }
  
}

/**
 * Implements hook_page_alter().
 */
function orange_page_alter(&$page) {
  // Determine the position and count of blocks within regions.
  foreach ($page as &$region) {
    // Make sure this is a "region" element.
    if (is_array($region) && isset($region['#region'])) {
      $i = 0;
      foreach ($region as &$block) {
        // Make sure this is a "block" element.
        if (is_array($block) && isset($block['#block'])) {
          $block['#block']->position = $i++;
          // Set a flag for "first" and "last" blocks.
          $block['#block']->position_first = ($block['#block']->position == 0);
          $block['#block']->position_last = FALSE;
          $last_block =& $block;
        }
      }
      $last_block['#block']->position_last = TRUE;
      $region['#block_count'] = $i;
    }
  }    
}

function orange_field__field_tags($vars) {
  $output = '';
  
  // Render the label, if it's not hidden.
  if (!$vars['label_hidden']) {
    $output .= '<span class="field-label"' . $vars['title_attributes'] . '>' . $vars['label'] . ':&nbsp;</span>';
  }
  $total = count($vars['items']);

  // Render the items.
  $output .= '<span class="field-items"' . $vars['content_attributes'] . '>';
  foreach ($vars['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<span class="' . $classes . '"' . $vars['item_attributes'][$delta] . '>' . drupal_render($item) . '</span>';
    if($delta != ($total - 1)) {
      $output .= ', ';
    }
  }
  $output .= '</span>';
  
  // Render the top-level DIV.
  $output = '<div class="' . $vars['classes'] . '"' . $vars['attributes'] . '>' . $output . '</div>';

  return $output;
}

function orange_field__taxonomy_forums($vars) {
  $output = '';
  
  // Render the label, if it's not hidden.
  if (!$vars['label_hidden']) {
    $output .= '<span class="field-label"' . $vars['title_attributes'] . '>' . $vars['label'] . ':&nbsp;</span>';
  }
  $total = count($vars['items']);

  // Render the items.
  $output .= '<span class="field-items"' . $vars['content_attributes'] . '>';
  foreach ($vars['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<span class="' . $classes . '"' . $vars['item_attributes'][$delta] . '>' . drupal_render($item) . '</span>';
    if($delta != ($total - 1)) {
      $output .= ', ';
    }
  }
  $output .= '</span>';
  
  // Render the top-level DIV.
  $output = '<div class="' . $vars['classes'] . '"' . $vars['attributes'] . '>' . $output . '</div>';

  return $output;
}

function orange_feed_icon($vars) {
  $text = t('Subscribe to @feed-title', array('@feed-title' => $vars['title']));
  if ($image = theme('image', array('path' => path_to_theme() .'/images/rss.png', 'alt' => $text))) {
    return l($image . t(' RSS Feed'), $vars['url'], array('html' => TRUE, 'attributes' => array('class' => array('feed-icon'), 'title' => $text)));
  }
}

function orange_captcha($variables) {
  $element = $variables['element'];
  $element['captcha_widgets']['captcha_response']["#description"] = "";
  $element['captcha_widgets']['captcha_response']['#title'] = t("Enter the code");
  
  if (!empty($element['#description']) && isset($element['captcha_widgets'])) {
    $fieldset = array(
      '#type' => 'fieldset',
      '#description' => $element['#description'],
      '#children' => drupal_render_children($element),
      '#attributes' => array('class' => array('captcha')),
    );
    return theme('fieldset', array('element' => $fieldset));
  }
  else {
    return '<div class="captcha">' . drupal_render_children($element) . '</div>';
  }
}

function orange_preprocess_contact_site_form(&$vars) {
    $vars['form_html'] = drupal_render_children($vars['form']);
	/*$vars['name'] = drupal_render($vars['form']['name']);	
    $vars['email'] = drupal_render($vars['form']['mail']);
    $vars['subject'] = drupal_render($vars['form']['subject']);
    $vars['message'] = drupal_render($vars['form']['message']);
    $vars['copy'] = drupal_render($vars['form']['copy']);
    $vars['submit'] = drupal_render($vars['form']['submit']);*/
}

function orange_form_alter(&$form, &$form_state) {
  if ($form['#form_id'] == "contact_site_form") {
    kpr($form);
    $form['name']['#attributes'] = array(
      'required' => array(""),
    );
    $form['mail']['#attributes'] = array(
      'required' => array(""),
    );
    $form['subject']['#required'] = FALSE;       
  }    
}

/*
function orange_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
  $element['#attributes']['class'][] = 'menu-' . $element['#original_link']['mlid'];

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
*/