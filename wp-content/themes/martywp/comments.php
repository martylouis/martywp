<!-- <section class="post-comments">
  <div class="comments-facebook">
    <?php // echo do_shortcode('[fbcomments url="" width="100%" count="off" num="3" countmsg="comments"]'); ?>
  </div>
</section> -->

<?php

  if (post_password_required()) {
    return;
  }
?>

<?php if (have_comments()) : ?>
  <section class="entry-comment" id="comments">
    <h2><?php printf(_nx('One response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'martywp'), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>'); ?></h2>

    <div>
      <ol class="comment-list">
        <?php wp_list_comments(array('style' => 'ol', 'short_ping' => true)); ?>
      </ol>
    </div>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav>
        <ul class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'martywp')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'martywp')); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </section>
<?php endif; // have_comments() ?>

<?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
  <div>
    <div class="alert alert-warning">
      <?php _e('Comments are closed.', 'martywp'); ?>
    </div>
  </div>
<?php endif; ?>

<?php comment_form(['class_form' => 'form form-comment']); ?>
