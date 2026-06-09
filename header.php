<?php
/**
 * Site header.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

$tv_url = totostory_tv_page_url(array('토토스토리 스포츠tv', '토토스토리 스포츠TV', '스포츠TV', '스포츠중계'), '/tv/');
$highlight_url = totostory_tv_page_url(array('스포츠 다시보기', '스포츠다시보기', '다시보기', '하이라이트', '스포츠 하이라이트'), '/category/highlight/');
$live_score_url = totostory_tv_page_url(array('라이브스코어', '라이브 스코어', '실시간스코어'), '/#live');
$rank_url = totostory_tv_page_url(array('팀순위 확인', '팀순위', '팀 순위', '순위 확인'), '/#pages');
$result_url = totostory_tv_page_url(array('경기결과', '경기 결과', '결과'), '/#pages');
$analysis_url = totostory_tv_page_url(array('스포츠 분석', '스포츠분석', '분석'), '/category/analysis/');
$safe_site_url = totostory_tv_page_url(array('안전 토토사이트', '안전토토사이트', '안전 토토'), '/안전-토토사이트/');
$casino_url = totostory_tv_page_url(array('검증카지노', '검증 카지노', '카지노 검증'), '/검증카지노/');
$new_site_url = totostory_tv_category_url(array('신규 토토사이트', '신규토토사이트', '신규 검증'), '/category/신규-토토사이트/');
$info_url = totostory_tv_page_url(array('토토정보', '토토 정보', '베팅 가이드'), '/#pages');
$bad_site_url = totostory_tv_page_url(array('먹튀 사이트', '먹튀사이트', '먹튀 검증'), '/verification/');
$report_url = totostory_tv_page_url(array('먹튀제보', '먹튀 제보', '제보'), '/report/');

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

    <nav aria-label="<?php esc_attr_e('주요 메뉴', 'totostory-tv'); ?>" class="nav-links site-menu">
        <span class="nav-combo">
            <a href="<?php echo esc_url($tv_url); ?>"><?php esc_html_e('토토티비', 'totostory-tv'); ?></a>
            <span aria-hidden="true">|</span>
            <a href="<?php echo esc_url($highlight_url); ?>"><?php esc_html_e('하이라이트', 'totostory-tv'); ?></a>
        </span>
        <a href="<?php echo esc_url($live_score_url); ?>"><?php esc_html_e('라이브스코어', 'totostory-tv'); ?></a>
        <span class="nav-group">
            <button aria-haspopup="true" type="button"><?php esc_html_e('경기정보', 'totostory-tv'); ?></button>
            <span class="nav-dropdown" role="menu">
                <a href="<?php echo esc_url($rank_url); ?>" role="menuitem"><?php esc_html_e('팀순위 확인', 'totostory-tv'); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url($result_url); ?>" role="menuitem"><?php esc_html_e('경기결과', 'totostory-tv'); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url($analysis_url); ?>" role="menuitem"><?php esc_html_e('스포츠 분석', 'totostory-tv'); ?></a>
            </span>
        </span>
        <span class="nav-group">
            <button aria-haspopup="true" type="button"><?php esc_html_e('제휴업체', 'totostory-tv'); ?></button>
            <span class="nav-dropdown" role="menu">
                <a href="<?php echo esc_url($safe_site_url); ?>" role="menuitem"><?php esc_html_e('안전 토토사이트', 'totostory-tv'); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url($casino_url); ?>" role="menuitem"><?php esc_html_e('검증카지노', 'totostory-tv'); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url($new_site_url); ?>" role="menuitem"><?php esc_html_e('신규 토토사이트', 'totostory-tv'); ?></a>
            </span>
        </span>
        <span class="nav-group">
            <button aria-haspopup="true" type="button"><?php esc_html_e('토토정보', 'totostory-tv'); ?></button>
            <span class="nav-dropdown" role="menu">
                <a href="<?php echo esc_url($info_url); ?>" role="menuitem"><?php esc_html_e('토토정보', 'totostory-tv'); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url($bad_site_url); ?>" role="menuitem"><?php esc_html_e('먹튀 사이트', 'totostory-tv'); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url($report_url); ?>" role="menuitem"><?php esc_html_e('먹튀제보', 'totostory-tv'); ?></a>
            </span>
        </span>
    </nav>

    <div class="top-actions" aria-label="<?php esc_attr_e('빠른 실행', 'totostory-tv'); ?>">
        <a class="ghost-button" href="<?php echo esc_url($report_url); ?>"><?php esc_html_e('신고', 'totostory-tv'); ?></a>
        <a class="solid-button" href="<?php echo esc_url($live_score_url); ?>"><?php esc_html_e('라이브', 'totostory-tv'); ?></a>
    </div>
</header>
