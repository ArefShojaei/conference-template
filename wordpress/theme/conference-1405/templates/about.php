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
    <div class="header-top">
      <div class="container">
        <div><span>📅 ۱۵ تا ۱۷ آذر ۱۴۰۵ | تهران</span></div>
        <div style="display:flex;gap:20px;"><a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس</a><a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات متداول</a></div>
      </div>
    </div>
    <div class="container">
      <nav class="navbar">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><div class="logo-icon">هـ</div><span>همایش فناوری ۱۴۰۵</span></a>
        <button class="menu-toggle">☰</button>
        <div class="nav-menu">
          <a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a>
          <a href="<?php echo esc_url(home_url('/about/')); ?>" class="active">درباره همایش</a>
          <a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a>
          <a href="<?php echo esc_url(home_url('/schedule/')); ?>">برنامه زمانی</a>
          <a href="<?php echo esc_url(home_url('/papers/')); ?>">مقالات</a>
          <a href="<?php echo esc_url(home_url('/register/')); ?>">ثبت‌نام</a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس</a>
        </div>
        <div class="nav-actions">
          <a href="<?php echo esc_url(home_url('/login/')); ?>" class="btn btn-outline btn-sm">ورود</a>
          <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-primary btn-sm">ثبت‌نام</a>
        </div>
      </nav>
    </div>
  </header>

  <section class="section" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);color:white;padding:60px 0;">
    <div class="container text-center">
      <h1 style="font-size:2.2rem;margin-bottom:12px;">درباره همایش</h1>
      <p style="opacity:0.9;max-width:600px;margin:0 auto;">آشنایی با اهداف، محورها و برگزارکنندگان همایش بین‌المللی فناوری و نوآوری</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-2" style="align-items:center;gap:50px;">
        <div>
          <h2 class="section-title">🎯 اهداف همایش</h2>
          <p style="color:var(--gray-700);margin-bottom:20px;line-height:1.9;">همایش بین‌المللی فناوری و نوآوری با هدف ایجاد بستری برای تبادل دانش، ارائه آخرین دستاوردهای پژوهشی و تقویت همکاری میان دانشگاه، صنعت و جامعه برگزار می‌شود.</p>
          <ul style="color:var(--gray-700);">
            <li style="padding:8px 0;display:flex;gap:10px;"><span style="color:var(--primary);">✓</span> معرفی آخرین پژوهش‌ها در حوزه هوش مصنوعی و فناوری‌های نوین</li>
            <li style="padding:8px 0;display:flex;gap:10px;"><span style="color:var(--primary);">✓</span> ایجاد فرصت شبکه‌سازی بین پژوهشگران و فعالان صنعت</li>
            <li style="padding:8px 0;display:flex;gap:10px;"><span style="color:var(--primary);">✓</span> حمایت از ایده‌های نوآورانه و استارتاپ‌های فناور</li>
            <li style="padding:8px 0;display:flex;gap:10px;"><span style="color:var(--primary);">✓</span> انتشار مقالات علمی در مجموعه مقالات با ایندکس بین‌المللی</li>
          </ul>
        </div>
        <div class="card" style="padding:40px;background:linear-gradient(135deg,#eff6ff,#f0fdfa);">
          <h3 style="margin-bottom:20px;color:var(--primary);">آمار همایش سال گذشته</h3>
          <div class="grid grid-2" style="gap:20px;">
            <div style="text-align:center;"><div style="font-size:2rem;font-weight:800;color:var(--primary);">۹۵۰+</div><div class="text-muted">شرکت‌کننده</div></div>
            <div style="text-align:center;"><div style="font-size:2rem;font-weight:800;color:var(--secondary);">۶۵</div><div class="text-muted">مقاله پذیرفته</div></div>
            <div style="text-align:center;"><div style="font-size:2rem;font-weight:800;color:var(--accent);">۳۸</div><div class="text-muted">سخنران</div></div>
            <div style="text-align:center;"><div style="font-size:2rem;font-weight:800;color:var(--success);">۱۰</div><div class="text-muted">کشور</div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="background:white;">
    <div class="container">
      <div class="section-header">
        <h2>محورهای همایش</h2>
        <p>موضوعات و محورهای اصلی پذیرش مقاله و سخنرانی</p>
      </div>
      <div class="grid grid-3">
        <div class="card" style="padding:25px;">
          <h3 style="color:var(--primary);margin-bottom:12px;">🤖 هوش مصنوعی</h3>
          <p class="text-muted">یادگیری ماشین، یادگیری عمیق، پردازش زبان طبیعی، بینایی ماشین و سیستم‌های هوشمند</p>
        </div>
        <div class="card" style="padding:25px;">
          <h3 style="color:var(--primary);margin-bottom:12px;">☁️ رایانش ابری</h3>
          <p class="text-muted">معماری ابری، امنیت ابر، DevOps، میکروسرویس و زیرساخت‌های مقیاس‌پذیر</p>
        </div>
        <div class="card" style="padding:25px;">
          <h3 style="color:var(--primary);margin-bottom:12px;">🔐 امنیت سایبری</h3>
          <p class="text-muted">رمزنگاری، امنیت شبکه، بلاکچین، حریم خصوصی و مقابله با تهدیدات سایبری</p>
        </div>
        <div class="card" style="padding:25px;">
          <h3 style="color:var(--primary);margin-bottom:12px;">📱 اینترنت اشیاء</h3>
          <p class="text-muted">IoT صنعتی، شهر هوشمند، حسگرها، پروتکل‌های ارتباطی و تحلیل داده IoT</p>
        </div>
        <div class="card" style="padding:25px;">
          <h3 style="color:var(--primary);margin-bottom:12px;">🧬 بیوانفورماتیک</h3>
          <p class="text-muted">تحلیل داده ژنومی، پزشکی شخصی‌سازی‌شده، داروهای هوشمند و مدل‌سازی زیستی</p>
        </div>
        <div class="card" style="padding:25px;">
          <h3 style="color:var(--primary);margin-bottom:12px;">💡 نوآوری دیجیتال</h3>
          <p class="text-muted">تحول دیجیتال، استارتاپ‌ها، مدل‌های کسب‌وکار نوین و فناوری‌های نوظهور</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-header">
        <h2>کمیته برگزاری</h2>
      </div>
      <div class="grid grid-3">
        <div class="card speaker-card">
          <div class="speaker-avatar">د.ر</div>
          <h3>دکتر رضا احمدی</h3>
          <div class="speaker-title">دبیر علمی همایش</div>
          <p class="speaker-bio">استاد دانشکده مهندسی کامپیوتر دانشگاه تهران</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ن.م</div>
          <h3>دکتر نرگس موسوی</h3>
          <div class="speaker-title">دبیر اجرایی</div>
          <p class="speaker-bio">عضو هیئت علمی دانشگاه امیرکبیر</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ح.ک</div>
          <h3>دکتر حسین کاظمی</h3>
          <div class="speaker-title">رئیس کمیته داوری</div>
          <p class="speaker-bio">پژوهشگر ارشد پژوهشگاه دانش‌های بنیادی</p>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <h3>همایش فناوری و نوآوری ۱۴۰۵</h3>
          <p>بزرگ‌ترین رویداد علمی و فناوری سال.</p>
        </div>
        <div><h4>دسترسی سریع</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/about/')); ?>">درباره</a><a href="<?php echo esc_url(home_url('/schedule/')); ?>">برنامه</a><a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a></div></div>
        <div><h4>خدمات</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/register/')); ?>">ثبت‌نام</a><a href="<?php echo esc_url(home_url('/submit-paper/')); ?>">ارسال مقاله</a><a href="<?php echo esc_url(home_url('/login/')); ?>">ورود</a></div></div>
        <div><h4>تماس</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/contact/')); ?>">📍 تهران</a><a href="tel:+982188776655">📞 ۰۲۱-۸۸۷۷۶۶۵۵</a><a href="mailto:info@conference.ir">✉️ info@conference.ir</a></div></div>
      </div>
      <div class="footer-bottom"><p>© ۱۴۰۵ همایش فناوری و نوآوری — تمامی حقوق محفوظ است.</p></div>
    </div>
  </footer>
  <script src="<?php echo esc_url(get_theme_file_uri("/assets/js/main.js")); ?>"></script>
<?php wp_footer(); ?></body>
</html>
