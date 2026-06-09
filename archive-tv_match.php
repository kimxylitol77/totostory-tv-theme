<?php
/**
 * TV match archive.
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
            <p class="eyebrow">LIVE TV CENTER</p>
            <h1><?php esc_html_e('스포츠중계', 'totostory-tv'); ?></h1>
            <p><?php esc_html_e('관리자에서 등록한 경기 일정, 공식 링크, 허가된 임베드 정보를 TV 포털형 화면으로 보여줍니다.', 'totostory-tv'); ?></p>
        </div>
        <aside>
            <span><?php esc_html_e('등록된 경기', 'totostory-tv'); ?></span>
            <strong><?php echo esc_html((string) $GLOBALS['wp_query']->found_posts); ?><?php esc_html_e('개', 'totostory-tv'); ?></strong>
        </aside>
    </section>

    <section class="archive-layout">
        <nav aria-label="<?php esc_attr_e('중계 탭', 'totostory-tv'); ?>" class="archive-tabs">
            <a aria-current="page" href="<?php echo esc_url(home_url('/tv/')); ?>"><?php esc_html_e('전체 중계', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(home_url('/#analysis')); ?>"><?php esc_html_e('스포츠분석', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(home_url('/category/highlight/')); ?>"><?php esc_html_e('하이라이트', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(home_url('/verification/')); ?>"><?php esc_html_e('검증리포트', 'totostory-tv'); ?></a>
        </nav>

        <div class="schedule-grid tv-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $post_id = get_the_ID();
                    $url = totostory_tv_meta($post_id, '_totostory_authorized_url');
                    ?>
                    <article class="schedule-card tv-card">
                        <div class="card-top">
                            <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_time', '19:00')); ?></span>
                            <strong><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_status', __('예정', 'totostory-tv'))); ?></strong>
                        </div>
                        <p><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_sport', __('스포츠', 'totostory-tv'))); ?></p>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_signal', get_the_excerpt())); ?></span>
                        <div class="tv-card-actions">
                            <a class="primary-link" href="<?php the_permalink(); ?>"><?php esc_html_e('상세 보기', 'totostory-tv'); ?></a>
                            <?php if ($url) : ?>
                                <a class="ghost-button" href="<?php echo esc_url($url); ?>" rel="nofollow noopener" target="_blank"><?php esc_html_e('공식 링크', 'totostory-tv'); ?></a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part('template-parts/empty'); ?>
            <?php endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </section>
</main>
<?php
get_footer();
