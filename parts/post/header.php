<header class="entry-header">
  <h1 class="entry-title" itemprop="headline"><?php echo _base_title(); ?></h1>
</header>
<?php if (function_exists('sharing_display')) sharing_display('', true); ?>
<?php get_template_part('parts/post/thumb'); ?>
<?php get_template_part('parts/post/meta'); ?>
