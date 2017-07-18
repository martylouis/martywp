<?php

  // This `part` to be used only inside of loop!

  // Set a {post_type}-header class if it has a post type
  // $header_post_class = ! empty(get_post_type()) && !is_page() ? ' ' . get_post_type() . '-header' : '';

  $class = has_post_thumbnail() ? 'page-header has-thumb' : 'page-header';

  // echo sprintf($header_html, $header_bg_class, $header_style); ?>
<header class="<?php echo $class ?>">
  <div class="container">
    <h1 class="page-title"><?php echo _base_title(); ?></h1>
  </div>
</header>
