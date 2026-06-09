<?php
/**
 * Front page template.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$match_query = totostory_tv_query_matches(3);
$post_query = totostory_tv_query_posts(3);
$latest_query = totostory_tv_query_posts(6);
$legacy_page_links = totostory_tv_legacy_page_links(12);
$report_query = totostory_tv_query_reports(3);
$hero_image = totostory_tv_asset('assets/images/sports-tv-studio-v2.png');
$guide_image = totostory_tv_asset('assets/images/sports-tv-studio-v2.png');
$match_count = (int) wp_count_posts('tv_match')->publish;
$post_count = (int) wp_count_posts('post')->publish;
$report_count = (int) wp_count_posts('safety_report')->publish;
$front_page_id = (int) get_option('page_on_front');
$front_page_content = $front_page_id ? apply_filters('the_content', get_post_field('post_content', $front_page_id)) : '';

$fallback_matches = array(
    array('league' => 'K리그 프리뷰', 'title' => '서울 시티 vs 부산 하버', 'signal' => '공격 점유 58%', 'score' => '2 : 1', 'status' => 'LIVE 71분'),
    array('league' => 'MLB 나이트', 'title' => 'LA 스타즈 vs 뉴욕 브릿지', 'signal' => '불펜 교체', 'score' => '4 : 4', 'status' => '8회 초'),
    array('league' => 'NBA 데일리', 'title' => '인천 블루 vs 대구 레드', 'signal' => '부상 리포트 공개', 'score' => '라인업', 'status' => '예정 21:30'),
);
?>
<main class="site-shell">
    <section class="hero-stage" id="top">
        <img alt="<?php esc_attr_e('야간 경기장의 스포츠 데이터 방송 데스크', 'totostory-tv'); ?>" class="hero-image" src="<?php echo esc_url($hero_image); ?>">
        <div class="hero-shade"></div>
        <div class="hero-content">
            <div class="hero-copy">
                <p class="eyebrow">SPORTS LIVE INTELLIGENCE</p>
                <h1><?php bloginfo('name'); ?></h1>
                <p class="hero-lede">
                    <?php esc_html_e('실시간 중계 흐름, 경기 분석, 하이라이트, 안전 제보를 한 화면에서 확인하는 스포츠 정보 허브.', 'totostory-tv'); ?>
                </p>
                <div class="hero-actions">
                    <a class="primary-link" href="#live"><?php esc_html_e('오늘 경기', 'totostory-tv'); ?></a>
                    <a class="secondary-link" href="#reports"><?php esc_html_e('검증 리포트', 'totostory-tv'); ?></a>
                </div>
                <dl class="hero-stats" aria-label="<?php esc_attr_e('서비스 요약', 'totostory-tv'); ?>">
                    <div>
                        <dt><?php esc_html_e('오늘 경기', 'totostory-tv'); ?></dt>
                        <dd><?php echo esc_html((string) max(3, $match_count)); ?></dd>
                    </div>
                    <div>
                        <dt><?php esc_html_e('분석 노트', 'totostory-tv'); ?></dt>
                        <dd><?php echo esc_html((string) max(3, $post_count)); ?></dd>
                    </div>
                    <div>
                        <dt><?php esc_html_e('제보 검토', 'totostory-tv'); ?></dt>
                        <dd><?php echo esc_html((string) max(3, $report_count)); ?></dd>
                    </div>
                </dl>
            </div>

            <aside aria-label="<?php esc_attr_e('실시간 매치보드', 'totostory-tv'); ?>" class="match-console">
                <div class="console-head">
                    <span><?php esc_html_e('실시간 매치보드', 'totostory-tv'); ?></span>
                    <strong>ON AIR</strong>
                </div>
                <div class="segment-control" role="tablist">
                    <button aria-selected="true" type="button"><?php esc_html_e('라이브', 'totostory-tv'); ?></button>
                    <button type="button"><?php esc_html_e('예정', 'totostory-tv'); ?></button>
                    <button type="button"><?php esc_html_e('결과', 'totostory-tv'); ?></button>
                </div>
                <div class="match-list">
                    <?php if ($match_query->have_posts()) : ?>
                        <?php while ($match_query->have_posts()) : $match_query->the_post(); ?>
                            <?php get_template_part('template-parts/match-row'); ?>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <?php foreach ($fallback_matches as $match) : ?>
                            <article class="match-row">
                                <div>
                                    <p><?php echo esc_html($match['league']); ?></p>
                                    <h2><?php echo esc_html($match['title']); ?></h2>
                                    <span><?php echo esc_html($match['signal']); ?></span>
                                </div>
                                <div class="score-cell">
                                    <strong><?php echo esc_html($match['score']); ?></strong>
                                    <small><?php echo esc_html($match['status']); ?></small>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </section>

    <?php if (!empty($legacy_page_links)) : ?>
        <section aria-label="<?php esc_attr_e('기존 주요 메뉴', 'totostory-tv'); ?>" class="quick-strip">
            <?php foreach ($legacy_page_links as $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['title']); ?></a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($front_page_content && trim(wp_strip_all_tags($front_page_content))) : ?>
        <section class="home-editor-section" id="intro">
            <div class="home-editor-hero">
                <div class="section-heading">
                    <p>TOTO TV GUIDE</p>
                    <h2><?php esc_html_e('토토티비 이용 가이드', 'totostory-tv'); ?></h2>
                </div>
                <figure class="home-editor-visual">
                    <img alt="<?php esc_attr_e('스포츠 중계 일정 대시보드가 있는 방송 데스크', 'totostory-tv'); ?>" src="<?php echo esc_url($guide_image); ?>">
                </figure>
            </div>
            <article class="home-editor-content article-body">
                <?php echo wp_kses_post($front_page_content); ?>
            </article>
        </section>
    <?php endif; ?>

    <section class="content-grid" id="live">
        <div class="section-heading">
            <p>LIVE CENTER</p>
            <h2><?php esc_html_e('오늘의 중계와 경기 흐름', 'totostory-tv'); ?></h2>
        </div>
        <div class="schedule-grid">
            <?php
            $schedule_query = totostory_tv_query_matches(3);
            if ($schedule_query->have_posts()) :
                while ($schedule_query->have_posts()) :
                    $schedule_query->the_post();
                    $post_id = get_the_ID();
                    ?>
                    <article class="schedule-card">
                        <div class="card-top">
                            <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_time', '19:00')); ?></span>
                            <strong><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_status', __('예정', 'totostory-tv'))); ?></strong>
                        </div>
                        <p><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_sport', __('스포츠', 'totostory-tv'))); ?></p>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <span><?php echo esc_html(totostory_tv_meta($post_id, '_totostory_match_signal', get_the_excerpt())); ?></span>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                foreach ($fallback_matches as $match) :
                    ?>
                    <article class="schedule-card">
                        <div class="card-top">
                            <span>19:00</span>
                            <strong><?php echo esc_html($match['status']); ?></strong>
                        </div>
                        <p><?php echo esc_html($match['league']); ?></p>
                        <h3><?php echo esc_html($match['title']); ?></h3>
                        <span><?php echo esc_html($match['signal']); ?></span>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
        <aside class="ranking-panel" aria-label="<?php esc_attr_e('운영 메모', 'totostory-tv'); ?>">
            <div class="panel-title">
                <p>TV SETUP</p>
                <h2><?php esc_html_e('운영 연결 방식', 'totostory-tv'); ?></h2>
            </div>
            <table>
                <tbody>
                    <tr><th scope="row">1</th><td><?php esc_html_e('중계 일정', 'totostory-tv'); ?></td><td><?php esc_html_e('관리자 입력', 'totostory-tv'); ?></td><td><?php esc_html_e('공식 링크', 'totostory-tv'); ?></td></tr>
                    <tr><th scope="row">2</th><td><?php esc_html_e('하이라이트', 'totostory-tv'); ?></td><td><?php esc_html_e('글/카테고리', 'totostory-tv'); ?></td><td><?php esc_html_e('SEO 유지', 'totostory-tv'); ?></td></tr>
                    <tr><th scope="row">3</th><td><?php esc_html_e('검증 리포트', 'totostory-tv'); ?></td><td><?php esc_html_e('CPT 관리', 'totostory-tv'); ?></td><td><?php esc_html_e('상태 배지', 'totostory-tv'); ?></td></tr>
                    <tr><th scope="row">4</th><td><?php esc_html_e('제보 접수', 'totostory-tv'); ?></td><td><?php esc_html_e('폼 연결', 'totostory-tv'); ?></td><td><?php esc_html_e('추후 설정', 'totostory-tv'); ?></td></tr>
                </tbody>
            </table>
        </aside>
    </section>

    <section class="analysis-band" id="analysis">
        <div class="section-heading">
            <p>ANALYSIS</p>
            <h2><?php esc_html_e('경기 전 체크할 핵심 데이터', 'totostory-tv'); ?></h2>
        </div>
        <div class="analysis-grid">
            <?php if ($post_query->have_posts()) : ?>
                <?php while ($post_query->have_posts()) : $post_query->the_post(); ?>
                    <article class="analysis-card">
                        <span><?php echo esc_html(totostory_tv_category_label(get_the_ID())); ?></span>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html(get_the_excerpt()); ?></p>
                        <a href="<?php the_permalink(); ?>"><?php esc_html_e('자세히 보기', 'totostory-tv'); ?></a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <?php get_template_part('template-parts/empty'); ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="report-section" id="reports">
        <div class="section-heading">
            <p>SAFETY DESK</p>
            <h2><?php esc_html_e('검증 리포트와 책임 이용 안내', 'totostory-tv'); ?></h2>
        </div>
        <div class="report-layout">
            <div class="report-list">
                <?php if ($report_query->have_posts()) : ?>
                    <?php while ($report_query->have_posts()) : $report_query->the_post(); ?>
                        <?php get_template_part('template-parts/report-card'); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else : ?>
                    <article class="report-card"><div><span><?php esc_html_e('신규 사이트 점검', 'totostory-tv'); ?></span><h3><?php esc_html_e('도메인 변경 이력과 운영 기간 확인', 'totostory-tv'); ?></h3></div><strong><?php esc_html_e('주의', 'totostory-tv'); ?></strong></article>
                    <article class="report-card"><div><span><?php esc_html_e('회원 제보', 'totostory-tv'); ?></span><h3><?php esc_html_e('정산 지연 신고 교차 확인 중', 'totostory-tv'); ?></h3></div><strong><?php esc_html_e('검토', 'totostory-tv'); ?></strong></article>
                    <article class="report-card"><div><span><?php esc_html_e('보안 체크', 'totostory-tv'); ?></span><h3><?php esc_html_e('개인정보 수집 범위와 약관 고지 점검', 'totostory-tv'); ?></h3></div><strong><?php esc_html_e('확인', 'totostory-tv'); ?></strong></article>
                <?php endif; ?>
            </div>
            <aside class="safety-note">
                <p><?php esc_html_e('책임 이용 원칙', 'totostory-tv'); ?></p>
                <h2><?php esc_html_e('확인되지 않은 링크와 과도한 참여를 멀리하세요.', 'totostory-tv'); ?></h2>
                <ul>
                    <li><?php esc_html_e('도메인 개설일, 변경 이력, 운영자 고지를 먼저 확인', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('제보는 결제 내역, 대화 기록, 공지 화면을 함께 보관', 'totostory-tv'); ?></li>
                    <li><?php esc_html_e('합법 지역과 성인 사용자 기준을 벗어난 이용 금지', 'totostory-tv'); ?></li>
                </ul>
            </aside>
        </div>
    </section>

    <section class="latest-home-section" id="latest">
        <div class="section-heading">
            <p>LATEST POSTS</p>
            <h2><?php esc_html_e('최신 글 전체 보기', 'totostory-tv'); ?></h2>
        </div>
        <div class="post-list home-post-list">
            <?php if ($latest_query->have_posts()) : ?>
                <?php while ($latest_query->have_posts()) : $latest_query->the_post(); ?>
                    <?php get_template_part('template-parts/post-card'); ?>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <?php get_template_part('template-parts/empty'); ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="latest-home-section" id="pages">
        <div class="section-heading">
            <p>SITE PAGES</p>
            <h2><?php esc_html_e('주요 페이지', 'totostory-tv'); ?></h2>
        </div>
        <div class="page-link-grid">
            <?php if (!empty($legacy_page_links)) : ?>
                <?php foreach ($legacy_page_links as $link) : ?>
                    <a class="page-link-card" href="<?php echo esc_url($link['url']); ?>">
                        <span><?php echo $link['id'] ? esc_html__('기존 페이지', 'totostory-tv') : esc_html__('빠른 링크', 'totostory-tv'); ?></span>
                        <strong><?php echo esc_html($link['title']); ?></strong>
                        <small>
                            <?php
                            echo esc_html(
                                $link['excerpt'] ?: __('기존 사이트 목록을 유지한 바로가기입니다.', 'totostory-tv')
                            );
                            ?>
                        </small>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <?php get_template_part('template-parts/empty'); ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
get_footer();
