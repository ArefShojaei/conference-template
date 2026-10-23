<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <meta name="description" content="وب‌سایت رسمی همایش بین‌المللی فناوری و نوآوری - ثبت‌نام، ارسال مقاله، داوری و مدیریت رویداد">
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri("/assets/css/style.css")); ?>">
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri("/assets/css/mvp-redesign.css")); ?>">
</head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
  <!-- Header -->
  <header class="header">
    <div class="header-top">
      <div class="container">
        <div>
          <span>📅 <?php echo esc_html(get_theme_mod("hm1405_conference_date","۱۵ تا ۱۷ آذر ۱۴۰۵")); ?> | <?php echo esc_html(get_theme_mod("hm1405_conference_location","تهران، مرکز همایش‌های بین‌المللی")); ?></span>
        </div>
        <div style="display:flex;gap:20px;">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a>
          <a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات متداول</a>
        </div>
      </div>
    </div>
    <div class="container">
      <nav class="navbar">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
          <div class="logo-icon">هـ</div>
          <span>همایش فناوری ۱۴۰۵</span>
        </a>
        <button class="menu-toggle" aria-label="منو">☰</button>
        <div class="nav-menu"><?php wp_nav_menu(array('theme_location'=>'primary','container'=>false,'fallback_cb'=>'hm1405_fallback_menu','items_wrap'=>'%3$s')); ?></div>
        <div class="nav-actions">
          <a href="<?php echo esc_url(home_url('/login/')); ?>" class="btn btn-outline btn-sm">ورود</a>
          <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-primary btn-sm">ثبت‌نام</a>
        </div>
      </nav>
    </div>
  </header>

  <!-- Editorial event hero / carousel -->
  <section class="event-hero" aria-label="رویدادهای برجسته همایش">
    <div class="container event-hero-grid">
      <div class="event-carousel" data-carousel aria-roledescription="carousel" aria-label="اسلایدر همایش">
        <article class="event-slide is-active" data-slide aria-hidden="false" style="--slide-image:url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1800&q=85')"><div class="event-slide-overlay"></div><div class="event-slide-content"><span class="eyebrow"><span class="eyebrow-dot"></span> رویداد علمی • ۱۴۰۵</span><p class="event-kicker">فناوری، پژوهش، آینده</p><h1>ایده‌های بزرگ،<br><em>آینده‌های روشن</em></h1><p class="event-slide-copy">جایی برای ارائه پژوهش‌های تازه، گفت‌وگو با متخصصان و ساختن همکاری‌هایی که از مرز رشته‌ها عبور می‌کنند.</p><div class="event-slide-actions"><a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-accent btn-lg">ثبت‌نام در همایش <span aria-hidden="true">←</span></a><a href="<?php echo esc_url(home_url('/submit-paper/')); ?>" class="event-text-link">ارسال مقاله <span aria-hidden="true">↗</span></a></div></div><div class="slide-index"><strong>۰۱</strong><span>/ ۰۳</span></div></article>
        <article class="event-slide" data-slide aria-hidden="true" style="--slide-image:url('https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=1800&q=85')"><div class="event-slide-overlay"></div><div class="event-slide-content"><span class="eyebrow"><span class="eyebrow-dot"></span> فراخوان مقاله</span><p class="event-kicker">پژوهش خود را به اشتراک بگذارید</p><h2>صدای پژوهش شما،<br><em>بخشی از تغییر است</em></h2><p class="event-slide-copy">پژوهشگران، دانشجویان و متخصصان دعوت‌اند تا دستاوردهای خود را در محورهای علمی همایش ارائه کنند.</p><div class="event-slide-actions"><a href="<?php echo esc_url(home_url('/submit-paper/')); ?>" class="btn btn-accent btn-lg">راهنمای ارسال مقاله <span aria-hidden="true">←</span></a><a href="<?php echo esc_url(home_url('/papers/')); ?>" class="event-text-link">محورهای علمی <span aria-hidden="true">↗</span></a></div></div><div class="slide-index"><strong>۰۲</strong><span>/ ۰۳</span></div></article>
        <article class="event-slide" data-slide aria-hidden="true" style="--slide-image:url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1800&q=85')"><div class="event-slide-overlay"></div><div class="event-slide-content"><span class="eyebrow"><span class="eyebrow-dot"></span> شبکه‌سازی حرفه‌ای</span><p class="event-kicker">از دیدار تا همکاری</p><h2>آینده را با هم<br><em>طراحی می‌کنیم</em></h2><p class="event-slide-copy">سه روز گفت‌وگو، یادگیری و ارتباط با جامعه‌ای از پژوهشگران و پیشگامان فناوری.</p><div class="event-slide-actions"><a href="<?php echo esc_url(home_url('/schedule/')); ?>" class="btn btn-accent btn-lg">مشاهده برنامه <span aria-hidden="true">←</span></a><a href="<?php echo esc_url(home_url('/speakers/')); ?>" class="event-text-link">سخنرانان <span aria-hidden="true">↗</span></a></div></div><div class="slide-index"><strong>۰۳</strong><span>/ ۰۳</span></div></article>
        <div class="carousel-controls"><div class="carousel-dots" role="group" aria-label="انتخاب اسلاید"><button type="button" class="carousel-dot is-active" data-slide-to="0" aria-label="اسلاید اول" aria-pressed="true"></button><button type="button" class="carousel-dot" data-slide-to="1" aria-label="اسلاید دوم" aria-pressed="false"></button><button type="button" class="carousel-dot" data-slide-to="2" aria-label="اسلاید سوم" aria-pressed="false"></button></div><div class="carousel-arrows"><button type="button" data-slide-prev aria-label="اسلاید قبلی">→</button><button type="button" data-slide-next aria-label="اسلاید بعدی">←</button><button type="button" data-slide-pause aria-label="توقف حرکت خودکار" aria-pressed="false">Ⅱ</button></div></div>
      </div>
      <aside class="event-side-rail"><div class="rail-card rail-countdown"><div class="rail-topline"><span class="rail-pulse"></span> ثبت‌نام فعال است</div><p class="rail-label">همایش بین‌المللی</p><h2>فناوری و<br>نوآوری ۱۴۰۵</h2><div class="rail-date"><span>۱۵—۱۷</span><small>آذر ۱۴۰۵</small></div><div class="rail-divider"></div><div class="rail-meta"><span>مکان</span><strong>تهران، مرکز همایش‌ها</strong></div><div class="rail-meta"><span>مهلت ارسال مقاله</span><strong>۳۰ مهر ۱۴۰۵</strong></div><a href="<?php echo esc_url(home_url('/register/')); ?>" class="rail-cta">جای خود را رزرو کنید <span>↗</span></a></div><a href="<?php echo esc_url(home_url('/schedule/')); ?>" class="rail-mini-card"><span class="rail-mini-icon">◷</span><span><strong>برنامه همایش</strong><small>جلسه‌ها و کارگاه‌ها را ببینید</small></span><span class="rail-mini-arrow">←</span></a></aside>
    </div>
  </section>
  <section class="hero-proof-strip"><div class="container proof-strip-inner"><div><strong>۰۳</strong><span>روز تجربه و یادگیری</span></div><i></i><div><strong>۱۲+</strong><span>کارگاه تخصصی</span></div><i></i><div><strong>۴۵+</strong><span>سخنران و متخصص</span></div><i></i><div><strong>۱۲۰۰+</strong><span>شرکت‌کننده جامعه علمی</span></div><a href="<?php echo esc_url(home_url('/about/')); ?>">درباره رویداد <span>↗</span></a></div></section>

  <!-- Features -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <h2>چرا در این همایش شرکت کنید؟</h2>
        <p>فرصتی منحصربه‌فرد برای یادگیری، شبکه‌سازی و ارائه پژوهش‌های خود در سطح بین‌المللی</p>
      </div>
      <div class="grid grid-3">
        <div class="card feature-card">
          <div class="feature-icon">📝</div>
          <h3>ارسال و داوری مقاله</h3>
          <p>سیستم کامل ارسال مقاله، داوری دوسویه ناشناس و پیگیری وضعیت مقالات به صورت آنلاین</p>
        </div>
        <div class="card feature-card">
          <div class="feature-icon">🎤</div>
          <h3>سخنرانان برجسته</h3>
          <p>حضور اساتید و متخصصان برجسته داخلی و بین‌المللی از دانشگاه‌ها و شرکت‌های پیشرو</p>
        </div>
        <div class="card feature-card">
          <div class="feature-icon">🤝</div>
          <h3>شبکه‌سازی حرفه‌ای</h3>
          <p>فرصت ملاقات با پژوهشگران، سرمایه‌گذاران و فعالان صنعت فناوری در فضای اختصاصی</p>
        </div>
        <div class="card feature-card">
          <div class="feature-icon">🏆</div>
          <h3>جوایز و تقدیر</h3>
          <p>اعطای جوایز به بهترین مقالات، پوسترها و ارائه‌های شفاهی در مراسم اختتامیه</p>
        </div>
        <div class="card feature-card">
          <div class="feature-icon">📚</div>
          <h3>انتشار مقالات</h3>
          <p>انتشار مقالات پذیرفته‌شده در مجموعه مقالات همایش با ایندکس بین‌المللی</p>
        </div>
        <div class="card feature-card">
          <div class="feature-icon">💻</div>
          <h3>پنل کاربری کامل</h3>
          <p>داشبورد اختصاصی برای شرکت‌کنندگان، نویسندگان، داوران و مدیران رویداد</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Important Dates -->
  <section class="section" style="background:white;">
    <div class="container">
      <div class="section-header">
        <h2>تاریخ‌های مهم</h2>
        <p>مهلت‌ها و رویدادهای کلیدی همایش را از دست ندهید</p>
      </div>
      <div class="grid grid-4">
        <div class="card" style="padding:25px;text-align:center;border-top:4px solid var(--primary);">
          <div style="font-size:2rem;margin-bottom:10px;">📅</div>
          <h3 style="font-size:1rem;margin-bottom:8px;">مهلت ارسال مقاله</h3>
          <p class="text-primary fw-bold">۳۰ مهر ۱۴۰۵</p>
        </div>
        <div class="card" style="padding:25px;text-align:center;border-top:4px solid var(--secondary);">
          <div style="font-size:2rem;margin-bottom:10px;">✅</div>
          <h3 style="font-size:1rem;margin-bottom:8px;">اعلام نتایج داوری</h3>
          <p class="text-primary fw-bold">۱۵ آبان ۱۴۰۵</p>
        </div>
        <div class="card" style="padding:25px;text-align:center;border-top:4px solid var(--accent);">
          <div style="font-size:2rem;margin-bottom:10px;">💳</div>
          <h3 style="font-size:1rem;margin-bottom:8px;">مهلت ثبت‌نام نهایی</h3>
          <p class="text-primary fw-bold">۳۰ آبان ۱۴۰۵</p>
        </div>
        <div class="card" style="padding:25px;text-align:center;border-top:4px solid var(--success);">
          <div style="font-size:2rem;margin-bottom:10px;">🎉</div>
          <h3 style="font-size:1rem;margin-bottom:8px;">برگزاری همایش</h3>
          <p class="text-primary fw-bold">۱۵ تا ۱۷ آذر ۱۴۰۵</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Speakers Preview -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <h2>سخنرانان کلیدی</h2>
        <p>با برخی از سخنرانان برجسته این دوره آشنا شوید</p>
      </div>
      <div class="grid grid-4">
        <div class="card speaker-card">
          <div class="speaker-avatar">ع.م</div>
          <h3>دکتر علی محمدی</h3>
          <div class="speaker-title">استاد دانشگاه شریف</div>
          <p class="speaker-bio">متخصص هوش مصنوعی و یادگیری ماشین با بیش از ۱۵۰ مقاله ISI</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">س.ک</div>
          <h3>دکتر سارا کریمی</h3>
          <div class="speaker-title">پژوهشگر MIT</div>
          <p class="speaker-bio">فعال در حوزه بیوانفورماتیک و داده‌کاوی زیستی</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">ر.ن</div>
          <h3>مهندس رضا نوری</h3>
          <div class="speaker-title">مدیرعامل استارتاپ‌تک</div>
          <p class="speaker-bio">کارآفرین سریالی و سرمایه‌گذار حوزه فناوری</p>
        </div>
        <div class="card speaker-card">
          <div class="speaker-avatar">م.ا</div>
          <h3>پروفسور ماریا اوانس</h3>
          <div class="speaker-title">دانشگاه استنفورد</div>
          <p class="speaker-bio">پیشگام در حوزه محاسبات کوانتومی و رمزنگاری</p>
        </div>
      </div>
      <div class="text-center mt-4">
        <a href="<?php echo esc_url(home_url('/speakers/')); ?>" class="btn btn-outline">مشاهده همه سخنرانان</a>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section" style="background:linear-gradient(135deg,var(--primary),var(--secondary));color:white;">
    <div class="container text-center">
      <h2 style="font-size:2rem;margin-bottom:15px;">آماده شرکت در همایش هستید؟</h2>
      <p style="opacity:0.9;margin-bottom:30px;max-width:600px;margin-left:auto;margin-right:auto;">همین حالا ثبت‌نام کنید و از تخفیف Early Bird بهره‌مند شوید. ظرفیت محدود است!</p>
      <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
        <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-accent btn-lg">ثبت‌نام شرکت‌کننده</a>
        <a href="<?php echo esc_url(home_url('/submit-paper/')); ?>" class="btn btn-outline btn-lg" style="border-color:white;color:white;">ارسال مقاله</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
    <section class="section" id="latest-news"><div class="container"><div class="section-header"><h2>آخرین اخبار و مطالب</h2><p>محتوا را از بخش «نوشته‌ها» در پیشخوان وردپرس مدیریت کنید.</p></div><?php hm1405_render_dynamic_content('posts', 3); ?></div></section>
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <h3>همایش فناوری و نوآوری ۱۴۰۵</h3>
          <p>بزرگ‌ترین رویداد علمی و فناوری سال با هدف ایجاد پل ارتباطی بین دانشگاه، صنعت و جامعه.</p>
          <div class="social-links">
            <span title="تلگرام" aria-label="تلگرام">✈️</span>
            <span title="اینستاگرام" aria-label="اینستاگرام">📷</span>
            <span title="لینکدین" aria-label="لینکدین">💼</span>
            <span title="توییتر" aria-label="توییتر">🐦</span>
          </div>
        </div>
        <div>
          <h4>دسترسی سریع</h4>
          <div class="footer-links">
            <a href="<?php echo esc_url(home_url('/about/')); ?>">درباره همایش</a>
            <a href="<?php echo esc_url(home_url('/schedule/')); ?>">برنامه زمانی</a>
            <a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a>
            <a href="<?php echo esc_url(home_url('/papers/')); ?>">مقالات</a>
          </div>
        </div>
        <div>
          <h4>خدمات</h4>
          <div class="footer-links">
            <a href="<?php echo esc_url(home_url('/register/')); ?>">ثبت‌نام</a>
            <a href="<?php echo esc_url(home_url('/submit-paper/')); ?>">ارسال مقاله</a>
            <a href="<?php echo esc_url(home_url('/login/')); ?>">ورود به پنل</a>
            <a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات متداول</a>
          </div>
        </div>
        <div>
          <h4>تماس با ما</h4>
          <div class="footer-links">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>">📍 تهران، خیابان ولیعصر</a>
            <a href="tel:+982188776655">📞 ۰۲۱-۸۸۷۷۶۶۵۵</a>
            <a href="mailto:info@conference.ir">✉️ info@conference.ir</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© ۱۴۰۵ همایش بین‌المللی فناوری و نوآوری — تمامی حقوق محفوظ است. | قالب آماده برای وردپرس</p>
      </div>
    </div>
  </footer>

  <script src="<?php echo esc_url(get_theme_file_uri("/assets/js/main.js")); ?>"></script>
<?php wp_footer(); ?></body>
</html>
