<?php

namespace MartyWP\Lib\ACF\Option;

use MartyWP\Lib\Utils;

if (!defined('ABSPATH')) exit;

/**
 * Get the Business Info
 */

class BizInfo {

  public static function get_acf_fields() {

    $fields = [
      'name' => get_field('option_biz_name', 'option'),
      'address' => get_field('option_biz_address', 'option'),
      'email' => get_field('option_email', 'option'),
      'phone' => get_field('option_phone', 'option'),
      'social_links' => get_field('option_social_links', 'option')
    ];

    return $fields;

  }

  /**
   * Return the Business Address as an array or commonly formatted
   */
  public static function get_address($return_array = false) {
    $postal_address = self::get_acf_fields()['address'];
    $items = [];

    foreach ($postal_address as $key => $address_item) :
      $items[$key] = sprintf('<span class="%1$s" itemprop="%1$s">%2$s</span>', $key, $address_item);
    endforeach;

    if (!$return_array) :
      return vsprintf('%s <br> %s, %s %s %s', $items); // Return all 5 address items
    else :
      return $items;
    endif;
  }

  /**
   * Return the Business Email Address
   */
  public static function get_email() {
    $fields = self::get_acf_fields();
    $email = $fields['email'];
    return $email ? sprintf('<a href="mailto:%1$s" itemprop="email">%s</a>', $email) : '';
  }

  /**
   * Return the Business Phone Number
   */
  public static function get_phone() {
    $fields = self::get_acf_fields();
    $phone = $fields['phone'];
    return $phone ? sprintf('<a class="phone-number" href="tel:+1%1$s" itemprop="telephone">%2$s</a>', Utils::sanitize_phone($phone), $phone) : '';
  }

  /**
   * Return the Business Social Links
   */
  public static function get_social_links() {
    $fields = self::get_acf_fields();
    $links = $fields['social_links'];
    if ($links) :
      $output = '<span itemscope itemtype="http://schema.org/LocalBusiness">';
      $output .= sprintf('<link itemprop="url" href="%s">', home_url());
      while (have_rows('option_social_links', 'option')) : the_row();
        $url = get_sub_field('social_url');
        $type = get_sub_field('social_type');
        $output .= sprintf('<a itemprop="sameAs" class="social-link %2$s" rel="noopener noreferrer" target="_blank" href="%1$s">%3$s</a>', $url, $type, Utils::get_svg($type));
      endwhile;
      $output .= '</span>';
    endif;
  }

  public static function the_localBusiness() {

    $output = '<div itemscope itemtype="http://schema.org/LocalBusiness">';

    // Company Name
    $output .= sprintf('<span itemscope="name">%s</span> <br>', get_field('option_biz_name', 'option'));
    $output .= self::get_address() . '<br>';
    $output .= self::get_email() . '<br>';
    $output .= self::get_phone();

    $output .= '</div>';

    echo $output;

  }

}

new BizInfo;
