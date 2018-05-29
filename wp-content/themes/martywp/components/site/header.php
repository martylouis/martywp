<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
  <?php wp_head(); ?>
  <?php do_action('get_header'); ?>
</head>
<body <?php body_class(); ?> itemscope="1" itemtype="http://schema.org/WebPage">
  <!--[if lte IE 11]> <div class="browser-warning"> You are using an <strong>outdated</strong> browser. Please <a href="<?php echo esc_url('http://browsehappy.com/') ?>">upgrade your browser</a> to improve your experience. </div> <![endif]-->
  <div id="svg_sprite" style="position: absolute; width: 0; height: 0;"><?php get_template_part('assets/dist/svg'); ?></div>
  <div id="site" class="site--wrapper">

    <header id="top" class="header-primary" role="banner">
      <div class="container">
        <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
        <?php get_template_part('components/site/header', 'nav'); ?>
      </div>
    </header>

    <main class="main">
