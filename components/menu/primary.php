<?php
include_once('walker.php');

// use MartyWP\Components\Menu;

?>

<nav id="menu_primary" class="menu-primary" role="navigation">
  <button class="header-menu-toggle">&#x2630;</button>
  <?php
    if (has_nav_menu('menu_primary')) :
      wp_nav_menu([
        'theme_location' => 'menu_primary',
        'walker' => new MartyWP_Walker(),
        'menu_class' => 'nav mm-nolistview',
      ]);
    endif;
  ?>
  <button class="header-menu-close">&times;</button>
</nav>
