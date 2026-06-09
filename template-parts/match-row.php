<?php
/**
 * Match row partial.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();
$league = totostory_tv_meta($post_id, '_totostory_league', __('스포츠중계', 'totostory-tv'));
$status = totostory_tv_meta($post_id, '_totostory_match_status', __('예정', 'totostory-tv'));
$score = totostory_tv_meta($post_id, '_totostory_match_score', __('라인업', 'totostory-tv'));
$signal = totostory_tv_meta($post_id, '_totostory_match_signal', get_the_excerpt());
?>
<article class="match-row">
    <div>
        <p><?php echo esc_html($league); ?></p>
        <h2><?php the_title(); ?></h2>
        <span><?php echo esc_html($signal); ?></span>
    </div>
    <div class="score-cell">
        <strong><?php echo esc_html($score); ?></strong>
        <small><?php echo esc_html($status); ?></small>
    </div>
</article>
