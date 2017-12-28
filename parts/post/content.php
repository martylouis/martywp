<article <?php post_class('entry'); ?> itemscope itemtype="http://schema.org/BlogPosting">
  <?php get_template_part('parts/post/header'); ?>
  <?php get_template_part('parts/post/footer'); ?>
  <div class="entry-content" itemprop="text">
    <?php the_content(); ?>
  </div>
</article>
