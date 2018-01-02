<article <?php post_class('entry'); ?> itemscope itemtype="http://schema.org/BlogPosting">
  <?php get_template_part('components/post/thumb'); ?>
  <header class="entry-header">
    <h2 class="entry-heading" itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
    <?php get_template_part('components/post/meta'); ?>
  </header>
  <div class="entry-excerpt">
    <?php the_excerpt(); ?>
  </div>
</article>
