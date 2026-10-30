<?php
if (!defined('ABSPATH')) exit;
?><!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class('conference-auth-page'); ?>>
<?php wp_body_open(); ?>
<main class="auth-shell ">
  <section class="auth-visual auth-visual-login">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="auth-brand"><span class="auth-brand-mark">هـ</span><span><?php echo esc_html(get_theme_mod('conf1405_event_name','همایش')); ?><span class="auth-brand-light"> <?php echo esc_html(get_theme_mod('conf1405_event_date','۱۴۰۵')); ?></span></span></a>
    <div class="auth-visual-content">
      <span class="auth-overline"><span></span><?php echo ورود ساده و امن; ?></span>
      <h1><?php echo "همراه شما<br><em>در مسیر دانش.</em>"; ?></h1>
      <p><?php echo "برای ورود به پنل کاربری، شماره تلفن همراه خود را وارد کنید. کد تأیید برای همان شماره ارسال خواهد شد."; ?></p>
      <?php if(false): ?>
      <div class="auth-benefits"><div><span>01</span><p><strong>ثبت‌نام ساده</strong><small>بدون ایمیل و رمز عبور</small></p></div><div><span>02</span><p><strong>پیگیری پیامکی</strong><small>اطلاع‌رسانی وضعیت مقاله و ثبت‌نام</small></p></div><div><span>03</span><p><strong>تعیین نقش توسط مدیر</strong><small>سطح دسترسی امن و کنترل‌شده</small></p></div></div>
      <?php else: ?>
      <div class="auth-visual-note"><span class="auth-note-symbol">✳</span><span><strong>اطلاع‌رسانی از طریق پیامک</strong><small>وضعیت مقاله، داوری و ثبت‌نام</small></span></div>
      <?php endif; ?>
    </div>
    <div class="auth-visual-footer"><span><?php echo esc_html(get_theme_mod('conf1405_event_date','۱۵ تا ۱۷ آذر ۱۴۰۵')); ?></span><span><?php echo esc_html(get_theme_mod('conf1405_event_location','تهران · ایران')); ?></span></div>
  </section>
  <section class="auth-panel ">
    <div class="auth-panel-top"><a href="<?php echo esc_url(home_url('/')); ?>" class="auth-back">← بازگشت به وب‌سایت</a><span><?php echo "حساب ندارید؟ <a href='".esc_url(home_url('/register/'))."'>ثبت‌نام کنید</a>"; ?></span></div>
    <div class="auth-form-wrap"><?php echo do_shortcode('[conference_login]'); ?></div>
    <div class="auth-panel-footer">© <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html(get_theme_mod('conf1405_event_name','همایش فناوری و نوآوری')); ?><span>بدون نیاز به ایمیل یا رمز عبور</span></div>
  </section>
</main>
<?php wp_footer(); ?>
</body>
</html>
