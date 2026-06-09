<?php
/**
 * Custom post types.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

function totostory_tv_register_post_types(): void
{
    register_post_type(
        'tv_match',
        array(
            'labels' => array(
                'name' => __('중계 일정', 'totostory-tv'),
                'singular_name' => __('중계 일정', 'totostory-tv'),
                'add_new_item' => __('중계 일정 추가', 'totostory-tv'),
                'edit_item' => __('중계 일정 편집', 'totostory-tv'),
            ),
            'public' => true,
            'menu_icon' => 'dashicons-video-alt3',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'tv'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'safety_report',
        array(
            'labels' => array(
                'name' => __('검증 리포트', 'totostory-tv'),
                'singular_name' => __('검증 리포트', 'totostory-tv'),
                'add_new_item' => __('검증 리포트 추가', 'totostory-tv'),
                'edit_item' => __('검증 리포트 편집', 'totostory-tv'),
            ),
            'public' => true,
            'menu_icon' => 'dashicons-shield-alt',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'verification'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'totostory_tv_register_post_types');
