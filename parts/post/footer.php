<footer class="post-footer">
  <?php if (function_exists('sharing_display')) sharing_display('', true); ?>
  <?php echo get_the_tag_list('<p class="post-tags">Tagged in: ', ', ', '</p>'); ?>
  <?php get_template_part('parts/post/author'); ?>
  <?php comments_template('/parts/post/comments.php'); ?>
  <h3 class="post-list-heading">Related Posts</h3>
  <div class="post-list post-list-related">
    <?php PostUtils::related($post, 2); ?>
  </div>
</footer>
