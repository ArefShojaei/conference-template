<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main id="primary" class="section"><div class="container"><section class="card content-card text-center">
<span class="eyebrow">خطای ۴۰۴</span><h1>این صفحه پیدا نشد</h1>
<p>ممکن است نشانی تغییر کرده یا صفحه حذف شده باشد.</p>
<p><a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>">بازگشت به صفحه اصلی</a></p>
<?php get_search_form(); ?>
</section></div></main>
<?php get_footer(); ?>
