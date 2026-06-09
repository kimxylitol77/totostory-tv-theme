<?php
/**
 * Single post template.
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
        <article <?php post_class('post-detail'); ?>>
            <nav aria-label="<?php esc_attr_e('현재 위치', 'totostory-tv'); ?>" class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('홈', 'totostory-tv'); ?></a>
                <span>/</span>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/')); ?>"><?php esc_html_e('최신글', 'totostory-tv'); ?></a>
                <span>/</span>
                <strong><?php echo esc_html(totostory_tv_category_label(get_the_ID())); ?></strong>
            </nav>

            <header class="post-detail-head">
                <span class="post-category"><?php echo esc_html(totostory_tv_category_label(get_the_ID())); ?></span>
                <h1><?php the_title(); ?></h1>
                <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <div class="post-meta">
                    <span><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
                    <span><?php the_author(); ?></span>
                    <span><?php echo esc_html(totostory_tv_reading_time(get_the_ID())); ?></span>
                </div>
            </header>

            <section class="summary-box" aria-label="<?php esc_attr_e('글 요약', 'totostory-tv'); ?>">
                <h2><?php esc_html_e('핵심 요약', 'totostory-tv'); ?></h2>
                <ul>
                    <li><?php esc_html_e('본문 상단에서 카테고리와 작성일을 먼저 확인할 수 있습니다.', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('대표 이미지, 태그, 관련 카테고리는 워드프레스 기본 데이터를 사용합니다.', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('운영 중인 기존 글 주소와 SEO 구조를 유지하기 쉬운 템플릿입니다.', 'totostory-tv'); ?></li>
                </ul>
            </section>

            <?php if (has_post_thumbnail()) : ?>
                <figure class="article-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </figure>
            <?php endif; ?>

            <div class="article-body">
                <?php the_content(); ?>
            </div>

            <?php if (has_tag()) : ?>
                <footer class="post-tags">
                    <?php the_tags('', '', ''); ?>
                </footer>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
