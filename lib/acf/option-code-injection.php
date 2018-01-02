<?php

namespace MartyWP\Lib\ACF\Option;

use MartyWP\Lib\Utils;

if (!defined('ABSPATH')) exit;

/**
 * Setup the Code Injection options
 */

class CodeInject {

  public function __construct() {

    add_action('wp_head', [$this, 'head_scripts'], 99);
    add_action('wp_footer', [$this, 'footer_scripts'], 99);

  }

  public static function head_scripts() {
    $head_scripts = get_field('option_code_head', 'option');

    echo $head_scripts ? : '';
  }

  public static function footer_scripts() {
    $footer_scripts = get_field('option_code_footer', 'option');
    echo $footer_scripts ? : '';
  }

}

new CodeInject;
