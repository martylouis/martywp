<form role="search" method="get" class="form form-search" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="sr-only"><?php _e('Search for:', '_base'); ?></label>
  <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="form-input" placeholder="<?php _e('Search', '_base'); ?> <?php bloginfo('name'); ?>" required>
  <button type="submit" class="form-submit">
    <span class="hide"><?php _e('Search', '_base'); ?></span>
    <?php _svg('search'); ?>
  </button>
</form>
