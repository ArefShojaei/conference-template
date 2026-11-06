-- Conference 1405 demo content seed (WordPress posts and postmeta only).
-- Replace wp_ with the exact $table_prefix from wp-config.php before import.
-- Import only after activating the Conference Core plugin and Conference 1405 theme.
-- Idempotent: each record is inserted only when its post_type + post_name is absent.
SET NAMES utf8mb4;
START TRANSACTION;

-- Speakers
INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'تمرکز بر مدل‌های زبانی و یادگیری عمیق.','دکتر علی محمدی','استاد مهندسی کامپیوتر و پژوهشگر هوش مصنوعی.','publish','closed','closed','','speaker-ali-mohammadi','','',NOW(),UTC_TIMESTAMP(),'',0,'',1,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-ali-mohammadi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'هدایت پروژه‌های پژوهشی میان‌رشته‌ای.','دکتر مریم احمدی','پژوهشگر علم داده و تحلیل کلان‌داده.','publish','closed','closed','','speaker-maryam-ahmadi','','',NOW(),UTC_TIMESTAMP(),'',0,'',2,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-maryam-ahmadi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'سامانه‌های داده‌محور در مقیاس تولید.','مهندس نازنین پور','متخصص زیرساخت یادگیری ماشین.','publish','closed','closed','','speaker-nazanin-pour','','',NOW(),UTC_TIMESTAMP(),'',0,'',3,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-nazanin-pour');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'پژوهش اینترنت اشیا و سامانه‌های توزیع‌شده.','دکتر رضا نادری','عضو هیئت علمی حوزه شبکه و امنیت.','publish','closed','closed','','speaker-reza-naderi','','',NOW(),UTC_TIMESTAMP(),'',0,'',4,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-reza-naderi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'پردازش تصویر در کاربردهای سلامت دیجیتال.','دکتر سارا کریمی','پژوهشگر هوش مصنوعی پزشکی.','publish','closed','closed','','speaker-sara-karimi','','',NOW(),UTC_TIMESTAMP(),'',0,'',5,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-sara-karimi');

-- Committee members
INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'تدوین محورهای علمی و نظارت بر کیفیت برنامه علمی.','کمیته علمی همایش','ارزیابی و برنامه‌ریزی علمی.','publish','closed','closed','','committee-scientific','','',NOW(),UTC_TIMESTAMP(),'',0,'',1,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-scientific');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'برنامه‌ریزی اجرایی، هماهنگی سالن‌ها و پشتیبانی شرکت‌کنندگان.','کمیته اجرایی','مدیریت عملیات رویداد.','publish','closed','closed','','committee-executive','','',NOW(),UTC_TIMESTAMP(),'',0,'',2,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-executive');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'پایش کیفیت و بررسی مقاله‌ها در دبیرخانه.','کمیته بررسی مقالات','کنترل کیفیت آثار علمی.','publish','closed','closed','','committee-papers','','',NOW(),UTC_TIMESTAMP(),'',0,'',3,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'انتشار اطلاعیه‌ها و پاسخ‌گویی به شرکت‌کنندگان.','روابط عمومی و اطلاع‌رسانی','ارتباطات و اطلاع‌رسانی همایش.','publish','closed','closed','','committee-public-relations','','',NOW(),UTC_TIMESTAMP(),'',0,'',4,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-public-relations');

-- News posts
INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'پژوهشگران و دانشجویان می‌توانند آثار خود را در محورهای هوش مصنوعی، امنیت، اینترنت اشیا، سلامت دیجیتال و تحول فناوری ارسال کنند.','فراخوان ارسال مقاله همایش فناوری و نوآوری ۱۴۰۵','فراخوان ارسال آثار علمی در محورهای اعلام‌شده.','publish','closed','closed','','news-call-for-papers','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-call-for-papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'فرایند ثبت‌نام حضور در همایش از طریق پنل کاربری انجام می‌شود. برای ثبت درخواست، با شماره موبایل وارد حساب کاربری شوید.','ثبت‌نام شرکت‌کنندگان آغاز شد','ثبت درخواست حضور از پنل کاربری.','publish','closed','closed','','news-registration','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-registration');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'کارگاه‌های عملی یادگیری ماشین، MLOps و امنیت سامانه‌های هوشمند در برنامه سه‌روزه همایش پیش‌بینی شده‌اند.','کارگاه‌های تخصصی همایش اعلام شد','معرفی کارگاه‌های آموزشی همایش.','publish','closed','closed','','news-workshops','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-workshops');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'مقاله‌های دریافت‌شده پس از بررسی اولیه در دبیرخانه بررسی می‌شوند و نتیجه از طریق پنل کاربری و پیامک در صورت پیکربندی اعلام خواهد شد.','راهنمای فرایند بررسی مقاله‌ها منتشر شد','فرایند بررسی و اعلام نتیجه مقاله‌ها.','publish','closed','closed','','news-review','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-review');

-- Editable informational pages
INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'<h2>درباره همایش فناوری و نوآوری ۱۴۰۵</h2><p>این رویداد بستری برای ارائه پژوهش‌های کاربردی، تبادل تجربه میان دانشگاه و صنعت و شکل‌گیری همکاری‌های علمی است.</p><h3>اهداف رویداد</h3><ul><li>انتشار دستاوردهای علمی</li><li>تقویت ارتباط پژوهشگران و صنعت</li><li>معرفی فناوری‌های نوظهور</li></ul>','درباره همایش','معرفی رویداد، اهداف و محورهای علمی.','publish','closed','closed','','about','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='about');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'<h2>پرسش‌های متداول</h2><h3>چگونه در همایش ثبت‌نام کنم؟</h3><p>با شماره موبایل وارد حساب شوید و درخواست حضور را از صفحه ثبت‌نام همایش ثبت کنید.</p><h3>چگونه مقاله ارسال کنم؟</h3><p>پس از ورود، از بخش ارسال مقاله فایل PDF یا Word را بارگذاری کنید. سقف حجم فایل ۲۰ مگابایت است.</p>','سوالات متداول','پاسخ پرسش‌های متداول شرکت‌کنندگان.','publish','closed','closed','','faq','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='faq');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 1,NOW(),UTC_TIMESTAMP(),'<h2>راهنمای ارسال مقاله</h2><ol><li>عنوان مقاله و مشخصات نویسندگان را کامل وارد کنید.</li><li>فایل نهایی را با فرمت PDF، DOC یا DOCX آماده کنید.</li><li>حجم فایل نباید از ۲۰ مگابایت بیشتر باشد.</li><li>از ارسال اطلاعات شخصی غیرضروری خودداری کنید.</li></ol>','راهنمای نویسندگان','راهنمای ثبت و ارسال مقاله.','publish','closed','closed','','author-guidelines','','',NOW(),UTC_TIMESTAMP(),'',0,'',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='author-guidelines');

COMMIT;
