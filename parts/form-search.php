<form role="search" method="get" class="form form-search" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="sr-only"><?php _e('Search for:', '_base'); ?></label>
  <div class="input-group">
    <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="form-control" placeholder="<?php _e('Search', '_base'); ?> <?php bloginfo('name'); ?>" required>
    <span class="input-group-btn">
      <button type="submit" class="button form-button"><?php _e('Search', '_base'); ?></button>
    </span>
  </div>
</form>
