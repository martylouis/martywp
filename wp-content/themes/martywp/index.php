<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package martywp
 */

get_template_part('components/site/header'); ?>

<div class="container">
  <div class="grid">
    <div class="content">
      <?php if (!have_posts()) : ?>
        <div class="alert alert-warning">
          <?php _e('Sorry, no results were found.', 'martywp'); ?>
        </div>
        <?php get_search_form(); ?>
      <?php endif; ?>
      <?php get_template_part('components/page/header'); ?>
      <div class="entry-list">
        <?php
          while (have_posts()) : the_post();
            get_template_part('components/post/list', get_post_format());
          endwhile;
        ?>
      </div>
      <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
    </div>
    <?php get_template_part('components/page/sidebar'); ?>
  </div>
</div>

<?php get_template_part('components/site/footer'); ?>
