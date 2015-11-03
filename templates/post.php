<li>
  <article <?php post_class('post-article'); ?>>
    <?php get_template_part('templates/post', 'thumb'); ?>
    <?php get_template_part('templates/post', 'header'); ?>
    <div class="post-excerpt">
      <?php the_excerpt(); ?>
    </div>
  </article>
</li>
