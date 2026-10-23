<?php
/**
 * Conference 1405 theme bootstrap.
 */
defined('ABSPATH') || exit;

function hm1405_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    register_nav_menus(array('primary' => 'منوی اصلی'));
    load_theme_textdomain('conference-1405', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'hm1405_theme_setup');

function hm1405_assets() {
    wp_enqueue_style('hm1405-theme', get_stylesheet_uri(), array(), '1.0.0');
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
        if (!is_wp_error($id) && $data[0] === 'home') update_option('show_on_front', 'page') && update_option('page_on_front', $id);
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
