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

  <section class="section" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);color:white;padding:60px 0;">
    <div class="container text-center">
      <h1 style="font-size:2.2rem;margin-bottom:12px;">سخنرانان همایش</h1>
      <p style="opacity:0.9;">اساتید، پژوهشگران و متخصصان برجسته داخلی و بین‌المللی</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <h2 class="section-title">🎤 سخنرانان کلیدی (Keynote)</h2>
      <div class="grid grid-3 mb-4">
        <div class="card speaker-card">
          <div class="speaker-avatar">ع.م</div>
          <h3>دکتر علی محمدی</h3>
          <div class="speaker-title">استاد دانشگاه صنعتی شریف</div>
          <p class="speaker-bio">متخصص هوش مصنوعی و یادگیری عمیق. بیش از ۱۵۰ مقاله ISI و نویسنده ۳ کتاب تخصصی. سخنرانی با موضوع «آینده هوش مصنوعی مولد در ایران»</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">م.ا</div>
          <h3>پروفسور ماریا اوانس</h3>
          <div class="speaker-title">دانشگاه استنفورد</div>
          <p class="speaker-bio">پیشگام محاسبات کوانتومی. برنده جایزه تورینگ. سخنرانی: «محاسبات کوانتومی و تحول رمزنگاری»</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">س.ک</div>
          <h3>دکتر سارا کریمی</h3>
          <div class="speaker-title">پژوهشگر MIT Media Lab</div>
          <p class="speaker-bio">فعال در بیوانفورماتیک و AI در پزشکی. سخنرانی: «هوش مصنوعی در تشخیص زودهنگام بیماری‌ها»</p>
        </div>
      </div>

      <h2 class="section-title mt-4">👥 سخنرانان مدعو</h2>
      <div class="grid grid-4">
        <div class="card speaker-card">
          <div class="speaker-avatar">ر.ن</div>
          <h3>مهندس رضا نوری</h3>
          <div class="speaker-title">مدیرعامل استارتاپ‌تک</div>
          <p class="speaker-bio">کارآفرین سریالی حوزه فین‌تک</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ف.ح</div>
          <h3>دکتر فاطمه حسینی</h3>
          <div class="speaker-title">دانشگاه امیرکبیر</div>
          <p class="speaker-bio">متخصص امنیت سایبری</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ا.ج</div>
          <h3>دکتر احمد جعفری</h3>
          <div class="speaker-title">پژوهشگاه دانش‌های بنیادی</div>
          <p class="speaker-bio">رایانش ابری و توزیع‌شده</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ن.پ</div>
          <h3>مهندس نازنین پور</h3>
          <div class="speaker-title">گوگل ایران</div>
          <p class="speaker-bio">مهندسی نرم‌افزار و MLOps</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ک.ر</div>
          <h3>دکتر کامران رضایی</h3>
          <div class="speaker-title">دانشگاه تهران</div>
          <p class="speaker-bio">اینترنت اشیاء صنعتی</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ل.س</div>
          <h3>دکتر لیلا سادات</h3>
          <div class="speaker-title">دانشگاه الزهرا</div>
          <p class="speaker-bio">پردازش زبان طبیعی فارسی</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ب.ط</div>
          <h3>مهندس بهرام طاهری</h3>
          <div class="speaker-title">اسنپ</div>
          <p class="speaker-bio">معماری سیستم‌های مقیاس‌پذیر</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">م.و</div>
          <h3>دکتر مریم وکیلی</h3>
          <div class="speaker-title">دانشگاه شهید بهشتی</div>
          <p class="speaker-bio">بلاکچین و قراردادهای هوشمند</p>
        </div>
      </div>
    </div>
  </section>

    <section class="section" id="dynamic-speakers"><div class="container"><div class="section-header"><h2>سخنرانان ثبت‌شده</h2><p>اطلاعات سخنران‌ها را از بخش سخنرانان در پیشخوان مدیریت کنید.</p></div><?php hm1405_render_dynamic_content('speakers', 12); ?></div></section>
  <?php if (comments_open() || get_comments_number()) comments_template(); ?>
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand"><h3>همایش فناوری ۱۴۰۵</h3><p>رویداد علمی و فناوری سال.</p></div>
        <div><h4>دسترسی</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/about/')); ?>">درباره</a><a href="<?php echo esc_url(home_url('/schedule/')); ?>">برنامه</a><a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a></div></div>
        <div><h4>خدمات</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/register/')); ?>">ثبت‌نام</a><a href="<?php echo esc_url(home_url('/submit-paper/')); ?>">مقاله</a><a href="<?php echo esc_url(home_url('/login/')); ?>">ورود</a></div></div>
        <div><h4>تماس</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/contact/')); ?>">📍 تهران</a><a href="mailto:info@conference.ir">✉️ info@conference.ir</a></div></div>
      </div>
      <div class="footer-bottom"><p>© ۱۴۰۵ همایش فناوری و نوآوری</p></div>
    </div>
  </footer>
  <script src="<?php echo esc_url(get_theme_file_uri("/assets/js/main.js")); ?>"></script>
<?php wp_footer(); ?></body>
</html>
