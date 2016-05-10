<header class="header" role="banner">
  <div class="header-brand">
    <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
  </div>
  <nav class="navbar" role="navigation">
    <?php
      if (has_nav_menu('header_menu')) :
        wp_nav_menu([
          'theme_location' => 'header_menu',
          'walker' => new _Base_Nav_Walker(),
          'menu_class' => 'nav navbar-nav'
        ]);
      endif;
    ?>
  </nav>
</header>
