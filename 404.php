<?php get_template_part('parts/page/header'); ?>
<div class="alert">
  <?php _e('Sorry, but the page you were trying to view does not exist.', '_base'); ?>
</div>

<p><?php _e('It looks like this was the result of either:', '_base'); ?></p>
<ul>
  <li><?php _e('a mistyped address', '_base'); ?></li>
  <li><?php _e('an out-of-date link', '_base'); ?></li>
</ul>
<?php get_search_form(); ?>
