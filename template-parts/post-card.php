<?php
/**
 * Post card partial.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<a class="post-card" href="<?php the_permalink(); ?>">
    <div>
        <span class="post-category"><?php echo esc_html(totostory_tv_category_label(get_the_ID())); ?></span>
        <h2><?php the_title(); ?></h2>
        <p><?php echo esc_html(get_the_excerpt()); ?></p>
    </div>
    <div class="post-card-foot">
        <span><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
        <strong><?php echo esc_html(totostory_tv_reading_time(get_the_ID())); ?></strong>
    </div>
</a>
