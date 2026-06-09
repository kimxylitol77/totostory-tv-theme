<?php
/**
 * Template helpers.
 *
 * @package TotoStoryTV
 */

if (!defined('ABSPATH')) {
    exit;
}

function totostory_tv_asset(string $path): string
{
    return esc_url(TOTOSTORY_TV_URI . '/' . ltrim($path, '/'));
}

function totostory_tv_meta(int $post_id, string $key, string $fallback = ''): string
{
    $value = get_post_meta($post_id, $key, true);

    if (is_scalar($value) && '' !== (string) $value) {
        return (string) $value;
    }

    return $fallback;
}

function totostory_tv_reading_time(int $post_id = 0): string
{
    $post = get_post($post_id ?: get_the_ID());

    if (!$post) {
        return __('3분', 'totostory-tv');
    }

    $words = preg_split('/\s+/u', wp_strip_all_tags($post->post_content));
    $count = is_array($words) ? count(array_filter($words)) : 0;
    $minutes = max(1, (int) ceil($count / 320));

    return sprintf(__('%d분', 'totostory-tv'), $minutes);
}

function totostory_tv_category_label(int $post_id = 0): string
{
    $categories = get_the_category($post_id ?: get_the_ID());

    if (!empty($categories)) {
        return $categories[0]->name;
    }

    return get_post_type_object(get_post_type($post_id ?: get_the_ID()))->labels->singular_name ?? __('글', 'totostory-tv');
}

function totostory_tv_first_populated_menu_id(): int
{
    $menus = wp_get_nav_menus();

    foreach ($menus as $menu) {
        $items = wp_get_nav_menu_items($menu->term_id);

        if (!empty($items)) {
            return (int) $menu->term_id;
        }
    }

    return 0;
}

function totostory_tv_primary_menu_args(): array
{
    $args = array(
        'container' => false,
        'menu_class' => 'nav-links',
        'fallback_cb' => 'totostory_tv_primary_menu_fallback',
    );
    $locations = get_nav_menu_locations();

    if (!empty($locations['primary'])) {
        $args['theme_location'] = 'primary';

        return $args;
    }

    $menu_id = totostory_tv_first_populated_menu_id();

    if ($menu_id) {
        $args['menu'] = $menu_id;
    }

    return $args;
}

function totostory_tv_normalize_title(string $title, bool $remove_spaces = false): string
{
    $title = wp_strip_all_tags($title);
    $title = preg_replace('/\s+/u', ' ', trim($title));

    if ($remove_spaces) {
        $title = preg_replace('/\s+/u', '', $title);
    }

    return function_exists('mb_strtolower') ? mb_strtolower($title, 'UTF-8') : strtolower($title);
}

function totostory_tv_all_pages(): array
{
    static $pages = null;

    if (null === $pages) {
        $pages = get_pages(
            array(
                'post_status' => 'publish',
                'sort_column' => 'menu_order,post_title',
                'sort_order' => 'ASC',
            )
        );
    }

    return is_array($pages) ? $pages : array();
}

function totostory_tv_find_page_by_titles(array $titles): ?WP_Post
{
    $pages = totostory_tv_all_pages();
    $targets = array();
    $compact_targets = array();

    foreach ($titles as $title) {
        $targets[] = totostory_tv_normalize_title((string) $title);
        $compact_targets[] = totostory_tv_normalize_title((string) $title, true);
    }

    foreach ($pages as $page) {
        if (in_array(totostory_tv_normalize_title($page->post_title), $targets, true)) {
            return $page;
        }
    }

    foreach ($pages as $page) {
        if (in_array(totostory_tv_normalize_title($page->post_title, true), $compact_targets, true)) {
            return $page;
        }
    }

    return null;
}

function totostory_tv_page_url(array $titles, string $fallback = '/'): string
{
    $page = totostory_tv_find_page_by_titles($titles);

    if ($page) {
        return get_permalink($page);
    }

    if (preg_match('#^https?://#', $fallback)) {
        return $fallback;
    }

    return home_url($fallback);
}

function totostory_tv_category_url(array $names, string $fallback = '/'): string
{
    $targets = array();

    foreach ($names as $name) {
        $targets[] = totostory_tv_normalize_title((string) $name, true);
    }

    $categories = get_categories(array('hide_empty' => false));

    foreach ($categories as $category) {
        if (in_array(totostory_tv_normalize_title((string) $category->name, true), $targets, true)) {
            return get_category_link($category);
        }
    }

    if (preg_match('#^https?://#', $fallback)) {
        return $fallback;
    }

    return home_url($fallback);
}

function totostory_tv_legacy_page_groups(): array
{
    return array(
        array(
            'label' => __('토토스토리 스포츠tv', 'totostory-tv'),
            'titles' => array('토토스토리 스포츠tv', '토토스토리 스포츠TV', '스포츠TV', '스포츠 티비', '스포츠중계'),
            'fallback' => '/tv/',
        ),
        array(
            'label' => __('스포츠 다시보기', 'totostory-tv'),
            'titles' => array('스포츠 다시보기', '스포츠다시보기', '다시보기', '하이라이트'),
            'fallback' => '/category/highlight/',
        ),
        array(
            'label' => __('팀순위 확인', 'totostory-tv'),
            'titles' => array('팀순위 확인', '팀순위', '팀 순위', '순위 확인'),
            'fallback' => '',
        ),
        array(
            'label' => __('경기결과', 'totostory-tv'),
            'titles' => array('경기결과', '경기 결과', '결과'),
            'fallback' => '',
        ),
        array(
            'label' => __('라이브스코어', 'totostory-tv'),
            'titles' => array('라이브스코어', '라이브 스코어', '실시간스코어'),
            'fallback' => '/#live',
        ),
        array(
            'label' => __('안전 토토사이트', 'totostory-tv'),
            'titles' => array('안전 토토사이트', '안전토토사이트', '안전 토토'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('검증카지노', 'totostory-tv'),
            'titles' => array('검증카지노', '검증 카지노', '카지노 검증'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('토토정보', 'totostory-tv'),
            'titles' => array('토토정보', '토토 정보', '베팅 가이드'),
            'fallback' => '',
        ),
        array(
            'label' => __('먹튀 사이트', 'totostory-tv'),
            'titles' => array('먹튀 사이트', '먹튀사이트', '먹튀 검증'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('신규 토토사이트', 'totostory-tv'),
            'titles' => array('신규 토토사이트', '신규토토사이트', '신규 검증'),
            'fallback' => '/verification/',
        ),
        array(
            'label' => __('스포츠 분석', 'totostory-tv'),
            'titles' => array('스포츠 분석', '스포츠분석', '분석'),
            'fallback' => '/category/analysis/',
        ),
        array(
            'label' => __('먹튀제보', 'totostory-tv'),
            'titles' => array('먹튀제보', '먹튀 제보', '제보'),
            'fallback' => '/report/',
        ),
    );
}

function totostory_tv_legacy_page_links(int $limit = 12): array
{
    $links = array();
    $used_urls = array();

    foreach (totostory_tv_legacy_page_groups() as $group) {
        $page = totostory_tv_find_page_by_titles($group['titles']);
        $url = '';
        $title = (string) $group['label'];
        $excerpt = '';
        $id = 0;

        if ($page) {
            $id = (int) $page->ID;
            $title = get_the_title($page);
            $url = get_permalink($page);
            $excerpt = get_the_excerpt($page);
        } elseif (!empty($group['fallback'])) {
            $url = home_url((string) $group['fallback']);
        }

        if (!$url || isset($used_urls[$url])) {
            continue;
        }

        $links[] = array(
            'id' => $id,
            'title' => $title,
            'url' => $url,
            'excerpt' => $excerpt,
        );
        $used_urls[$url] = true;
    }

    foreach (totostory_tv_all_pages() as $page) {
        if (count($links) >= $limit) {
            break;
        }

        $url = get_permalink($page);

        if (!$url || isset($used_urls[$url])) {
            continue;
        }

        $links[] = array(
            'id' => (int) $page->ID,
            'title' => get_the_title($page),
            'url' => $url,
            'excerpt' => get_the_excerpt($page),
        );
        $used_urls[$url] = true;
    }

    return array_slice($links, 0, $limit);
}

function totostory_tv_query_posts(int $count = 4): WP_Query
{
    return new WP_Query(
        array(
            'post_type' => 'post',
            'posts_per_page' => $count,
            'ignore_sticky_posts' => true,
        )
    );
}

function totostory_tv_partner_page_config(?WP_Post $post = null): ?array
{
    $post = $post ?: get_post();

    if (!$post instanceof WP_Post) {
        return null;
    }

    $slug = (string) $post->post_name;
    $normalized_title = totostory_tv_normalize_title((string) $post->post_title, true);
    $fallbacks = array(
        'safe' => array(
            'title' => __('안전 토토사이트', 'totostory-tv'),
            'description' => __('검증 기준과 제휴 상태를 한눈에 확인하는 보증업체 목록입니다.', 'totostory-tv'),
            'target_url' => totostory_tv_category_url(array('안전한 토토사이트', '안전 토토사이트', '안전토토사이트'), '/안전한-토토사이트/'),
            'target_label' => __('안전토토사이트 보기', 'totostory-tv'),
        ),
        'casino' => array(
            'title' => __('검증카지노', 'totostory-tv'),
            'description' => __('카지노 제휴 검증 상태와 이용 전 확인할 핵심 정보를 정리합니다.', 'totostory-tv'),
            'target_url' => totostory_tv_category_url(array('검증 카지노', '검증카지노', '카지노 사이트', '카지노사이트'), '/검증-카지노/'),
            'target_label' => __('카지노사이트 보기', 'totostory-tv'),
        ),
        'new' => array(
            'title' => __('신규 토토사이트', 'totostory-tv'),
            'description' => __('신규 도메인과 신규 제휴업체 검증 현황을 확인합니다.', 'totostory-tv'),
            'target_url' => totostory_tv_category_url(array('신규 토토사이트', '신규토토사이트', '신규 검증'), '/신규-토토사이트/'),
            'target_label' => __('신규토토사이트 보기', 'totostory-tv'),
        ),
        'verification' => array(
            'title' => __('Verification', 'totostory-tv'),
            'description' => __('안전 토토사이트, 검증카지노, 신규 토토사이트 목록을 같은 기준으로 확인할 수 있습니다.', 'totostory-tv'),
        ),
    );

    if (false !== strpos($slug, 'verification') || in_array($normalized_title, array('verification', '검증리포트'), true)) {
        return $fallbacks['verification'];
    }

    if (false !== strpos($slug, 'casino') || false !== strpos($normalized_title, '검증카지노')) {
        return $fallbacks['casino'];
    }

    if (false !== strpos($slug, 'new') || false !== strpos($normalized_title, '신규토토사이트')) {
        return $fallbacks['new'];
    }

    if (false !== strpos($slug, 'safe') || false !== strpos($normalized_title, '안전토토사이트') || false !== strpos($normalized_title, '안전한토토사이트')) {
        return $fallbacks['safe'];
    }

    return null;
}

function totostory_tv_partner_archive_config(): ?array
{
    if (!is_category()) {
        return null;
    }

    $term = get_queried_object();

    if (!$term instanceof WP_Term) {
        return null;
    }

    $slug = (string) $term->slug;
    $normalized_name = totostory_tv_normalize_title((string) $term->name, true);
    $term_url = get_category_link($term);

    if (false !== strpos($slug, 'casino') || false !== strpos($normalized_name, '검증카지노')) {
        return array(
            'title' => __('검증카지노', 'totostory-tv'),
            'description' => __('카지노 제휴 검증 상태와 이용 전 확인할 핵심 정보를 정리합니다.', 'totostory-tv'),
            'target_url' => $term_url,
            'target_label' => __('카지노사이트 보기', 'totostory-tv'),
        );
    }

    if (false !== strpos($slug, 'new') || false !== strpos($normalized_name, '신규토토사이트')) {
        return array(
            'title' => __('신규 토토사이트', 'totostory-tv'),
            'description' => __('신규 도메인과 신규 제휴업체 검증 현황을 확인합니다.', 'totostory-tv'),
            'target_url' => $term_url,
            'target_label' => __('신규토토사이트 보기', 'totostory-tv'),
        );
    }

    if (false !== strpos($slug, 'safe') || false !== strpos($normalized_name, '안전토토사이트') || false !== strpos($normalized_name, '안전한토토사이트')) {
        return array(
            'title' => __('안전 토토사이트', 'totostory-tv'),
            'description' => __('검증 기준과 제휴 상태를 한눈에 확인하는 보증업체 목록입니다.', 'totostory-tv'),
            'target_url' => $term_url,
            'target_label' => __('안전토토사이트 보기', 'totostory-tv'),
        );
    }

    return null;
}

function totostory_tv_partner_cards(): array
{
    return array(
        array('name' => '팔라온', 'code' => '3333', 'badge' => __('검증', 'totostory-tv'), 'theme' => 'cyan', 'summary' => __('롤링 100% · 첫충 50% · 스포츠 고액 전용', 'totostory-tv')),
        array('name' => 'KR365', 'code' => __('자동입력', 'totostory-tv'), 'badge' => __('스포츠', 'totostory-tv'), 'theme' => 'blue', 'summary' => __('고액전용 스포츠 · 무제한 안내', 'totostory-tv')),
        array('name' => '띵벳', 'code' => 'HOT', 'badge' => __('추천', 'totostory-tv'), 'theme' => 'green', 'summary' => __('카지노 & 스포츠 고액전용', 'totostory-tv')),
        array('name' => '올패스', 'code' => 'PASS', 'badge' => __('안정', 'totostory-tv'), 'theme' => 'gold', 'summary' => __('스포츠 & 카지노 검증 라인', 'totostory-tv')),
        array('name' => '스마일', 'code' => 'HOT', 'badge' => __('이벤트', 'totostory-tv'), 'theme' => 'mint', 'summary' => __('월드컵 기간 한정 특별 이벤트', 'totostory-tv')),
        array('name' => '아미고', 'code' => 'AMG', 'badge' => __('신규', 'totostory-tv'), 'theme' => 'dark', 'summary' => __('신규 정착지원 · 테더 페이백', 'totostory-tv')),
    );
}

function totostory_tv_partner_directory(array $config): void
{
    $target_url = !empty($config['target_url']) ? (string) $config['target_url'] : '#partners';
    $target_label = !empty($config['target_label']) ? (string) $config['target_label'] : __('목록보기', 'totostory-tv');
    $notices = array(
        array(__('공지', 'totostory-tv'), __('[필독] 2026년 검증 기준 업데이트', 'totostory-tv'), '+51', '26.06.09'),
        array(__('공지', 'totostory-tv'), __('신규 제휴 심사 접수 안내', 'totostory-tv'), '+38', '26.06.08'),
        array(__('공지', 'totostory-tv'), __('회원 제보 검토 처리 방식', 'totostory-tv'), '+29', '26.06.07'),
    );
    $events = array(
        array(__('이벤트', 'totostory-tv'), __('월드컵 기간 안전 이용 체크', 'totostory-tv'), '+48', '26.06.08'),
        array(__('이벤트', 'totostory-tv'), __('KBO 경기일 제휴 안내', 'totostory-tv'), '+44', '26.06.08'),
        array(__('이벤트', 'totostory-tv'), __('신규 검증 업체 등록 현황', 'totostory-tv'), '+70', '26.06.01'),
        array(__('이벤트', 'totostory-tv'), __('토토스토리 제보 리워드', 'totostory-tv'), '+51', '26.05.31'),
    );
    $community_posts = array(
        array('[이용후기]', __('정산 처리 속도 후기 모음', 'totostory-tv'), '+12', '14:59'),
        array('[자유게시판]', __('출석 이벤트 공유', 'totostory-tv'), '+4', '14:59'),
        array('[자유게시판]', __('도메인 변경 알림 정리', 'totostory-tv'), '+4', '14:58'),
        array('[자유게시판]', __('고객센터 답변 속도 체크', 'totostory-tv'), '+5', '14:54'),
        array('[제보]', __('의심 사이트 캡처 공유', 'totostory-tv'), '+6', '14:54'),
    );
    ?>
    <section class="partner-page">
        <aside class="partner-sidebar" aria-label="<?php esc_attr_e('공지와 커뮤니티', 'totostory-tv'); ?>">
            <section class="ticker-card">
                <div class="ticker-head">
                    <strong><?php esc_html_e('공지', 'totostory-tv'); ?></strong>
                    <span><?php esc_html_e('[필독] 2026년 토토핫 보증 안내', 'totostory-tv'); ?></span>
                    <em>+51</em>
                </div>
            </section>

            <section class="side-board side-board-event">
                <h2><?php esc_html_e('토토핫 이벤트', 'totostory-tv'); ?></h2>
                <div class="side-list">
                    <?php foreach ($events as $item) : ?>
                        <a href="#partners">
                            <strong><?php echo esc_html($item[0]); ?></strong>
                            <span><?php echo esc_html($item[1]); ?></span>
                            <em><?php echo esc_html($item[2]); ?></em>
                            <small><?php echo esc_html($item[3]); ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="side-board">
                <div class="side-tabs">
                    <strong><?php esc_html_e('새 글', 'totostory-tv'); ?></strong>
                    <span><?php esc_html_e('새 댓글', 'totostory-tv'); ?></span>
                </div>
                <div class="side-list">
                    <?php foreach ($community_posts as $item) : ?>
                        <a href="#partners">
                            <strong><?php echo esc_html($item[0]); ?></strong>
                            <span><?php echo esc_html($item[1]); ?></span>
                            <em><?php echo esc_html($item[2]); ?></em>
                            <small><?php echo esc_html($item[3]); ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        </aside>

        <div class="partner-main">
            <div class="partner-title">
                <p>VERIFIED PARTNERS</p>
                <h1><?php echo esc_html($config['title']); ?></h1>
                <span><?php echo esc_html($config['description']); ?></span>
            </div>

            <div class="partner-notice-row" aria-label="<?php esc_attr_e('주요 공지', 'totostory-tv'); ?>">
                <?php foreach ($notices as $item) : ?>
                    <a href="#partners">
                        <strong><?php echo esc_html($item[0]); ?></strong>
                        <span><?php echo esc_html($item[1]); ?></span>
                        <em><?php echo esc_html($item[2]); ?></em>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="partner-grid" id="partners">
                <?php foreach (totostory_tv_partner_cards() as $partner) : ?>
                    <article class="partner-card partner-card-<?php echo esc_attr($partner['theme']); ?>">
                        <div class="partner-banner">
                            <img alt="" src="<?php echo esc_url(totostory_tv_asset('assets/images/safe-partner-banner.png')); ?>">
                            <span><?php echo esc_html($partner['badge']); ?></span>
                            <strong><?php echo esc_html($partner['summary']); ?></strong>
                        </div>
                        <dl>
                            <div>
                                <dt><?php esc_html_e('사이트 이름', 'totostory-tv'); ?></dt>
                                <dd><?php echo esc_html($partner['name']); ?></dd>
                            </div>
                            <div>
                                <dt><?php esc_html_e('가입코드', 'totostory-tv'); ?></dt>
                                <dd><?php echo esc_html($partner['code']); ?></dd>
                            </div>
                        </dl>
                        <div class="partner-actions">
                            <a href="<?php echo esc_url($target_url); ?>"><?php esc_html_e('상세보기 +', 'totostory-tv'); ?></a>
                            <a href="<?php echo esc_url($target_url); ?>"><?php echo esc_html($target_label); ?></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

function totostory_tv_query_matches(int $count = 3): WP_Query
{
    return new WP_Query(
        array(
            'post_type' => 'tv_match',
            'posts_per_page' => $count,
            'meta_key' => '_totostory_match_time',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        )
    );
}

function totostory_tv_query_reports(int $count = 3): WP_Query
{
    return new WP_Query(
        array(
            'post_type' => 'safety_report',
            'posts_per_page' => $count,
        )
    );
}
