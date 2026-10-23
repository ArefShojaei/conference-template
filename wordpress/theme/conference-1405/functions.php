<?php
/**
 * Conference 1405 theme bootstrap.
 */
defined('ABSPATH') || exit;

function hm1405_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array('height' => 80, 'width' => 240, 'flex-height' => true, 'flex-width' => true));
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-background');
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    register_nav_menus(array('primary' => 'منوی اصلی', 'footer' => 'منوی پابرگ'));
    add_post_type_support('post', 'comments');
    add_post_type_support('page', 'comments');
    add_post_type_support('hm_event', 'comments');
    add_post_type_support('hm_speaker', 'comments');
    load_theme_textdomain('conference-1405', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'hm1405_theme_setup');

function hm1405_assets() {
    wp_enqueue_style('hm1405-theme', get_stylesheet_uri(), array(), '1.0.1');
    wp_enqueue_style('hm1405-legacy', get_theme_file_uri('/assets/css/style.css'), array('hm1405-theme'), '1.0.0');
    wp_enqueue_style('hm1405-redesign', get_theme_file_uri('/assets/css/mvp-redesign.css'), array('hm1405-legacy'), '1.0.0');
    wp_enqueue_script('hm1405-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'hm1405_assets');

/**
 * Create starter pages on theme activation only when a slug is unused.
 * The conference plugin owns submission, account, review and certificate workflows.
 */
function hm1405_create_starter_pages() {
    $pages = array(
        'خانه' => array('home', 'index'),
        'درباره همایش' => array('about', 'about'),
        'مقالات' => array('papers', 'papers'),
        'برنامه زمانی' => array('schedule', 'schedule'),
        'سخنرانان' => array('speakers', 'speakers'),
        'تماس با ما' => array('contact', 'contact'),
        'سوالات متداول' => array('faq', 'faq'),
        'ورود' => array('login', 'login'),
        'ثبت‌نام' => array('register', 'register'),
        'پنل کاربری' => array('dashboard', 'dashboard'),
        'ارسال مقاله' => array('submit-paper', 'submit-paper'),
        'مقالات من' => array('my-papers', 'my-papers'),
        'پنل داوری' => array('reviewer-dashboard', 'reviewer-dashboard')
    );
    foreach ($pages as $title => $data) {
        if (get_page_by_path($data[0])) continue;
        $content = '';
        if ($data[0] === 'register') $content = '[hm_register]';
        elseif ($data[0] === 'login') $content = '[hm_login]';
        elseif ($data[0] === 'submit-paper') $content = '[hm_submit_paper]';
        elseif ($data[0] === 'dashboard' || $data[0] === 'my-papers') $content = '[hm_dashboard]';
        elseif ($data[0] === 'reviewer-dashboard') $content = '[hm_reviewer_dashboard]';
        elseif ($data[0] === 'papers') $content = '[hm_events]';
        $id = wp_insert_post(array('post_title'=>$title,'post_name'=>$data[0],'post_status'=>'publish','post_type'=>'page','post_content'=>$content));
        if (!is_wp_error($id) && $data[0] === 'home') { update_option('show_on_front', 'page'); update_option('page_on_front', $id); }
        if (!is_wp_error($id)) update_post_meta($id, '_hm1405_legacy_template', $data[1]);
    }
}
add_action('after_switch_theme', 'hm1405_create_starter_pages');

function hm1405_template_for_slug($template) {
    if (!is_page()) return $template;
    $map = array('home'=>'index','about'=>'about','papers'=>'papers','schedule'=>'schedule','speakers'=>'speakers','contact'=>'contact','faq'=>'faq','login'=>'login','register'=>'register','dashboard'=>'dashboard','submit-paper'=>'submit-paper','my-papers'=>'my-papers','reviewer-dashboard'=>'reviewer-dashboard');
    $slug = get_post_field('post_name', get_queried_object_id());
    if (isset($map[$slug])) {
        $candidate = get_template_directory() . '/templates/' . $map[$slug] . '.php';
        if (file_exists($candidate)) return $candidate;
    }
    return $template;
}
add_filter('template_include', 'hm1405_template_for_slug', 99);

function hm1405_theme_fallback_shortcode_notice() {
    if (!shortcode_exists('hm_register')) {
        echo '<div class="hm-theme-notice"><strong>برای فعال شدن امکانات همایش، افزونه Conference Core را نصب و فعال کنید.</strong><p>قالب به‌تنهایی سامانه ارسال مقاله و داوری را اجرا نمی‌کند.</p></div>';
    }
}


/** Register editable widget areas. */
function hm1405_widgets_init() {
    register_sidebar(array(
        'name' => 'ستون کناری وبلاگ',
        'id' => 'blog-sidebar',
        'description' => 'ابزارک‌های وبلاگ و نوشته‌ها',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'hm1405_widgets_init');

/** Add native WordPress dynamic content sections to the existing visual design. */
function hm1405_render_dynamic_content($kind = 'posts', $limit = 3) {
    $args = array('posts_per_page' => absint($limit), 'post_status' => 'publish');
    if ($kind === 'events' && post_type_exists('hm_event')) {
        $args['post_type'] = 'hm_event';
    } elseif ($kind === 'speakers' && post_type_exists('hm_speaker')) {
        $args['post_type'] = 'hm_speaker';
    } else {
        $args['post_type'] = 'post';
    }
    $q = new WP_Query($args);
    if (!$q->have_posts()) {
        if (current_user_can('edit_posts')) {
            echo '<div class="container hm-theme-notice">هنوز محتوایی ثبت نشده است. از پیشخوان وردپرس محتوا اضافه کنید تا این بخش نمایش داده شود.</div>';
        }
        wp_reset_postdata();
        return;
    }
    echo '<div class="container hm-dynamic-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px">';
    while ($q->have_posts()) {
        $q->the_post();
        echo '<article class="hm-dynamic-card" style="background:#fff;border:1px solid #e4e7ec;border-radius:14px;overflow:hidden;padding:18px">';
        if (has_post_thumbnail()) {
            echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_post_thumbnail(get_the_ID(), 'medium_large', array('style'=>'width:100%;height:auto;border-radius:10px')) . '</a>';
        }
        echo '<h3><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>';
        echo '<p>' . esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 26)) . '</p>';
        echo '<a href="' . esc_url(get_permalink()) . '">ادامه مطلب ←</a>';
        echo '</article>';
    }
    echo '</div>';
    wp_reset_postdata();
}

/** Expose a small, safe set of conference settings through the Customizer. */
function hm1405_customize_register($wp_customize) {
    $wp_customize->add_section('hm1405_conference', array('title'=>'اطلاعات همایش','priority'=>35));
    $wp_customize->add_setting('hm1405_conference_date', array('default'=>'۱۵ تا ۱۷ آذر ۱۴۰۵','sanitize_callback'=>'sanitize_text_field'));
    $wp_customize->add_control('hm1405_conference_date', array('label'=>'تاریخ همایش','section'=>'hm1405_conference','type'=>'text'));
    $wp_customize->add_setting('hm1405_conference_location', array('default'=>'تهران','sanitize_callback'=>'sanitize_text_field'));
    $wp_customize->add_control('hm1405_conference_location', array('label'=>'محل برگزاری','section'=>'hm1405_conference','type'=>'text'));
}
add_action('customize_register', 'hm1405_customize_register');

function hm1405_fallback_menu() {
    $items = array(
        'صفحه اصلی' => '/',
        'درباره همایش' => '/about/',
        'سخنرانان' => '/speakers/',
        'برنامه زمانی' => '/schedule/',
        'مقالات' => '/papers/',
        'تماس' => '/contact/',
    );
    echo '<ul class="menu">';
    foreach ($items as $label => $path) {
        printf('<li><a href="%s">%s</a></li>', esc_url(home_url($path)), esc_html($label));
    }
    echo '</ul>';
}
