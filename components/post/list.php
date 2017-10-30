<article <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting">
  <?php get_template_part('components/post/thumb'); ?>
  <header class="entry-header">
    <h2 class="entry-heading" itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>
  <div class="entry-excerpt">
    <?php the_excerpt(); ?>
  </div>
  <footer class="entry-footer">
    <div class="entry-read-more">
      <a href="<?php echo the_permalink(); ?>" class="button"><?php _e('Read More &rarr;', '_base'); ?></a>
    </div>
    <?php get_template_part('components/post/meta'); ?>
  </footer>
</article>
