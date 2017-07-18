<?php  while (have_posts()) : the_post(); ?>
  <?php get_template_part('parts/page/header'); ?>
  <section class="page-section">
    <div class="container">
      <div class="clearfix mxn2">
        <div class="col md-col-8 px2">
            <article <?php post_class('post-article'); ?>>
              <?php the_content(); ?>
            </article>
        </div>
        <div class="col md-col-4 px2">
          <?php get_template_part('parts/sidebar/primary'); ?>
        </div>
      </div>
    </div>
  </section>
<?php endwhile; ?>
