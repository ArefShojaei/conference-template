# WordPress package

Install `wordpress/themes/conference-1405` in `wp-content/themes/` and `wordpress/plugins/conference-core` in `wp-content/plugins/`. Activate both, save Permalinks, configure the Kavenegar VerifyLookup template in the plugin settings, then import demo content from Conference Core → Tools.

Shortcodes: `[conference_login]`, `[conference_register]`, `[conference_dashboard]`, `[conference_submit_paper]`, `[conference_papers]`.

Theme customizer controls the event details, three hero slide images/backgrounds, text, links and primary color. WordPress pages/posts and conference speakers/sessions are dynamic.

Paper upload accepts PDF, DOC and DOCX up to 20 MB and uses an authenticated download endpoint. On Nginx, deny direct access to `wp-content/uploads/conference-private`; `.htaccess` only protects Apache. Use HTTPS and set PHP upload_max_filesize/post_max_size to at least 20M (24M recommended). Real SMS delivery requires your Kavenegar API key and an approved VerifyLookup template. No payment or email-based registration is included.

## تنظیم امن کلید پیامک
در فایل `wp-config.php` و قبل از خط پایان ویرایش، این مقدار را با کلید واقعی خودت جایگزین کن (کلید واقعی را در GitHub یا گفتگو ارسال نکن):
```php
define('CONFERENCE_KAVENEGAR_API_KEY', 'PUT_YOUR_PRIVATE_API_KEY_HERE');
```
سپس نام قالب‌های تأییدشده VerifyLookup را در تنظیمات افزونه وارد کن: قالب OTP، قالب رسید ارسال مقاله، قالب نتیجه داوری. قالب نتیجه از `token` برای وضعیت و `token2` برای شناسه مقاله استفاده می‌کند. قالب ثبت‌نام شرکت‌کننده نیز از `token` برای وضعیت و `token2` برای شناسه ثبت‌نام استفاده می‌کند.

## تنظیم وب‌سرور و کش
برای Nginx داخل server block:
```nginx
location ^~ /wp-content/uploads/conference-private/ {
    deny all;
    return 403;
}
```
در افزونه کش، صفحات ورود، ثبت‌نام، داشبورد و ارسال مقاله و مسیرهای REST با پیشوند `/wp-json/conference/v1/` را از page cache خارج کن. همچنین برای DOCX باید افزونه PHP یعنی ZipArchive فعال باشد.

برای ثبت گواهی، از پیشخوان → گواهی‌ها یک مورد بسازید، نویسنده/کاربر دریافت‌کننده را تعیین کنید و آن را منتشر کنید. محتوای برگه گواهی می‌تواند شامل لینک فایل PDF باشد؛ اگر فایل نباید عمومی باشد، آن را در Media Library عمومی قرار ندهید و از فضای خصوصی هاست/سرویس دانلود کنترل‌شده استفاده کنید.

برای ورود مدیرانی که حساب وردپرسی قدیمی دارند و نام کاربری آن‌ها شماره موبایل نیست، مدیر سایت باید در پیشخوان → کاربران → ویرایش کاربر، فیلد «شماره موبایل» را تکمیل کند. سپس همان حساب نیز می‌تواند با OTP موبایل وارد شود.

## وارد کردن دیتای نمونه (فایل قابل Import)
در کنار قالب و افزونه، فایل آماده‌ی ورود اطلاعات در مسیر `wordpress/demo-content/conference-demo.xml` قرار دارد. این فایل یک خروجی استاندارد WordPress eXtended RSS (WXR) است و دیتابیس خام یا SQL نیست؛ روش استاندارد و امن انتقال محتوای وردپرس همین Import محتوایی است.

1. ابتدا قالب `conference-1405` و افزونه `conference-core` را نصب و فعال کن تا نوع‌محتواهای اختصاصی سخنران، جلسه و کمیته ثبت شوند.
2. از پیشخوان به **ابزارها ← درون‌ریزی** برو.
3. در ردیف **WordPress** روی «نصب درون‌ریز» و سپس «اجرای درون‌ریز» کلیک کن. (در بعضی نسخه‌ها WordPress Importer باید جداگانه نصب شود.)
4. فایل `conference-demo.xml` را از پوشه `wordpress/demo-content/` انتخاب و بارگذاری کن.
5. در مرحله انتساب نویسنده، محتواها را به مدیر فعلی سایت یا کاربر موردنظر نسبت بده. نیازی به ساخت کاربر یا ایمیل آزمایشی نیست.
6. گزینه دریافت/واردکردن فایل‌های پیوست را فعال نکن؛ این بسته برای محتوای متنی نمونه است و فایل مقاله یا تصویر ساختگی وارد نمی‌کند.

این فایل شامل **۳ نوشته نمونه، ۳ سخنران، ۴ جلسه برنامه و ۴ عضو کمیته** است. برگه‌های ورود، ثبت‌نام، داشبورد، ارسال مقاله، برنامه، سخنرانان، تماس، اخبار و سایر صفحات سیستمی هنگام فعال‌سازی افزونه ساخته می‌شوند و شورت‌کدهای لازم را دارند؛ به همین دلیل عمداً دوباره داخل XML قرار نگرفته‌اند تا صفحات تکراری ساخته نشود.

ورود اطلاعات را روی سایت آزمایشی یا پس از تهیه بکاپ انجام بده. اجرای دوباره Import ممکن است محتوای تکراری ایجاد کند؛ فایل WXR برای ورود اولیه طراحی شده است. داده‌ها نمونه‌اند و هیچ حساب کاربری آزمایشی، مقاله خصوصی، شماره موبایل یا پیامک واقعی ایجاد نمی‌کنند.


## فایل SQL نمونه و هدف افزونه

فایل **[conference-demo.sql](demo-content/conference-demo.sql)** محتوای نمونه را مستقیماً در جدول‌های محتوای وردپرس وارد می‌کند: ۵ سخنران، ۱۲ نشست زمان‌بندی‌شده، ۴ عضو کمیته، ۴ خبر و سه برگه محتوایی. قبل از ورود، پیشوند `wp_` را با مقدار `$table_prefix` در `wp-config.php` جایگزین کن. راهنمای کامل در [SQL-IMPORT.md](demo-content/SQL-IMPORT.md) است. این فایل دیتابیس کامل وردپرس نیست و کاربران یا اطلاعات محرمانه نمی‌سازد.

### نقش هر جزء
- **قالب Conference 1405:** فقط لایه نمایش و تجربه کاربری است؛ ساختار RTL، رنگ‌بندی، اسلایدر، صفحه‌ها، منوها، ابزارک‌ها و سفارشی‌سازی ظاهر.
- **افزونه Conference Core:** منطق سامانه است؛ ورود پیامکی، نقش‌ها و سطح دسترسی، ارسال و دانلود امن مقاله، ثبت‌نام شرکت‌کننده، تخصیص و داوری، اعلان‌ها، پیام‌های تماس، گواهی‌ها و نوع‌محتواهای سخنران/جلسه/کمیته. با غیرفعال کردن افزونه، گردش‌کارهای همایش عمداً از کار می‌افتند؛ چون نباید منطق کسب‌وکار داخل قالب قفل شود.
- **داده SQL:** محتوای نمونه برای پر کردن صفحات و نمایش برنامه واقعی‌نما است؛ جایگزین تنظیمات سرویس پیامک، حساب‌های کاربری واقعی یا پیکربندی هاست نیست.

### تنظیم زمان‌بندی
هر جلسه از پیشخوان ← برنامه همایش دارای فیلدهای روز، ساعت شروع/پایان، سالن و سخنران است. فهرست عمومی برنامه از همین فیلدها خوانده می‌شود و دیگر فقط یک عنوان و توضیح متنی نیست.


## بسته نصب هاست
راهنمای نصب مرحله‌به‌مرحله و چک‌لیست راه‌اندازی دامنه در [INSTALLATION-CHECKLIST.md](INSTALLATION-CHECKLIST.md) قرار دارد. Workflow با نام **WordPress install packages** پس از تغییرات مسیر `wordpress/` روی شاخه main یا با اجرای دستی، فایل‌های ZIP نصب‌پذیر قالب و افزونه را همراه SQL و راهنما به‌صورت artifact منتشر می‌کند. این بسته جایگزین پیکربندی و تست واقعی روی هاست مقصد نیست.
