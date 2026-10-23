<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<header class="header">
<div class="header-top"><div class="container"><span><?php echo esc_html(get_theme_mod('hm1405_conference_date','۱۵ تا ۱۷ آذر ۱۴۰۵')); ?> | <?php echo esc_html(get_theme_mod('hm1405_conference_location','تهران')); ?></span><div><a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a></div></div></div>
<div class="container"><nav class="navbar">
<a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><?php if (has_custom_logo()) { the_custom_logo(); } ?><span><?php bloginfo('name'); ?></span></a>
<button class="menu-toggle" type="button" aria-label="باز کردن منو">☰</button>
<div class="nav-menu"><?php wp_nav_menu(array('theme_location'=>'primary','container'=>false,'fallback_cb'=>'hm1405_fallback_menu','items_wrap'=>'<ul class="menu">%3$s</ul>')); ?></div>
<div class="nav-actions">
<?php if (is_user_logged_in()) : ?>
<a class="btn btn-outline btn-sm" href="<?php echo esc_url(admin_url()); ?>">پیشخوان</a>
<a class="btn btn-primary btn-sm" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج</a>
<?php else : ?>
<a class="btn btn-outline btn-sm" href="<?php echo esc_url(home_url('/login/')); ?>">ورود</a>
<a class="btn btn-primary btn-sm" href="<?php echo esc_url(home_url('/register/')); ?>">ثبت‌نام</a>
<?php endif; ?>
</div></nav></div></header>
