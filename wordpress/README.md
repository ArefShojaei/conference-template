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
