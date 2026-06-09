<?php
/**
 * Admin meta boxes.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

function totostory_tv_add_meta_boxes(): void
{
    add_meta_box(
        'totostory_tv_match_details',
        __('중계 정보', 'totostory-tv'),
        'totostory_tv_render_match_meta_box',
        'tv_match',
        'normal',
        'high'
    );

    add_meta_box(
        'totostory_tv_report_details',
        __('검증 상태', 'totostory-tv'),
        'totostory_tv_render_report_meta_box',
        'safety_report',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'totostory_tv_add_meta_boxes');

function totostory_tv_render_field(int $post_id, string $key, string $label, string $placeholder = '', string $type = 'text'): void
{
    $value = get_post_meta($post_id, $key, true);
    ?>
    <p class="totostory-admin-field">
        <label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($label); ?></strong></label>
        <input
            id="<?php echo esc_attr($key); ?>"
            name="<?php echo esc_attr($key); ?>"
            placeholder="<?php echo esc_attr($placeholder); ?>"
            type="<?php echo esc_attr($type); ?>"
            value="<?php echo esc_attr((string) $value); ?>"
            style="width:100%;max-width:720px;"
        />
    </p>
    <?php
}

function totostory_tv_render_match_meta_box(WP_Post $post): void
{
    wp_nonce_field('totostory_tv_save_match_meta', 'totostory_tv_match_nonce');

    totostory_tv_render_field($post->ID, '_totostory_sport', __('종목', 'totostory-tv'), __('축구, 야구, 농구', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_league', __('리그/대회', 'totostory-tv'), __('K리그, MLB, NBA', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_match_time', __('경기 시간', 'totostory-tv'), __('19:00 또는 2026-06-09 19:00', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_match_status', __('상태', 'totostory-tv'), __('LIVE 71분, 예정, 종료', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_match_score', __('스코어', 'totostory-tv'), __('2 : 1', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_match_signal', __('짧은 메모', 'totostory-tv'), __('공격 점유 58%', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_source_label', __('버튼 문구', 'totostory-tv'), __('공식 중계 보기', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_authorized_url', __('공식/허가된 링크 URL', 'totostory-tv'), 'https://', 'url');
    totostory_tv_render_field($post->ID, '_totostory_embed_url', __('허가된 임베드 URL', 'totostory-tv'), 'https://', 'url');
}

function totostory_tv_render_report_meta_box(WP_Post $post): void
{
    wp_nonce_field('totostory_tv_save_report_meta', 'totostory_tv_report_nonce');

    totostory_tv_render_field($post->ID, '_totostory_report_status', __('상태', 'totostory-tv'), __('확인, 검토, 주의, 위험', 'totostory-tv'));
    totostory_tv_render_field($post->ID, '_totostory_report_domain', __('도메인', 'totostory-tv'), 'example.com');
    totostory_tv_render_field($post->ID, '_totostory_reviewed_at', __('검토일', 'totostory-tv'), '2026-06-09');
}

function totostory_tv_save_meta(int $post_id): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $post_type = get_post_type($post_id);

    if ('tv_match' === $post_type) {
        if (!isset($_POST['totostory_tv_match_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['totostory_tv_match_nonce'])), 'totostory_tv_save_match_meta')) {
            return;
        }

        $keys = array(
            '_totostory_sport',
            '_totostory_league',
            '_totostory_match_time',
            '_totostory_match_status',
            '_totostory_match_score',
            '_totostory_match_signal',
            '_totostory_source_label',
            '_totostory_authorized_url',
            '_totostory_embed_url',
        );
    } elseif ('safety_report' === $post_type) {
        if (!isset($_POST['totostory_tv_report_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['totostory_tv_report_nonce'])), 'totostory_tv_save_report_meta')) {
            return;
        }

        $keys = array(
            '_totostory_report_status',
            '_totostory_report_domain',
            '_totostory_reviewed_at',
        );
    } else {
        return;
    }

    foreach ($keys as $key) {
        if (!isset($_POST[$key])) {
            continue;
        }

        $value = sanitize_text_field(wp_unslash($_POST[$key]));

        if (str_contains($key, '_url')) {
            $value = esc_url_raw($value);
        }

        update_post_meta($post_id, $key, $value);
    }
}
add_action('save_post', 'totostory_tv_save_meta');
