<?php
  get_template_part('parts/base', 'head');
  do_action('get_header');
  get_template_part('lib/svg');
  get_template_part('parts/base', 'header');
?>
  <main class="main max-width-4 mx-auto px3 clearfix">
  <?php include _base_template_path();

  if ( _base_display_sidebar() ) :
    include _Base_Sidebar_path();
  endif;
  ?>
  </main>

<?php
  do_action('get_footer');
  get_template_part('parts/base', 'footer');
?>
