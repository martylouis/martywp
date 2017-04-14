<?php
  get_template_part('parts/site/head');
  do_action('get_header');
  get_template_part('parts/svg');
  get_template_part('parts/site/header');
?>
  <main class="main max-width-4 mx-auto px3 clearfix">
    <?php include _base_template_path(); ?>
    <?php if (_base_display_sidebar())  include _base_Sidebar_path(); ?>
  </main>

<?php
  do_action('get_footer');
  get_template_part('parts/site/footer');
?>
