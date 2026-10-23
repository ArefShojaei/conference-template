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
        <div class="nav-menu">
          <a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a>
          <a href="<?php echo esc_url(home_url('/about/')); ?>">درباره</a>
          <a href="<?php echo esc_url(home_url('/speakers/')); ?>">سخنرانان</a>
          <a href="<?php echo esc_url(home_url('/schedule/')); ?>">برنامه</a>
          <a href="<?php echo esc_url(home_url('/papers/')); ?>" class="active">مقالات</a>
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

  <section class="section" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);color:white;padding:50px 0;">
    <div class="container text-center">
      <h1 style="font-size:2rem;margin-bottom:10px;">مقالات پذیرفته‌شده</h1>
      <p style="opacity:0.9;">لیست مقالات پذیرفته‌شده برای ارائه در همایش</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="d-flex justify-between align-center flex-wrap gap-2 mb-3">
        <div class="d-flex gap-2 flex-wrap">
          <select class="form-control" style="width:auto;">
            <option>همه محورها</option>
            <option>هوش مصنوعی</option>
            <option>رایانش ابری</option>
            <option>امنیت سایبری</option>
            <option>IoT</option>
            <option>بیوانفورماتیک</option>
          </select>
          <select class="form-control" style="width:auto;">
            <option>همه انواع</option>
            <option>شفاهی</option>
            <option>پوستر</option>
          </select>
        </div>
        <input type="search" class="form-control" placeholder="جستجو در مقالات..." style="max-width:300px;">
      </div>

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>کد</th>
              <th>عنوان مقاله</th>
              <th>نویسندگان</th>
              <th>محور</th>
              <th>نوع</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>#P-1001</td>
              <td>بهبود دقت مدل‌های یادگیری عمیق در تشخیص تصویر پزشکی</td>
              <td>علی محمدی، سارا کریمی</td>
              <td><span class="badge badge-primary">هوش مصنوعی</span></td>
              <td>شفاهی</td>
            </tr>
            <tr>
              <td>#P-1005</td>
              <td>چارچوب امنیتی نوین برای شبکه‌های بلاکچین</td>
              <td>رضا نوری، فاطمه حسینی</td>
              <td><span class="badge badge-primary">امنیت</span></td>
              <td>شفاهی</td>
            </tr>
            <tr>
              <td>#P-1012</td>
              <td>بهینه‌سازی مصرف انرژی در سیستم‌های IoT</td>
              <td>کامران رضایی</td>
              <td><span class="badge badge-primary">IoT</span></td>
              <td>پوستر</td>
            </tr>
            <tr>
              <td>#P-1018</td>
              <td>تحلیل داده‌های ژنومی با الگوریتم‌های تکاملی</td>
              <td>مریم وکیلی، احمد جعفری</td>
              <td><span class="badge badge-primary">بیوانفورماتیک</span></td>
              <td>شفاهی</td>
            </tr>
            <tr>
              <td>#P-1023</td>
              <td>معماری میکروسرویس مقیاس‌پذیر برای اپلیکیشن‌های ابری</td>
              <td>نازنین پور، بهرام طاهری</td>
              <td><span class="badge badge-primary">رایانش ابری</span></td>
              <td>شفاهی</td>
            </tr>
            <tr>
              <td>#P-1027</td>
              <td>پردازش زبان طبیعی فارسی با مدل‌های از پیش آموزش‌دیده</td>
              <td>لیلا سادات</td>
              <td><span class="badge badge-primary">هوش مصنوعی</span></td>
              <td>پوستر</td>
            </tr>
            <tr>
              <td>#P-1031</td>
              <td>کاربرد یادگیری تقویتی در مدیریت ترافیک شهری</td>
              <td>حسین کاظمی، نرگس موسوی</td>
              <td><span class="badge badge-primary">هوش مصنوعی</span></td>
              <td>شفاهی</td>
            </tr>
            <tr>
              <td>#P-1036</td>
              <td>قراردادهای هوشمند و کاربرد در زنجیره تأمین</td>
              <td>مریم وکیلی</td>
              <td><span class="badge badge-primary">بلاکچین</span></td>
              <td>پوستر</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="pagination">
        <span aria-disabled="true" title="این بخش هنوز پیاده‌سازی نشده">«</span>
        <span class="active">۱</span>
        <span aria-disabled="true" title="این بخش هنوز پیاده‌سازی نشده">۲</span>
        <span aria-disabled="true" title="این بخش هنوز پیاده‌سازی نشده">۳</span>
        <span aria-disabled="true" title="این بخش هنوز پیاده‌سازی نشده">»</span>
      </div>
    </div>
  </section>

    <section class="section" id="dynamic-events"><div class="container"><div class="section-header"><h2>رویدادها و فراخوان‌های ثبت‌شده</h2><p>این بخش از محتوای همایش‌ها در پیشخوان مدیریت می‌شود.</p></div><?php hm1405_render_dynamic_content('events', 6); ?></div></section>
  <footer class="footer">
    <div class="container">
      <div class="footer-bottom"><p>© ۱۴۰۵ همایش فناوری و نوآوری</p></div>
    </div>
  </footer>
  <script src="<?php echo esc_url(get_theme_file_uri("/assets/js/main.js")); ?>"></script>
<?php wp_footer(); ?></body>
</html>
