<?php
/**
 * The global footer for our theme
 *
 * @package marty_wp
 */

?>
<footer class="global-footer" role="contentinfo">
  <div class="container">
    <?php printf('<p><span>&copy; %1$s %2$s</span></p>', date('Y'), get_bloginfo('name')); ?>
  </div>
</footer>
</div>
<?php do_action('get_footer'); ?>
<?php wp_footer(); ?>
</body>
</html>
