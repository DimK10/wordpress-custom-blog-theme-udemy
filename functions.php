<?php 

  // This is for loading css js
  function university_files() {
    // NULL -- does it depend on other scripts?
    // true -- do you want to load this file right under the closing body tag?
    wp_enqueue_script('main-university-js', get_theme_file_uri( '/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
  }

  add_action( 'wp_enqueue_scripts', 'university_files');

  // This is for telling wordpress to handle what the title is showing
  function university_features() {
    add_theme_support('title-tag');
  }

  add_action('after_setup_theme', 'university_features');