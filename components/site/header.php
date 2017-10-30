<?php get_template_part('components/site/head'); ?>
<header id="top" class="site-header" role="banner">
  <div class="container">
    <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
    <?php get_template_part('components/menu/primary'); ?>
  </div>
</header>
