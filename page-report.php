<?php
/**
 * Report page template.
 *
 * Template Name: 먹튀 제보 접수
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="site-shell page-shell">
    <section class="report-page">
        <div class="report-intro">
            <p class="eyebrow">SAFETY REPORT</p>
            <h1><?php echo esc_html(get_the_title() ?: __('먹튀 제보 접수', 'totostory-tv')); ?></h1>
            <p>
                <?php esc_html_e('실제 적용 시 이 화면은 워드프레스 폼 플러그인, 별도 DB, 또는 텔레그램 알림으로 연결할 수 있습니다. 현재 테마에는 전송 기능을 포함하지 않았습니다.', 'totostory-tv'); ?>
            </p>
            <div class="report-guides">
                <span><?php esc_html_e('결제 내역이나 대화 기록을 보관해 주세요.', 'totostory-tv'); ?></span>
                <span><?php esc_html_e('사이트 공지, 약관, 정산 안내 화면을 함께 남겨 주세요.', 'totostory-tv'); ?></span>
                <span><?php esc_html_e('개인정보와 민감한 인증 정보는 가려서 제출하는 편이 안전합니다.', 'totostory-tv'); ?></span>
            </div>
        </div>

        <form class="report-form">
            <div class="form-grid">
                <label>
                    <span><?php esc_html_e('사이트명', 'totostory-tv'); ?></span>
                    <input placeholder="<?php esc_attr_e('사이트명 입력', 'totostory-tv'); ?>" type="text">
                </label>
                <label>
                    <span><?php esc_html_e('도메인 주소', 'totostory-tv'); ?></span>
                    <input placeholder="example.com" type="text">
                </label>
                <label>
                    <span><?php esc_html_e('피해 또는 의심 금액', 'totostory-tv'); ?></span>
                    <input placeholder="<?php esc_attr_e('금액 입력', 'totostory-tv'); ?>" type="text">
                </label>
                <label>
                    <span><?php esc_html_e('연락 가능 수단', 'totostory-tv'); ?></span>
                    <input placeholder="<?php esc_attr_e('이메일 또는 메신저', 'totostory-tv'); ?>" type="text">
                </label>
            </div>
            <label>
                <span><?php esc_html_e('제보 내용', 'totostory-tv'); ?></span>
                <textarea placeholder="<?php esc_attr_e('상황, 날짜, 사이트 응답, 정산 여부 등을 자세히 적어 주세요.', 'totostory-tv'); ?>" rows="7"></textarea>
            </label>
            <div class="upload-box">
                <strong><?php esc_html_e('증거자료 첨부 영역', 'totostory-tv'); ?></strong>
                <span><?php esc_html_e('실제 적용 시 이미지, PDF, 스크린샷 업로드를 연결합니다.', 'totostory-tv'); ?></span>
            </div>
            <button type="button"><?php esc_html_e('제보 접수 미리보기', 'totostory-tv'); ?></button>
        </form>
    </section>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (trim(get_the_content())) : ?>
                <article class="post-detail">
                    <div class="article-body"><?php the_content(); ?></div>
                </article>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php
get_footer();
