<?php if (get_the_author_meta('description')) : ?>

<div class="entry-author">
  <div class="entry-author-avatar">
    <?php echo get_avatar(get_the_author_meta('ID')); ?>
  </div>
  <div class="entry-author-content">
    <h3 class="entry-author-heading">
      <?php printf(__('About %s', 'martywp'), get_the_author_meta('display_name')); ?>
    </h3>
    <div class="entry-author-desc">
      <?php printf(__('%s', 'martywp'), apply_filters('the_content', get_the_author_meta('description'))); ?>
    </div>
  </div>
</div>

<?php endif;
