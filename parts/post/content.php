<div class="page-section">
  <div class="container">
    <div class="clearfix mxn2">
      <div class="col md-col-8 px2">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class('post-article'); ?> itemscope itemtype="http://schema.org/BlogPosting">
            <header class="post-header">
              <h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
              <?php get_template_part('parts/post/meta'); ?>
            </header>
            <?php if (has_post_thumbnail()) printf(__('<div class="post-thumb">%s</div>'), get_the_post_thumbnail($post->ID, 'featured_img', ['itemprop' => 'image'])); ?>
            <main class="post-content" itemprop="text">
              <?php if (function_exists('sharing_display')) sharing_display('', true); ?>
              <?php the_content(); ?>
              <?php if (function_exists('sharing_display')) sharing_display('', true); ?>
            </main>
            <footer class="post-footer">
              <?php echo get_the_tag_list('<p class="post-tags">Tagged in: ', ', ', '</p>'); ?>
              <?php // wp_link_pages(array('before' => '<nav class="post-nav"><p>' . __('Pages:', '_base'), 'after' => '</p></nav>')); ?>
            </footer>
          </article>
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
          <?php comments_template('/parts/post/comments.php'); ?>
        <?php endwhile; ?>
        <?php if (function_exists('display_related_posts')) display_related_posts($post); ?>
      </div>
      <div class="col md-col-4 px2">
        <?php get_template_part('parts/sidebar/primary'); ?>
      </div>
    </div>
  </div>
</div>
