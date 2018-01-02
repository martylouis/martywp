<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package martywp
 */

get_template_part('components/header/primary'); ?>

<div class="container">
  <div class="grid">
    <div class="content">
      <div class="entry">
        <?php get_template_part('components/page/header'); ?>
        <div class="entry-content">
          <div class="alert">
            <?php _e('Sorry, but the page you were trying to view does not exist.', 'martywp'); ?>
          </div>
          <p><?php _e('It looks like this was the result of either:', 'martywp'); ?></p>
          <ul>
            <li><?php _e('a mistyped address', 'martywp'); ?></li>
            <li><?php _e('an out-of-date link', 'martywp'); ?></li>
          </ul>
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
    <?php get_template_part('components/sidebar/primary'); ?>
  </div>
</div>

<?php get_template_part('components/footer/primary');
