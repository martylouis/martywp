<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package marty_wp
 */

get_header(); ?>
<main class="main">
  <div class="container">
    <div class="content">
      <?php
        while (have_posts()) : the_post();
          get_template_part('parts/post/content', get_post_format());
        endwhile;
       ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
</main>
<?php
get_footer();
