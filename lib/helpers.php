<?php

/**
 * Debug code in Javascript console
 */
function debug($data, $type = 'log') {
  $debug = '';
  if( is_array($data) || is_object($data) ) :
    $debug = sprintf('<script>console.%1$s(%2$s)</script>', $type, json_encode($data));
  else :
    $debug = sprintf('<script>console.%1$s("%2$s")</script>', $type, $data);
  endif;

  echo $debug;
}


/**
 * Display Images in assets folder
 * TODO: Set the image path based on src or dist
 */
function __img($img) {
  $template_dir = get_template_directory_uri();
  $img_dir = '/assets/img/';
  $img_path = sprintf('%1$s%2$s%3$s', $template_dir, $img_dir, $img);

  return $img_path;
}

function _img($img) {
  echo __img($img);
}


/**
 * Display svg icons
 */
function __svg($icon_name) {
  return sprintf('<i class="icon icon-%1$s"><svg class="svg"><use xlink:href="#svg-%1$s"></svg></i>', $icon_name);
}

function _svg($icon_name) {
  echo __svg($icon_name);
}


/**
 * Is the element empty?
 */
function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}


/*
 * Sanitize Phone numbers
 */
function _base_sanitize_phone($phone) {
  $san_phone = preg_replace("/[^0-9]/","",esc_attr( $phone ));
  return $san_phone;
}


/**
 * Page titles
 */
function _base_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return __('Latest Posts', '_base');
    }
  } elseif (is_archive()) {
    return get_the_archive_title();
  } elseif (is_search()) {
    return sprintf(__('Search Results for %s', '_base'), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', '_base');
  } else {
    return get_the_title();
  }
}

/**
 * Post and Page thumbnails
 */
function _base_thumb($post, $size, $link = false ) {
  if ( has_post_thumbnail() && $link = false ) :
    the_post_thumbnail($size);
  elseif ( has_post_thumbnail() ) :
    printf('<a itemprop="url" href="%1$s">%2$s</a>', esc_url(get_the_permalink($post)), get_the_post_thumbnail($post, $size));
  endif;
}


/**
 * Update jetpack sharing
 */
function jptweak_remove_share() {
    remove_filter( 'the_content', 'sharing_display', 19 );
    remove_filter( 'the_excerpt', 'sharing_display', 19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
      remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}
add_action( 'loop_start', 'jptweak_remove_share' );
