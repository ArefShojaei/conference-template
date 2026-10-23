<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo esc_html(wp_get_document_title()); ?></title><?php wp_head(); ?>
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri("/assets/css/style.css")); ?>">
</head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
  <header class="header">
    <div class="header-top"><div class="container"><div><span>📅 ۱۵ تا ۱۷ آذر ۱۴۰۵</span></div><div style="display:flex;gap:20px;"><a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس</a><a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات</a></div></div></div>
    <div class="container">
      <nav class="navbar">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><div class="logo-icon">هـ</div><span>همایش فناوری ۱۴۰۵</span></a>
        <button class="menu-toggle">☰</button>
        <div class="nav-menu">
          <a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a>
          <a href="<?php echo esc_url(home_url('/about/')); ?>">درباره</a>
          <a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a>
          <a href="<?php echo esc_url(home_url('/schedule/')); ?>" class="active">برنامه زمانی</a>
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
      <h1 style="font-size:2.2rem;margin-bottom:12px;">برنامه زمانی همایش</h1>
      <p style="opacity:0.9;">۱۵ تا ۱۷ آذر ۱۴۰۵ — مرکز همایش‌های بین‌المللی تهران</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="tabs">
        <button class="tab-btn active" data-tab="day1">روز اول — ۱۵ آذر</button>
        <button class="tab-btn" data-tab="day2">روز دوم — ۱۶ آذر</button>
        <button class="tab-btn" data-tab="day3">روز سوم — ۱۷ آذر</button>
      </div>

      <div id="day1" class="tab-content active">
        <div class="schedule-day">
          <div class="schedule-item">
            <div class="schedule-time">۰۸:۳۰ – ۰۹:۳۰</div>
            <div class="schedule-content">
              <h4>ثبت‌نام و پذیرایی صبحانه</h4>
              <p>سالن ورودی اصلی</p>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۰۹:۳۰ – ۱۰:۳۰</div>
            <div class="schedule-content">
              <h4>مراسم افتتاحیه</h4>
              <p>سخنرانی دبیر همایش و مقامات</p>
              <div class="schedule-speaker">سالن اصلی</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۰:۳۰ – ۱۲:۰۰</div>
            <div class="schedule-content">
              <h4>سخنرانی کلیدی: آینده هوش مصنوعی مولد</h4>
              <p>بررسی روندها و چالش‌های هوش مصنوعی مولد در ایران و جهان</p>
              <div class="schedule-speaker">دکتر علی محمدی — سالن اصلی</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۲:۰۰ – ۱۳:۳۰</div>
            <div class="schedule-content">
              <h4>ناهار و شبکه‌سازی</h4>
              <p>سالن پذیرایی</p>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۳:۳۰ – ۱۵:۳۰</div>
            <div class="schedule-content">
              <h4>جلسات موازی ارائه مقالات (سری A)</h4>
              <p>هوش مصنوعی — رایانش ابری — امنیت</p>
              <div class="schedule-speaker">سالن‌های A1، A2، A3</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۵:۳۰ – ۱۶:۰۰</div>
            <div class="schedule-content">
              <h4>استراحت و پذیرایی</h4>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۶:۰۰ – ۱۸:۰۰</div>
            <div class="schedule-content">
              <h4>کارگاه تخصصی: MLOps عملی</h4>
              <p>از توسعه مدل تا استقرار در محیط تولید</p>
              <div class="schedule-speaker">مهندس نازنین پور — سالن کارگاه ۱</div>
            </div>
          </div>
        </div>
      </div>

      <div id="day2" class="tab-content">
        <div class="schedule-day">
          <div class="schedule-item">
            <div class="schedule-time">۰۹:۰۰ – ۱۰:۳۰</div>
            <div class="schedule-content">
              <h4>سخنرانی کلیدی: محاسبات کوانتومی</h4>
              <p>تحول رمزنگاری و آینده محاسبات</p>
              <div class="schedule-speaker">پروفسور ماریا اوانس — سالن اصلی</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۰:۴۵ – ۱۲:۳۰</div>
            <div class="schedule-content">
              <h4>جلسات موازی ارائه مقالات (سری B)</h4>
              <p>بیوانفورماتیک — IoT — نوآوری دیجیتال</p>
              <div class="schedule-speaker">سالن‌های B1، B2، B3</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۲:۳۰ – ۱۴:۰۰</div>
            <div class="schedule-content">
              <h4>ناهار</h4>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۴:۰۰ – ۱۶:۰۰</div>
            <div class="schedule-content">
              <h4>پنل تخصصی: تحول دیجیتال در صنعت ایران</h4>
              <p>با حضور مدیران شرکت‌های پیشرو فناوری</p>
              <div class="schedule-speaker">سالن اصلی</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۶:۱۵ – ۱۸:۰۰</div>
            <div class="schedule-content">
              <h4>جلسه پوستر و نمایشگاه استارتاپ‌ها</h4>
              <p>ارائه پوستر مقالات و نمایش محصولات نوآورانه</p>
              <div class="schedule-speaker">سالن نمایشگاه</div>
            </div>
          </div>
        </div>
      </div>

      <div id="day3" class="tab-content">
        <div class="schedule-day">
          <div class="schedule-item">
            <div class="schedule-time">۰۹:۰۰ – ۱۰:۳۰</div>
            <div class="schedule-content">
              <h4>سخنرانی کلیدی: AI در پزشکی</h4>
              <p>هوش مصنوعی در تشخیص و درمان</p>
              <div class="schedule-speaker">دکتر سارا کریمی — سالن اصلی</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۰:۴۵ – ۱۲:۳۰</div>
            <div class="schedule-content">
              <h4>جلسات موازی نهایی</h4>
              <p>ارائه مقالات منتخب و بحث آزاد</p>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۲:۳۰ – ۱۴:۰۰</div>
            <div class="schedule-content">
              <h4>ناهار</h4>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۴:۰۰ – ۱۵:۳۰</div>
            <div class="schedule-content">
              <h4>مراسم اختتامیه و اهدای جوایز</h4>
              <p>تقدیر از بهترین مقالات، پوسترها و ارائه‌ها</p>
              <div class="schedule-speaker">سالن اصلی</div>
            </div>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">۱۵:۳۰ – ۱۶:۰۰</div>
            <div class="schedule-content">
              <h4>عکس یادگاری و خداحافظی</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand"><h3>همایش فناوری ۱۴۰۵</h3><p>رویداد علمی سال.</p></div>
        <div><h4>دسترسی</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/about/')); ?>">درباره</a><a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a><a href="<?php echo esc_url(home_url('/papers/')); ?>">مقالات</a></div></div>
        <div><h4>خدمات</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/register/')); ?>">ثبت‌نام</a><a href="<?php echo esc_url(home_url('/submit-paper/')); ?>">مقاله</a><a href="<?php echo esc_url(home_url('/login/')); ?>">ورود</a></div></div>
        <div><h4>تماس</h4><div class="footer-links"><a href="<?php echo esc_url(home_url('/contact/')); ?>">📍 تهران</a><a href="mailto:info@conference.ir">✉️ info@conference.ir</a></div></div>
      </div>
      <div class="footer-bottom"><p>© ۱۴۰۵ همایش فناوری و نوآوری</p></div>
    </div>
  </footer>
  <script src="<?php echo esc_url(get_theme_file_uri("/assets/js/main.js")); ?>"></script>
<?php wp_footer(); ?></body>
</html>
