<?php while (have_posts()) : the_post(); ?>
  <div class="container">
    <main class="site-main">
      <article <?php post_class('main-content'); ?> itemscope itemtype="http://schema.org/BlogPosting">
        <?php get_template_part('components/post/header'); ?>
        <?php get_template_part('components/post/thumb'); ?>
        <?php get_template_part('components/post/meta'); ?>
        <div class="entry-content" itemprop="text">
          <?php if (function_exists('sharing_display')) sharing_display('', true); ?>
          <?php the_content(); ?>
          <?php if (function_exists('sharing_display')) sharing_display('', true); ?>
        </div>
        <footer class="entry-footer">
          <?php echo get_the_tag_list('<p class="post-tags">Tagged in: ', ', ', '</p>'); ?>
          <?php // wp_link_pages(array('before' => '<nav class="post-nav"><p>' . __('Pages:', '_base'), 'after' => '</p></nav>')); ?>
          <?php get_template_part('components/post/author'); ?>
          <?php comments_template('/components/post/comments.php'); ?>
          <h3 class="post-list-heading">Related Posts</h3>
          <div class="post-list post-list-related"><?php PostUtils::related($post, 2); ?></div>
        </footer>
      </article>
      <div class="main-sidebar">
        <?php get_template_part('components/sidebar/primary'); ?>
      </div>
    </main>
  </div>
<?php endwhile; ?>
