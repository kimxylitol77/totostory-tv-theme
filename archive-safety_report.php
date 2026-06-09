<?php
/**
 * Safety report archive.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="site-shell page-shell">
    <section class="post-hero">
        <div>
            <p class="eyebrow">SAFETY DESK</p>
            <h1><?php esc_html_e('검증 리포트', 'totostory-tv'); ?></h1>
            <p><?php esc_html_e('신규 사이트 점검, 회원 제보, 도메인 이력, 운영 상태를 정리하는 검증 리포트 아카이브입니다.', 'totostory-tv'); ?></p>
        </div>
        <aside>
            <span><?php esc_html_e('등록된 리포트', 'totostory-tv'); ?></span>
            <strong><?php echo esc_html((string) $GLOBALS['wp_query']->found_posts); ?><?php esc_html_e('개', 'totostory-tv'); ?></strong>
        </aside>
    </section>

    <section class="report-section report-archive">
        <div class="report-layout">
            <div class="report-list">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/report-card'); ?>
                    <?php endwhile; ?>
                    <?php the_posts_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part('template-parts/empty'); ?>
                <?php endif; ?>
            </div>
            <aside class="safety-note">
                <p><?php esc_html_e('책임 이용 원칙', 'totostory-tv'); ?></p>
                <h2><?php esc_html_e('확인되지 않은 링크와 과도한 참여를 멀리하세요.', 'totostory-tv'); ?></h2>
                <ul>
                    <li><?php esc_html_e('도메인 개설일과 변경 이력을 먼저 확인', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('제보 자료는 개인정보를 가린 상태로 보관', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('검증 상태는 운영자가 관리자에서 직접 갱신', 'totostory-tv'); ?></li>
                </ul>
            </aside>
        </div>
    </section>
</main>
<?php
get_footer();
