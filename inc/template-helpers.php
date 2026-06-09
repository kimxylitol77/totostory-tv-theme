<?php
/**
 * Template helpers.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

function totostory_tv_asset(string $path): string
{
    return esc_url(TOTOSTORY_TV_URI . '/' . ltrim($path, '/'));
}

function totostory_tv_meta(int $post_id, string $key, string $fallback = ''): string
{
    $value = get_post_meta($post_id, $key, true);

    if (is_scalar($value) && '' !== (string) $value) {
        return (string) $value;
    }

    return $fallback;
}

function totostory_tv_reading_time(int $post_id = 0): string
{
    $post = get_post($post_id ?: get_the_ID());

    if (!$post) {
        return __('3분', 'totostory-tv');
    }

    $words = preg_split('/\s+/u', wp_strip_all_tags($post->post_content));
    $count = is_array($words) ? count(array_filter($words)) : 0;
    $minutes = max(1, (int) ceil($count / 320));

    return sprintf(__('%d분', 'totostory-tv'), $minutes);
}

function totostory_tv_category_label(int $post_id = 0): string
{
    $categories = get_the_category($post_id ?: get_the_ID());

    if (!empty($categories)) {
        return $categories[0]->name;
    }

    return get_post_type_object(get_post_type($post_id ?: get_the_ID()))->labels->singular_name ?? __('글', 'totostory-tv');
}

function totostory_tv_first_populated_menu_id(): int
{
    $menus = wp_get_nav_menus();

    foreach ($menus as $menu) {
        $items = wp_get_nav_menu_items($menu->term_id);

        if (!empty($items)) {
            return (int) $menu->term_id;
        }
    }

    return 0;
}

function totostory_tv_primary_menu_args(): array
{
    $args = array(
        'container' => false,
        'menu_class' => 'nav-links',
        'fallback_cb' => 'totostory_tv_primary_menu_fallback',
    );
    $locations = get_nav_menu_locations();

    if (!empty($locations['primary'])) {
        $args['theme_location'] = 'primary';

        return $args;
    }

    $menu_id = totostory_tv_first_populated_menu_id();

    if ($menu_id) {
        $args['menu'] = $menu_id;
    }

    return $args;
}

function totostory_tv_normalize_title(string $title, bool $remove_spaces = false): string
{
    $title = wp_strip_all_tags($title);
    $title = preg_replace('/\s+/u', ' ', trim($title));

    if ($remove_spaces) {
        $title = preg_replace('/\s+/u', '', $title);
    }

    return function_exists('mb_strtolower') ? mb_strtolower($title, 'UTF-8') : strtolower($title);
}

function totostory_tv_all_pages(): array
{
    static $pages = null;

    if (null === $pages) {
        $pages = get_pages(
            array(
                'post_status' => 'publish',
                'sort_column' => 'menu_order,post_title',
                'sort_order' => 'ASC',
            )
        );
    }

    return is_array($pages) ? $pages : array();
}

function totostory_tv_find_page_by_titles(array $titles): ?WP_Post
{
    $pages = totostory_tv_all_pages();
    $targets = array();
    $compact_targets = array();

    foreach ($titles as $title) {
        $targets[] = totostory_tv_normalize_title((string) $title);
        $compact_targets[] = totostory_tv_normalize_title((string) $title, true);
    }

    foreach ($pages as $page) {
        if (in_array(totostory_tv_normalize_title($page->post_title), $targets, true)) {
            return $page;
        }
    }

    foreach ($pages as $page) {
        if (in_array(totostory_tv_normalize_title($page->post_title, true), $compact_targets, true)) {
            return $page;
        }
    }

    return null;
}

function totostory_tv_page_url(array $titles, string $fallback = '/'): string
{
    $page = totostory_tv_find_page_by_titles($titles);

    if ($page) {
        return get_permalink($page);
    }

    if (preg_match('#^https?://#', $fallback)) {
        return $fallback;
    }

    return home_url($fallback);
}

function totostory_tv_legacy_page_groups(): array
{
    return array(
        array(
            'label' => __('토토스토리 스포츠tv', 'totostory-tv'),
            'titles' => array('토토스토리 스포츠tv', '토토스토리 스포츠TV', '스포츠TV', '스포츠 티비', '스포츠중계'),
            'fallback' => '/tv/',
        ),
        array(
            'label' => __('스포츠 다시보기', 'totostory-tv'),
            'titles' => array('스포츠 다시보기', '스포츠다시보기', '다시보기', '하이라이트'),
            'fallback' => '/category/highlight/',
        ),
        array(
            'label' => __('팀순위 확인', 'totostory-tv'),
            'titles' => array('팀순위 확인', '팀순위', '팀 순위', '순위 확인'),
            'fallback' => '',
        ),
        array(
            'label' => __('경기결과', 'totostory-tv'),
            'titles' => array('경기결과', '경기 결과', '결과'),
            'fallback' => '',
        ),
        array(
            'label' => __('라이브스코어', 'totostory-tv'),
            'titles' => array('라이브스코어', '라이브 스코어', '실시간스코어'),
            'fallback' => '/#live',
        ),
        array(
            'label' => __('안전 토토사이트', 'totostory-tv'),
            'titles' => array('안전 토토사이트', '안전토토사이트', '안전 토토'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('검증카지노', 'totostory-tv'),
            'titles' => array('검증카지노', '검증 카지노', '카지노 검증'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('토토정보', 'totostory-tv'),
            'titles' => array('토토정보', '토토 정보', '베팅 가이드'),
            'fallback' => '',
        ),
        array(
            'label' => __('먹튀 사이트', 'totostory-tv'),
            'titles' => array('먹튀 사이트', '먹튀사이트', '먹튀 검증'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('신규 토토사이트', 'totostory-tv'),
            'titles' => array('신규 토토사이트', '신규토토사이트', '신규 검증'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('스포츠 분석', 'totostory-tv'),
            'titles' => array('스포츠 분석', '스포츠분석', '분석'),
            'fallback' => '/category/analysis/',
        ),
        array(
            'label' => __('먹튀제보', 'totostory-tv'),
            'titles' => array('먹튀제보', '먹튀 제보', '제보'),
            'fallback' => '/report/',
        ),
    );
}

function totostory_tv_legacy_page_links(int $limit = 12): array
{
    $links = array();
    $used_urls = array();

    foreach (totostory_tv_legacy_page_groups() as $group) {
        $page = totostory_tv_find_page_by_titles($group['titles']);
        $url = '';
        $title = (string) $group['label'];
        $excerpt = '';
        $id = 0;

        if ($page) {
            $id = (int) $page->ID;
            $title = get_the_title($page);
            $url = get_permalink($page);
            $excerpt = get_the_excerpt($page);
        } elseif (!empty($group['fallback'])) {
            $url = home_url((string) $group['fallback']);
        }

        if (!$url || isset($used_urls[$url])) {
            continue;
        }

        $links[] = array(
            'id' => $id,
            'title' => $title,
            'url' => $url,
            'excerpt' => $excerpt,
        );
        $used_urls[$url] = true;
    }

    foreach (totostory_tv_all_pages() as $page) {
        if (count($links) >= $limit) {
            break;
        }

        $url = get_permalink($page);

        if (!$url || isset($used_urls[$url])) {
            continue;
        }

        $links[] = array(
            'id' => (int) $page->ID,
            'title' => get_the_title($page),
            'url' => $url,
            'excerpt' => get_the_excerpt($page),
        );
        $used_urls[$url] = true;
    }

    return array_slice($links, 0, $limit);
}

function totostory_tv_query_posts(int $count = 4): WP_Query
{
    return new WP_Query(
        array(
            'post_type' => 'post',
            'posts_per_page' => $count,
            'ignore_sticky_posts' => true,
        )
    );
}

function totostory_tv_query_matches(int $count = 3): WP_Query
{
    return new WP_Query(
        array(
            'post_type' => 'tv_match',
            'posts_per_page' => $count,
            'meta_key' => '_totostory_match_time',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        )
    );
}

function totostory_tv_query_reports(int $count = 3): WP_Query
{
    return new WP_Query(
        array(
            'post_type' => 'safety_report',
            'posts_per_page' => $count,
        )
    );
}
