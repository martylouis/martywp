<?php if (get_the_author_meta('description')) : ?>

<div class="post-author-meta">
  <div class="post-author-meta-avatar">
    <?php echo get_avatar(get_the_author_meta('ID')); ?>
  </div>
  <div class="post-author-meta-body">
    <h3 class="post-author-meta-heading"><?php printf(__('About %s', '_base'), get_the_author_meta('display_name')); ?></h3>
    <div class="post-author-meta-bio">
      <?php printf(__('%s', '_base'), apply_filters('the_content', get_the_author_meta('description'))); ?>
    </div>
  </div>
</div>

<?php endif;
