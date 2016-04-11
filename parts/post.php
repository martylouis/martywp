<li>
  <article <?php post_class('post-article'); ?>>
    <?php get_template_part('parts/post', 'thumb'); ?>
    <?php get_template_part('parts/post', 'header'); ?>
    <div class="post-excerpt">
      <?php the_excerpt(); ?>
    </div>
  </article>
</li>
