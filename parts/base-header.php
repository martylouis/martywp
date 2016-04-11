<header class="header" role="banner">

    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <div class="header-brand">
      <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    </div>

    <nav class="navbar navbar-collapse collapse" role="navigation">
      <?php
        if (has_nav_menu('header_menu')) :
          wp_nav_menu(array('theme_location' => 'header_menu', 'walker' => new _Base_Nav_Walker(), 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>

</header>
