<?php


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
 * CSO Google Analytics Setup
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 */
function _base_google_analytics() {
  if (function_exists('get_field') && get_field('cso_google_analytics_id', 'options') ) :
    $ga_ID = get_field('cso_google_analytics_id', 'options');
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


/**
 * Common Site Options -  Head and Footer Script Setup
 */
function cso_head_scripts() {
  echo $head_scripts = get_field('cso_code_head', 'option') ? : '';
}
add_action('wp_head', 'cso_head_scripts', 99);

function cso_footer_scripts() {
  echo $head_scripts = get_field('cso_code_footer', 'option') ? : '';
}
add_action('wp_footer', 'cso_head_scripts', 99);


/**
 * CSO Google Tag Manager Setup
 */
function google_tag_manager_head() {
  if (get_field('cso_gtm_id', 'option')) :
    $id = get_field('cso_gtm_id', 'option');
    printf('<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
    new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
    \'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,\'script\',\'dataLayer\',\'%s\');</script>
    <!-- End Google Tag Manager -->
  ', $id);
endif;
}
add_action('wp_head', 'google_tag_manager_head', 99);

function google_tag_manager_noscript() {
  if ( get_field('cso_gtm_id', 'option') ) :
    $id = get_field('cso_gtm_id', 'option');
    printf('<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->', $id);
  endif;
}
add_action('after_body_open', 'google_tag_manager_noscript');
