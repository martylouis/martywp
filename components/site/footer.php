    <footer class="site-footer" role="contentinfo">
      <div class="container">
        <?php printf('<p><span class="text-small">&copy; %1$s %2$s</span></p>', date('Y'), get_bloginfo('name')); ?>
      </div>
    </footer>
  </div>
<?php do_action('get_footer'); ?>
<?php wp_footer(); ?>
</body>
</html>