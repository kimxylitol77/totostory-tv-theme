<?php
/**
 * Safety report archive.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="site-shell page-shell partner-shell">
    <?php
    totostory_tv_partner_directory(
        array(
            'title' => __('Verification', 'totostory-tv'),
            'description' => __('안전 토토사이트, 검증카지노, 신규 토토사이트 목록을 같은 기준으로 확인할 수 있습니다.', 'totostory-tv'),
        )
    );
    ?>
</main>
<?php
get_footer();
