<?php if (has_post_thumbnail()) printf(__('<div class="entry-thumb">%s</div>'), get_the_post_thumbnail($post->ID, 'featured_img', ['itemprop' => 'image'])); ?>
