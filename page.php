<?php
/**
 * Generic page template.
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
                <strong><?php the_title(); ?></strong>
            </nav>
            <header class="post-detail-head">
                <span class="post-category"><?php esc_html_e('페이지', 'totostory-tv'); ?></span>
                <h1><?php the_title(); ?></h1>
            </header>
            <div class="article-body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
