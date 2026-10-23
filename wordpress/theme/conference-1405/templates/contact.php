<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri("/assets/css/style.css")); ?>">
</head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
  <header class="header">
    <div class="header-top"><div class="container"><div><span>📅 ۱۵ تا ۱۷ آذر ۱۴۰۵</span></div><div style="display:flex;gap:20px;"><a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس</a><a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات</a></div></div></div>
    <div class="container">
      <nav class="navbar">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><div class="logo-icon">هـ</div><span>همایش فناوری ۱۴۰۵</span></a>
        <button class="menu-toggle">☰</button>
        <div class="nav-menu"><?php wp_nav_menu(array('theme_location'=>'primary','container'=>false,'fallback_cb'=>'hm1405_fallback_menu','items_wrap'=>'%3$s')); ?></div>
        <div class="nav-actions">
          <a href="<?php echo esc_url(home_url('/login/')); ?>" class="btn btn-outline btn-sm">ورود</a>
          <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-primary btn-sm">ثبت‌نام</a>
        </div>
      </nav>
    </div>
  </header>

  <section class="section" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);color:white;padding:50px 0;">
    <div class="container text-center">
      <h1 style="font-size:2rem;margin-bottom:10px;">تماس با ما</h1>
      <p style="opacity:0.9;">سوالات، پیشنهادات و پشتیبانی</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-2" style="gap:40px;">
        <div>
          <h2 class="section-title">ارسال پیام</h2>
          <form data-validate data-success="true">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">نام و نام خانوادگی *</label>
                <input type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label class="form-label">ایمیل *</label>
                <input type="email" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">موضوع *</label>
              <select class="form-control" required>
                <option value="">انتخاب موضوع...</option>
                <option>سوال در مورد ثبت‌نام</option>
                <option>سوال در مورد ارسال مقاله</option>
                <option>پشتیبانی فنی</option>
                <option>همکاری و اسپانسرشیپ</option>
                <option>سایر</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">پیام *</label>
              <textarea class="form-control" required style="min-height:150px;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">ارسال پیام</button>
          </form>
        </div>
        <div>
          <h2 class="section-title">اطلاعات تماس</h2>
          <div class="card" style="padding:30px;margin-bottom:20px;">
            <p style="margin-bottom:15px;display:flex;gap:12px;align-items:flex-start;"><span style="font-size:1.3rem;">📍</span><span><strong>آدرس:</strong><br>تهران، خیابان ولیعصر، بالاتر از میدان ونک، مرکز همایش‌های بین‌المللی</span></p>
            <p style="margin-bottom:15px;display:flex;gap:12px;"><span style="font-size:1.3rem;">📞</span><span><strong>تلفن:</strong> ۰۲۱-۸۸۷۷۶۶۵۵</span></p>
            <p style="margin-bottom:15px;display:flex;gap:12px;"><span style="font-size:1.3rem;">✉️</span><span><strong>ایمیل:</strong> info@conference.ir</span></p>
            <p style="display:flex;gap:12px;"><span style="font-size:1.3rem;">🕐</span><span><strong>ساعات پاسخگویی:</strong> شنبه تا چهارشنبه ۹ تا ۱۷</span></p>
          </div>
          <div class="card" style="padding:25px;background:linear-gradient(135deg,#eff6ff,#f0fdfa);">
            <h3 style="margin-bottom:12px;">دبیرخانه همایش</h3>
            <p class="text-muted">برای مسائل علمی و داوری با دبیرخانه علمی و برای مسائل اجرایی با دبیرخانه اجرایی تماس بگیرید.</p>
            <p class="mt-2"><strong>علمی:</strong> scientific@conference.ir</p>
            <p><strong>اجرایی:</strong> executive@conference.ir</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-bottom"><p>© ۱۴۰۵ همایش فناوری و نوآوری</p></div>
    </div>
  </footer>
  <script src="<?php echo esc_url(get_theme_file_uri("/assets/js/main.js")); ?>"></script>
<?php wp_footer(); ?></body>
</html>
