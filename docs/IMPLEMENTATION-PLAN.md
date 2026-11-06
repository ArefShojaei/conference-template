# برنامه انتقال از HTML preview به WordPress production

## فاز ۱ — آماده‌سازی
- [ ] ساخت staging و بکاپ کامل فایل‌ها/دیتابیس
- [ ] PHP 8.2+، WordPress جدید، HTTPS و تنظیمات upload مناسب
- [ ] نصب پوسته \`conference-1405\` و افزونه \`conference-core\`
- [ ] ثبت پیوندهای یکتا و بررسی صفحات ساخته‌شده توسط افزونه

## فاز ۲ — محتوای واقعی و SEO
- [ ] جایگزینی عنوان، تاریخ، مکان، deadline، آمار و تصاویر نمونه از Customizer
- [ ] تکمیل صفحات درباره، FAQ، راهنمای نویسندگان، تماس، تیم، سخنرانان و اخبار
- [ ] ساخت منوهای اصلی و فوتر؛ بررسی تمام لینک‌ها
- [ ] تعیین title/description هر صفحه، sitemap و canonical از طریق SEO plugin
- [ ] schema مناسب رویداد با تاریخ، مکان، برگزارکننده و URL واقعی
- [ ] تصاویر بهینه با alt معنادار؛ حذف اطلاعات preview و لینک‌های ناموجود
- [ ] تنظیم noindex صفحات login/register/dashboard/profile/my-papers/certificates

## فاز ۳ — امنیت و گردش‌کار
- [ ] تنظیم Kavenegar API Key و VerifyLookup template فقط در wp-config.php
- [ ] تست ورود/ثبت‌نام OTP، انقضا، rate limit و محدودیت تلاش
- [ ] بررسی role capabilities؛ author نباید دسترسی media upload عمومی یا مدیریت کاربران داشته باشد
- [ ] تست ارسال PDF/DOC/DOCX سالم، فایل با پسوند جعلی، فایل بیش از ۲۰ MB و DOCX با ZIP expansion بالا
- [ ] تنظیم deny دسترسی مستقیم به private upload folder در Apache یا Nginx
- [ ] تست دانلود مقاله فقط توسط مالک یا مدیر مجاز
- [ ] بررسی و ایمن‌سازی ذخیره‌سازی فایل گواهی؛ Media Library پیش‌فرض عمومی است
- [ ] تست ثبت‌نام رایگان، بررسی دبیرخانه، پیام تماس و گواهی متعلق به کاربر
- [ ] حذف یا بازنویسی هرگونه داده نمونه و حساب آزمایشی

## فاز ۴ — کیفیت و انتشار
- [ ] اجرای GitHub Actions PHP lint و JS syntax checks
- [ ] تست دستی در Chrome/Firefox و موبایل/tablet
- [ ] تست دسترس‌پذیری keyboard، label، focus و خوانایی RTL
- [ ] بررسی Core Web Vitals، تصاویر، font loading و cache exclusion صفحات کاربری
- [ ] تنظیم backup دیتابیس/فایل و log monitoring
- [ ] تست restore از بکاپ
- [ ] تکمیل پذیرش staging و سپس انتشار به دامنه اصلی

## معیار انتشار
انتشار عمومی فقط پس از تأیید تست OTP واقعی، دسترسی فایل‌ها، نقش‌ها، فرم‌ها، SEO، backup/restore و رفتار responsive در staging.
