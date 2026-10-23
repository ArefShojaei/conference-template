<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri("/assets/css/style.css")); ?>">
  <style>
    .faq-item { background:white; border-radius:var(--radius); margin-bottom:12px; box-shadow:var(--shadow-sm); overflow:hidden; }
    .faq-q { padding:18px 24px; font-weight:600; cursor:pointer; display:flex; justify-content:space-between; align-items:center; }
    .faq-q:hover { background:var(--gray-100); }
    .faq-a { padding:0 24px 18px; color:var(--gray-700); display:none; line-height:1.8; }
    .faq-item.open .faq-a { display:block; }
    .faq-item.open .faq-q span:last-child { transform:rotate(45deg); }
  </style>
</head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
  <header class="header">
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
      <h1 style="font-size:2rem;margin-bottom:10px;">سوالات متداول</h1>
      <p style="opacity:0.9;">پاسخ به پرسش‌های رایج شرکت‌کنندگان و نویسندگان</p>
    </div>
  </section>

  <section class="section">
    <div class="container" style="max-width:800px;">
      <div class="faq-item open">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">مهلت ارسال مقاله تا چه تاریخی است؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">مهلت ارسال مقالات تا ۳۰ مهر ۱۴۰۵ تمدید شده است. پس از این تاریخ امکان ارسال وجود ندارد.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">آیا مقالات به زبان انگلیسی هم پذیرفته می‌شود؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">بله، مقالات به هر دو زبان فارسی و انگلیسی پذیرفته می‌شوند. مجموعه مقالات نهایی نیز دو زبانه خواهد بود.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">فرآیند داوری چگونه است؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">داوری به صورت دوسویه ناشناس (Double-blind) انجام می‌شود. هر مقاله حداقل توسط دو داور متخصص بررسی می‌شود و نتایج تا ۱۵ آبان اعلام خواهد شد.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">هزینه ثبت‌نام شامل چه مواردی است؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">هزینه شامل حضور در تمام جلسات، پذیرایی، بسته همایش، گواهی شرکت و دسترسی به مجموعه مقالات الکترونیکی است.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">آیا تخفیف دانشجویی وجود دارد؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">بله، دانشجویان با ارائه کارت دانشجویی معتبر می‌توانند از تعرفه دانشجویی استفاده کنند.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">چگونه وضعیت مقاله خود را پیگیری کنم؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">پس از ورود به پنل کاربری، از بخش «مقالات من» می‌توانید وضعیت لحظه‌ای مقالات خود را مشاهده کنید.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">آیا امکان شرکت مجازی وجود دارد؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">در این دوره همایش به صورت حضوری برگزار می‌شود. امکان پخش زنده برخی جلسات از طریق وب‌سایت اعلام خواهد شد.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">قالب مقاله را از کجا دانلود کنم؟ <span style="font-size:1.5rem;transition:0.3s;">+</span></div>
        <div class="faq-a">قالب استاندارد مقاله (Word و LaTeX) از صفحه ارسال مقاله قابل دانلود است. لطفاً حتماً از قالب رسمی استفاده کنید.</div>
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
