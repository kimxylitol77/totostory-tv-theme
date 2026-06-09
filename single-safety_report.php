<?php
/**
 * Single safety report.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="site-shell page-shell">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $post_id = get_the_ID();
        $status = totostory_tv_meta($post_id, '_totostory_report_status', __('검토', 'totostory-tv'));
        $domain = totostory_tv_meta($post_id, '_totostory_report_domain', __('도메인 확인 중', 'totostory-tv'));
        $reviewed_at = totostory_tv_meta($post_id, '_totostory_reviewed_at', get_the_date('Y.m.d'));
        ?>
        <article <?php post_class('post-detail'); ?>>
            <nav aria-label="<?php esc_attr_e('현재 위치', 'totostory-tv'); ?>" class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('홈', 'totostory-tv'); ?></a>
                <span>/</span>
                <a href="<?php echo esc_url(home_url('/verification/')); ?>"><?php esc_html_e('검증 리포트', 'totostory-tv'); ?></a>
                <span>/</span>
                <strong><?php echo esc_html($status); ?></strong>
            </nav>

            <header class="post-detail-head">
                <span class="post-category"><?php echo esc_html($status); ?></span>
                <h1><?php the_title(); ?></h1>
                <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <div class="post-meta">
                    <span><?php echo esc_html($domain); ?></span>
                    <span><?php echo esc_html($reviewed_at); ?></span>
                    <span><?php esc_html_e('검증 데스크', 'totostory-tv'); ?></span>
                </div>
            </header>

            <section class="summary-box">
                <h2><?php esc_html_e('검증 요약', 'totostory-tv'); ?></h2>
                <ul>
                    <li><?php esc_html_e('상태 배지는 관리자 입력값으로 표시됩니다.', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('본문에는 제보 근거, 확인 과정, 운영자 의견을 정리하세요.', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('확인되지 않은 정보는 단정적으로 표현하지 않는 편이 안전합니다.', 'totostory-tv'); ?></li>
                </ul>
            </section>

            <div class="article-body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
