<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package marty_wp
 */

get_header(); ?>

<main class="site-main">
  <div class="container">
    <div class="content">
      <header class="entry-header">
        <h1 class="entry-title"><?php echo _base_title(); ?></h1>
      </header>
      <div class="entry-content">
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
    </div>
    <?php get_sidebar(); ?>
  </div>
</main>

<?php get_footer();
