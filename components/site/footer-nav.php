<nav class="nav-secondary" role="navigation" id="footer_nav">
  <?php
    if (has_nav_menu('footer_nav')) :
      wp_nav_menu([
        'theme_location' => 'footer_nav',
        'menu_class' => 'nav',
      ]);
    endif;
  ?>
</nav>
