<?php

// This is for loading css js
function university_files()
{
    // NULL -- does it depend on other scripts?
    // true -- do you want to load this file right under the closing body tag?
    // wp_enqueue_script('main-university-js', get_theme_file_uri( '/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    // wp_enqueue_style('university_main_styles', get_stylesheet_uri());


    // The check blow, is for checking the FQDN - if it is the dev one, serve from localhost:3000
    if (strstr($_SERVER['SERVER_NAME'], 'fictional-univercity.test')) {

        // For auto loading when changes are detected
        wp_enqueue_script('main-university-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
        wp_enqueue_script('main-university-js', get_theme_file_uri('/bundled-assets/scripts.f1a5ad65c8aa714ea43b.js'), NULL, '1.0', true);
        wp_enqueue_style('out-main-styles', get_theme_file_uri('/bundled-assets/styles.f1a5ad65c8aa714ea43b.css'));
    }
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'university_files');

// This is for telling wordpress to handle what the title is showing
function university_features()
{

    // The line below is for activating the option menus in Appearance tab in admin
    // How does it work: it registers a new menu location, in which, you can select a created custom menu
    // Thsi is particularly usefull for themes published for other people
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');

    // The same for the header location registered above, but for footer
    // register_nav_menu('footerLocationOne', 'Footer Location One');
    // register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
}

add_action('after_setup_theme', 'university_features');

/**
 * @param WP_Query $query
 */
// is_main_query says that this query is not the result of a custom query
function university_adjust_queries($query)
{

    if (!is_admin() and is_post_type_archive('program') and is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1); // all will be listed at once
    }


    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');

        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query',  array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }

}

add_action('pre_get_posts', 'university_adjust_queries');