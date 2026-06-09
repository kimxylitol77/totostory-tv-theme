<?php
/**
 * TotoStory TV theme functions.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TOTOSTORY_TV_VERSION', '0.1.0');
define('TOTOSTORY_TV_DIR', get_template_directory());
define('TOTOSTORY_TV_URI', get_template_directory_uri());

require_once TOTOSTORY_TV_DIR . '/inc/post-types.php';
require_once TOTOSTORY_TV_DIR . '/inc/meta-boxes.php';
require_once TOTOSTORY_TV_DIR . '/inc/template-helpers.php';

function totostory_tv_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support(
        'html5',
        array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script')
    );

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'totostory-tv'),
            'footer' => __('Footer Menu', 'totostory-tv'),
        )
    );
}
add_action('after_setup_theme', 'totostory_tv_setup');

function totostory_tv_enqueue_assets(): void
{
    wp_enqueue_style(
        'totostory-tv-theme',
        TOTOSTORY_TV_URI . '/assets/css/theme.css',
        array(),
        TOTOSTORY_TV_VERSION
    );

    wp_enqueue_style('totostory-tv-style', get_stylesheet_uri(), array('totostory-tv-theme'), TOTOSTORY_TV_VERSION);

    wp_enqueue_script(
        'totostory-tv-main',
        TOTOSTORY_TV_URI . '/assets/js/main.js',
        array(),
        TOTOSTORY_TV_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'totostory_tv_enqueue_assets');

function totostory_tv_excerpt_length(int $length): int
{
    return 34;
}
add_filter('excerpt_length', 'totostory_tv_excerpt_length');

function totostory_tv_excerpt_more(string $more): string
{
    return '...';
}
add_filter('excerpt_more', 'totostory_tv_excerpt_more');
