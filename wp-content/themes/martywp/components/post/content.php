<article <?php post_class('entry'); ?> itemscope itemtype="http://schema.org/BlogPosting">
  <?php get_template_part('components/post/header'); ?>
  <div class="entry-content" itemprop="text">
    <?php the_content(); ?>
  </div>
  <?php get_template_part('components/post/footer'); ?>
</article>
