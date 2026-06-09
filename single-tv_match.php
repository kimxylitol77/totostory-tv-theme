<?php
/**
 * Single TV match template.
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
        $embed_url = totostory_tv_meta($post_id, '_totostory_embed_url');
        $authorized_url = totostory_tv_meta($post_id, '_totostory_authorized_url');
        $source_label = totostory_tv_meta($post_id, '_totostory_source_label', __('공식 링크 보기', 'totostory-tv'));
        ?>
        <article <?php post_class('post-detail tv-detail'); ?>>
            <nav aria-label="<?php esc_attr_e('현재 위치', 'totostory-tv'); ?>" class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('홈', 'totostory-tv'); ?></a>
                <span>/</span>
                <a href="<?php echo esc_url(home_url('/tv/')); ?>"><?php esc_html_e('스포츠중계', 'totostory-tv'); ?></a>
                <span>/</span>
                <strong><?php the_title(); ?></strong>
            </nav>

            <header class="post-detail-head">
                <span class="post-category"><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_league', __('중계 일정', 'totostory-tv'))); ?></span>
                <h1><?php the_title(); ?></h1>
                <p><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_signal', get_the_excerpt())); ?></p>
                <div class="post-meta">
                    <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_sport', __('스포츠', 'totostory-tv'))); ?></span>
                    <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_time', __('시간 미정', 'totostory-tv'))); ?></span>
                    <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_status', __('예정', 'totostory-tv'))); ?></span>
                </div>
            </header>

            <section class="tv-player">
                <?php if ($embed_url) : ?>
                    <iframe
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen
                        loading="lazy"
                        src="<?php echo esc_url($embed_url); ?>"
                        title="<?php echo esc_attr(get_the_title()); ?>"
                    ></iframe>
                <?php else : ?>
                    <div class="player-placeholder">
                        <strong><?php esc_html_e('중계 소스 연결 대기', 'totostory-tv'); ?></strong>
                        <span><?php esc_html_e('관리자에서 공식/허가된 임베드 URL을 입력하면 이 영역에 표시됩니다.', 'totostory-tv'); ?></span>
                    </div>
                <?php endif; ?>
            </section>

            <section class="summary-box">
                <h2><?php esc_html_e('중계 안내', 'totostory-tv'); ?></h2>
                <ul>
                    <li><?php esc_html_e('이 테마는 무단 스트림을 포함하지 않습니다.', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('공식 링크 또는 권한 있는 임베드만 관리자에서 직접 연결하세요.', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('경기 정보와 분석 본문은 워드프레스 에디터에서 관리합니다.', 'totostory-tv'); ?></li>
                </ul>
                <?php if ($authorized_url) : ?>
                    <a class="primary-link" href="<?php echo esc_url($authorized_url); ?>" rel="nofollow noopener" target="_blank">
                        <?php echo esc_html($source_label); ?>
                    </a>
                <?php endif; ?>
            </section>

            <div class="article-body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
