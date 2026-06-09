<?php
/**
 * Archive template.
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
            <p class="eyebrow">CATEGORY ARCHIVE</p>
            <h1><?php the_archive_title(); ?></h1>
            <p><?php echo esc_html(wp_strip_all_tags(get_the_archive_description()) ?: __('카테고리별 최신 콘텐츠를 확인합니다.', 'totostory-tv')); ?></p>
        </div>
        <aside>
            <span><?php esc_html_e('아카이브', 'totostory-tv'); ?></span>
            <strong><?php echo esc_html((string) $GLOBALS['wp_query']->found_posts); ?><?php esc_html_e('개', 'totostory-tv'); ?></strong>
        </aside>
    </section>

    <section class="archive-layout">
        <nav aria-label="<?php esc_attr_e('카테고리 탭', 'totostory-tv'); ?>" class="archive-tabs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('홈', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(home_url('/tv/')); ?>"><?php esc_html_e('스포츠중계', 'totostory-tv'); ?></a>
            <a href="<?php echo esc_url(home_url('/verification/')); ?>"><?php esc_html_e('검증리포트', 'totostory-tv'); ?></a>
            <?php foreach (get_categories(array('hide_empty' => false, 'number' => 6)) as $category) : ?>
                <a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a>
            <?php endforeach; ?>
        </nav>

        <div class="post-list">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post-card'); ?>
                <?php endwhile; ?>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <?php get_template_part('template-parts/empty'); ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
get_footer();
