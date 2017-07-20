<?php get_template_part('parts/site/head'); ?>
<header id="top" class="site-header" role="banner">
  <div class="container">
    <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
    <nav id="header_menu" class="header-menu" role="navigation">
      <?php
        if (has_nav_menu('header_menu')) :
          wp_nav_menu([
            'theme_location' => 'header_menu',
            'walker' => new _Base_Nav_Walker(),
            'menu_class' => 'nav list-reset mm-nolistview',
          ]);
        endif;
      ?>
      <button class="header-menu-close">&times;</button>
    </nav>
    <button class="header-menu-toggle">&#x2630;</button>
  </div>
</header>
