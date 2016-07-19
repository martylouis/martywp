<?php
  get_template_part('parts/base', 'head');
  do_action('get_header');
  get_template_part('lib/svg');
  get_template_part('parts/base', 'header');

  include _base_template_path();

  if ( _base_display_sidebar() ) :
    include _Base_Sidebar_path();
  endif;

  do_action('get_footer');
  get_template_part('parts/base', 'footer');
?>
