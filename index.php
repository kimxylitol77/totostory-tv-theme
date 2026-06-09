<?php
/**
 * Blog index template.
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
            <p class="eyebrow">WORDPRESS CONTENT</p>
            <h1><?php echo esc_html(get_the_title(get_option('page_for_posts')) ?: __('최신 글', 'totostory-tv')); ?></h1>
            <p><?php esc_html_e('스포츠중계, 스포츠분석, 하이라이트, 검증 리포트 글을 한 화면에서 확인합니다.', 'totostory-tv'); ?></p>
        </div>
        <aside>
            <span><?php esc_html_e('등록된 글', 'totostory-tv'); ?></span>
            <strong><?php echo esc_html((string) wp_count_posts('post')->publish); ?><?php esc_html_e('개', 'totostory-tv'); ?></strong>
        </aside>
    </section>

    <section class="post-layout">
        <div class="post-main">
            <?php if (have_posts()) : ?>
                <?php
                $first = true;
                while (have_posts()) :
                    the_post();
                    if ($first) :
                        $first = false;
                        ?>
                        <a class="featured-post" href="<?php the_permalink(); ?>">
                            <span><?php echo esc_html(totostory_tv_category_label(get_the_ID())); ?></span>
                            <h2><?php the_title(); ?></h2>
                            <p><?php echo esc_html(get_the_excerpt()); ?></p>
                            <div class="post-meta">
                                <span><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
                                <span><?php the_author(); ?></span>
                                <span><?php echo esc_html(totostory_tv_reading_time(get_the_ID())); ?></span>
                            </div>
                        </a>
                        <div class="post-list" aria-label="<?php esc_attr_e('최신 글 목록', 'totostory-tv'); ?>">
                    <?php else : ?>
                        <?php get_template_part('template-parts/post-card'); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
                </div>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <?php get_template_part('template-parts/empty'); ?>
            <?php endif; ?>
        </div>

        <aside class="post-sidebar">
            <section>
                <h2><?php esc_html_e('카테고리', 'totostory-tv'); ?></h2>
                <div class="category-list">
                    <?php foreach (get_categories(array('hide_empty' => false)) as $category) : ?>
                        <a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="editor-note">
                <h2><?php esc_html_e('운영 메모', 'totostory-tv'); ?></h2>
                <p><?php esc_html_e('기존 워드프레스 글, 카테고리, 태그, 대표 이미지를 그대로 사용하면서 새 디자인으로 보여주는 구조입니다.', 'totostory-tv'); ?></p>
            </section>
        </aside>
    </section>
</main>
<?php
get_footer();
