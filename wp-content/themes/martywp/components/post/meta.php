<?php

use martywp\utils;

$post_time = get_the_time('c');
$post_date = get_the_date('F n, Y');
$time_html = sprintf('<time itemprop="datePublished" content="%1$s">%2$s</time>', $post_time, $post_date);

$post_auth = get_the_author_meta('display_name');;
$post_auth_link = get_author_posts_url(get_the_author_meta('ID'));
$author_html = sprintf('<a href="%1$s"><span itemprop="author">%2$s</span></a>', $post_auth_link, $post_auth);

$comment_count = get_comments_number();
$comment__n = sprintf(_n('%s Comment', '%s Comments', $comment_count, 'martywp'), number_format_i18n( $comment_count ));
$comment_html = '
  | <a href="%s#comments" class="entry-meta-comments">
    %s %s
  </a>
';
$comment_output = $comment_count > 0 ? sprintf($comment_html, get_the_permalink(), utils::get_svg('comment'), $comment__n ) : '';

?>

<p class="entry-meta">
  <?php printf(__('By %s on %s %s'), $author_html, $time_html, $comment_output); ?>
</p>
