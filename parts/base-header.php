<header class="header p3 flex justify-between" role="banner">
  <div class="header-brand">
    <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
  </div>
  <nav class="header-nav" role="navigation">
    <?php
      if (has_nav_menu('header_menu')) :
        wp_nav_menu([
          'theme_location' => 'header_menu',
          'walker' => new _Base_Nav_Walker(),
          'menu_class' => 'nav m0 flex list-reset'
        ]);
      endif;
    ?>
  </nav>
</header>
