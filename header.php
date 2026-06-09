<?php
/**
 * Site header.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('totostory_tv_primary_menu_fallback')) {
    function totostory_tv_primary_menu_fallback(): void
    {
        ?>
        <nav aria-label="<?php esc_attr_e('주요 메뉴', 'totostory-tv'); ?>" class="nav-links">
            <a href="<?php echo esc_url(home_url('/#live')); ?>"><?php esc_html_e('중계센터', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/')); ?>"><?php esc_html_e('최신글', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(totostory_tv_page_url(array('토토스토리 스포츠tv', '토토스토리 스포츠TV', '스포츠TV', '스포츠중계'), '/tv/')); ?>"><?php esc_html_e('스포츠중계', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(totostory_tv_page_url(array('검증카지노', '안전 토토사이트', '먹튀 사이트'), '/verification/')); ?>"><?php esc_html_e('검증리포트', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(home_url('/#community')); ?>"><?php esc_html_e('커뮤니티', 'totostory-tv'); ?></a>
        </nav>
        <?php
    }
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="topbar">
    <a aria-label="<?php esc_attr_e('토토스토리 홈', 'totostory-tv'); ?>" class="brand" href="<?php echo esc_url(home_url('/')); ?>">
        <span class="brand-mark">T</span>
        <span>
            <strong><?php bloginfo('name'); ?></strong>
            <small>sports safety desk</small>
        </span>
    </a>

    <nav aria-label="<?php esc_attr_e('핵심 바로가기', 'totostory-tv'); ?>" class="header-feature-links">
        <a href="<?php echo esc_url(totostory_tv_page_url(array('토토스토리 스포츠tv', '토토스토리 스포츠TV', '스포츠TV', '스포츠중계'), '/tv/')); ?>"><?php esc_html_e('토토티비', 'totostory-tv'); ?></a>
        <span aria-hidden="true">|</span>
        <a href="<?php echo esc_url(totostory_tv_page_url(array('스포츠 다시보기', '스포츠다시보기', '하이라이트'), '/category/highlight/')); ?>"><?php esc_html_e('하이라이트', 'totostory-tv'); ?></a>
    </nav>

    <?php wp_nav_menu(totostory_tv_primary_menu_args()); ?>

    <div class="top-actions" aria-label="<?php esc_attr_e('빠른 실행', 'totostory-tv'); ?>">
        <a class="ghost-button" href="<?php echo esc_url(totostory_tv_page_url(array('먹튀제보', '먹튀 제보'), '/report/')); ?>"><?php esc_html_e('신고', 'totostory-tv'); ?></a>
        <a class="solid-button" href="<?php echo esc_url(totostory_tv_page_url(array('라이브스코어', '라이브 스코어'), '/#live')); ?>"><?php esc_html_e('라이브', 'totostory-tv'); ?></a>
    </div>
</header>
