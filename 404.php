<?php get_template_part('components/site/header'); ?>
<div class="container">
  <main class="site-main">
    <div class="main-content">
      <header class="page-header">
        <h1 class="page-title"><?php echo _base_title(); ?></h1>
      </header>
      <div class="alert">
        <?php _e('Sorry, but the page you were trying to view does not exist.', '_base'); ?>
      </div>
      <p><?php _e('It looks like this was the result of either:', '_base'); ?></p>
      <ul>
        <li><?php _e('a mistyped address', '_base'); ?></li>
        <li><?php _e('an out-of-date link', '_base'); ?></li>
      </ul>
      <?php get_search_form(); ?>
    </div>
  </main>
</div>
<?php get_template_part('components/site/footer'); ?>
