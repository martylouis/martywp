<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
<?php wp_head(); ?>
<?php do_action('get_header'); ?>
</head>
<body <?php body_class(); ?>>
<div id="document" class="document">
<!--[if lt IE 11]>
  <div class="browser-warning">
    You are using an <strong>outdated</strong> browser. Please <a href="<?php echo esc_url('http://browsehappy.com/') ?>">upgrade your browser</a> to improve your experience.
  </div>
<![endif]-->
<div style="position: absolute; width: 0; height: 0;"><?php get_template_part('assets/dist/svg'); ?></div>
