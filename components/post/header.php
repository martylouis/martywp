<?php

use MartyWP\Lib\Utils;

?>

<header class="entry-header">
  <h1 class="entry-title" itemprop="headline"><?php echo Utils::title(); ?></h1>
</header>
<?php if (function_exists('sharing_display')) sharing_display('', true); ?>
<?php get_template_part('components/post/thumb'); ?>
<?php get_template_part('components/post/meta'); ?>
