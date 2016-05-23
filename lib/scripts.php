<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-2.2.3.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr.min.js
 * 3. /theme/assets/js/scripts.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */
function _base_scripts() {
  /**
   * The build task in Grunt renames production assets with a hash
   * Read the asset names from assets-manifest.json
   */
  if (WP_ENV === 'development') {
    $assets = [
      'css'           => '/assets/css/main.css',
      'js'            => '/assets/js/scripts.js',
      'modernizr'     => '/assets/js/vendor/modernizr.min.js',
      'jquery'        => '//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.js'
    ];
  } else {
    $get_manifest = file_get_contents(get_template_directory() . '/assets/manifest.json');
    $manifest = json_decode($get_manifest, true);
    $assets = [
      'css'           => '/assets/css/main.min.css?' . $manifest['assets/css/main.min.css']['hash'],
      'js'            => '/assets/js/scripts.min.js?' . $manifest['assets/js/scripts.min.js']['hash'],
      'modernizr'     => '/assets/js/vendor/modernizr.min.js',
      'jquery'        => '//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js'
    ];
  }

  wp_enqueue_style('base_css', get_template_directory_uri() . $assets['css'], false, null);

  /**
   * jQuery is loaded using the same method from HTML5 Boilerplate:
   * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
   * It's kept in the header instead of footer to avoid conflicts with plugins.
   */
  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', $assets['jquery'], array(), null, true);
    add_filter('script_loader_src', '_base_jquery_local_fallback', 10, 2);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('modernizr', get_template_directory_uri() . $assets['modernizr'], array(), null, true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('base_js', get_template_directory_uri() . $assets['js'], array(), null, true);
}
add_action('wp_enqueue_scripts', '_base_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function _base_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery.min.js?2.2.3"><\/script>\')</script>' . "\n";
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
