<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package marty_wp
 */

get_header(); ?>

<main class="main">
  <div class="container">
    <div class="content">
    <?php while (have_posts()) : the_post(); ?>
      <div <?php post_class('entry'); ?>>
        <header class="entry-header">
          <h1 class="entry-title" itemprop="headline">
            <?php echo _base_title(); ?>
          </h1>
        </header>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
</main>

<?php get_footer();
