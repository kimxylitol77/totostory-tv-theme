<?php
/**
 * Safety report card partial.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();
$status = totostory_tv_meta($post_id, '_totostory_report_status', __('검토', 'totostory-tv'));
$domain = totostory_tv_meta($post_id, '_totostory_report_domain', __('도메인 확인 중', 'totostory-tv'));
?>
<article class="report-card">
    <div>
        <span><?php echo esc_html($domain); ?></span>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </div>
    <strong><?php echo esc_html($status); ?></strong>
</article>
