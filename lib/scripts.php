<?php

/**
 *  Set asset path based on WP_ENV
 */
function _base_asset_path($name, $type) {
  $wp_dev = (WP_ENV === 'development' ? true : false);
  $uri = get_template_directory_uri();
  $path = $wp_dev ? sprintf('%1$s/assets/%2$s/%3$s.%2$s', $uri, $type, $name) : sprintf('%1$s/assets/dist/%2$s/%3$s.min.%2$s', $uri, $type, $name);
  return $path;
}


/**
 *  Enqueue the scripts
 */
function _base_scripts() {

  $wp_dev = (WP_ENV === 'development' ? true : false);
  $get_package = file_get_contents(get_template_directory() . '/package.json');
  $pkg = json_decode($get_package, true);
  $pkg_ver = $wp_dev ? null : $pkg['version'];

  wp_enqueue_style('base_css', _base_asset_path('styles', 'css'), null, $pkg_ver, null);

  /**
   * jQuery is loaded using the same method from HTML5 Boilerplate:
   * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
   * It's kept in the header instead of footer to avoid conflicts with plugins.
   */

  $jquery_ver = '3.2.1';

  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/'. $jquery_ver . '/jquery.min.js', array(), null, false);
    add_filter('script_loader_src', '_base_jquery_local_fallback', 10, 2);
  }
  wp_enqueue_script('jquery');

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('base_js', _base_asset_path('scripts', 'js'), array(), $pkg_ver, true);
}
add_action('wp_enqueue_scripts', '_base_scripts', 100);


/**
 *  jQuery Local Fallback
 *  @link http://wordpress.stackexchange.com/a/12450
 */
function _base_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/dist/js/vendor/jquery.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action('wp_head', '_base_jquery_local_fallback');



/**
 * Google Analytics snippet from HTML5 Boilerplate
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 */
function _base_google_analytics() {
  if (function_exists('get_field') && get_field('google_analytics_id', 'options') ) :
    $ga_ID = get_field('google_analytics_id', 'options');
?><script>
<?php if (WP_ENV === 'production') : ?>
(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
   function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
   e=o.createElement(i);r=o.getElementsByTagName(i)[0];
   e.src='//www.google-analytics.com/analytics.js';
   r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
 <?php else : ?>
function ga() {
  console.log('GoogleAnalytics: ' + [].slice.call(arguments));
}
<?php endif;?>
ga('create','<?php echo $ga_ID; ?>','auto');ga('send','pageview');
</script>
<?php
 else:
  $ga_ID = '';
endif;
}

if (WP_ENV !== 'production' || !current_user_can('manage_options')) {
  add_action('wp_head', '_base_google_analytics', 20);
}
