<?php

/**
 * Setup Widgets
 */
function _base_widgets_init() {
  register_sidebar(array(
    'name'          => __('Primary', '_base'),
    'id'            => 'widget-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Secondary', '_base'),
    'id'            => 'widget-secondary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
}
add_action('widgets_init', '_base_widgets_init');



/**
 * Define which pages shouldn't have the sidebar
 *
 * See lib/sidebar.php for more details
 */
function _base_display_sidebar() {
  static $display;

  if (!isset($display)) {
    $sidebar_config = new _Base_Sidebar(
      /**
       * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
       * Any of these conditional tags that return true won't show the sidebar
       *
       * To use a function that accepts arguments, use the following format:
       * array('function_name', array('arg1', 'arg2'))
       *
       * The second element must be an array even if there's only 1 argument.
       */
      array(
        'is_404',
        'is_front_page'
      ),
      /**
       * Page template checks (via is_page_template())
       * Any of these page templates that return true won't show the sidebar
       */
      array(
        // 'template-custom.php'
      )
    );
    $display = apply_filters('_base/display_sidebar', $sidebar_config->display);
  }

  return $display;
}
