<?php use MartyWP\Lib\Utils; ?>

<footer class="post-footer">
  <?php

  if (function_exists('sharing_display')) :
    sharing_display('', true);
  endif;

  echo get_the_tag_list('<p class="post-tags">Tagged in: ', ', ', '</p>');

  get_template_part('components/post/author');

  if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

  ?>

  <h3 class="post-list-heading">Related Posts</h3>
  <div class="post-list post-list-related">
    <?php Utils::related_posts($post, 2); ?>
  </div>

</footer>
