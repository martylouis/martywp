<?php

use martywp\utils;

?>

<form role="search" method="get" class="form form-search" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="sr-only"><?php _e('Search for:', 'martywp'); ?></label>
  <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="form-input" placeholder="<?php _e('Search...', 'martywp'); ?>" required>
  <button type="submit" class="form-submit">
    <span class="text-hide"><?php _e('Search', 'martywp'); ?></span>
    <?php utils::the_svg('search'); ?>
  </button>
</form>
