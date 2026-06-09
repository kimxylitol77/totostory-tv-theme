<?php
/**
 * Site footer.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<footer class="site-footer">
    <strong><?php bloginfo('name'); ?></strong>
    <span>
        <?php esc_html_e('스포츠 정보와 안전 검증 콘텐츠를 제공하는 사이트입니다. 베팅 참여를 권유하지 않습니다.', 'totostory-tv'); ?>
    </span>
</footer>
<?php wp_footer(); ?>
</body>
</html>
