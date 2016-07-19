<?php

/**
 * List Social Icons
 */

function _base_social_icons() {
  if( function_exists('get_field') ) :
    $social_items = [
      'facebook'   => get_field('contact_facebook_url', 'options'),
      'twitter'   => get_field('contact_twitter_url', 'options'),
      'linkedin'   => get_field('contact_linkedin_url', 'options'),
      'instagram'   => get_field('contact_instagram_url', 'options'),
    ];

    foreach ($social_items as $index => $item) :
      if ($item) :
        echo '<a class="icon social-'. $index . '" href="'. $item .'"><svg class="svg"><use xlink:href="#icon-'. $index .'"></use></svg></a>';
      endif;
    endforeach;
  endif;
}
