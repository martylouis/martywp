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
 * @package martywp
 */

get_template_part('components/site/header'); ?>


<div class="container">
  <div class="grid">
    <div class="content">
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('components/page/content'); ?>
      <?php endwhile; ?>
    </div>
    <?php get_template_part('components/page/sidebar'); ?>
  </div>
</div>


<?php get_template_part('components/site/footer');
