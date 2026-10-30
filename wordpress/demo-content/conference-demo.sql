-- Conference 1405 portable demo seed for WordPress
-- IMPORTANT: replace every "wp_" prefix below with the actual $table_prefix from wp-config.php.
-- Run only AFTER WordPress, the Conference 1405 theme and Conference Core plugin are installed/activated.
-- Safe to re-run: records are matched by post_type + post_name; metadata is inserted only when missing.
SET NAMES utf8mb4;
START TRANSACTION;

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'دکتر علی محمدی','speaker-ali-mohammadi','دکتر علی محمدی','publish','closed','closed','','استاد مهندسی کامپیوتر و پژوهشگر هوش مصنوعی؛ تمرکز بر مدل‌های زبانی و یادگیری عمیق.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='استاد مهندسی کامپیوتر و پژوهشگر هوش مصنوعی؛ تمرکز بر مدل‌های زبانی و یادگیری عمیق.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'دکتر مریم احمدی','speaker-maryam-ahmadi','دکتر مریم احمدی','publish','closed','closed','','پژوهشگر علم داده و تحلیل کلان‌داده با سابقه هدایت پروژه‌های پژوهشی میان‌رشته‌ای.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='پژوهشگر علم داده و تحلیل کلان‌داده با سابقه هدایت پروژه‌های پژوهشی میان‌رشته‌ای.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'مهندس نازنین پور','speaker-nazanin-pour','مهندس نازنین پور','publish','closed','closed','','متخصص زیرساخت یادگیری ماشین و مهندسی سامانه‌های داده‌محور در مقیاس تولید.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='متخصص زیرساخت یادگیری ماشین و مهندسی سامانه‌های داده‌محور در مقیاس تولید.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'دکتر رضا نادری','speaker-reza-naderi','دکتر رضا نادری','publish','closed','closed','','عضو هیئت علمی حوزه شبکه و امنیت؛ پژوهشگر اینترنت اشیا و سامانه‌های توزیع‌شده.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='عضو هیئت علمی حوزه شبکه و امنیت؛ پژوهشگر اینترنت اشیا و سامانه‌های توزیع‌شده.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'دکتر سارا کریمی','speaker-sara-karimi','دکتر سارا کریمی','publish','closed','closed','','پژوهشگر هوش مصنوعی پزشکی و پردازش تصویر در کاربردهای سلامت دیجیتال.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='پژوهشگر هوش مصنوعی پزشکی و پردازش تصویر در کاربردهای سلامت دیجیتال.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'تحویل کارت ورود، دریافت بسته همایش و پذیرایی صبحگاهی.','پذیرش و ثبت‌نام شرکت‌کنندگان','تحویل کارت ورود، دریافت بسته همایش و پذیرایی صبحگاهی.','publish','closed','closed','','day1-0830','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-0830');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'خوشامدگویی دبیر همایش و تشریح برنامه سه روزه.','مراسم افتتاحیه همایش','خوشامدگویی دبیر همایش و تشریح برنامه سه روزه.','publish','closed','closed','','day1-0930','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-0930');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'روندهای مدل‌های زبانی، کاربردهای سازمانی و چالش‌های اعتمادپذیری.','سخنرانی کلیدی: آینده هوش مصنوعی مولد','روندهای مدل‌های زبانی، کاربردهای سازمانی و چالش‌های اعتمادپذیری.','publish','closed','closed','','day1-1030','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1030');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'فرصت گفت‌وگو با سخنرانان و پژوهشگران.','ناهار و شبکه‌سازی','فرصت گفت‌وگو با سخنرانان و پژوهشگران.','publish','closed','closed','','day1-1200','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1200');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'ارائه مقالات منتخب در حوزه یادگیری ماشین، داده‌کاوی و تحلیل کلان‌داده.','ارائه مقالات: هوش مصنوعی و داده','ارائه مقالات منتخب در حوزه یادگیری ماشین، داده‌کاوی و تحلیل کلان‌داده.','publish','closed','closed','','day1-1330','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1330');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'از توسعه مدل تا استقرار، پایش و نگهداری در محیط عملیاتی.','کارگاه عملی MLOps','از توسعه مدل تا استقرار، پایش و نگهداری در محیط عملیاتی.','publish','closed','closed','','day1-1600','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1600');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'مروری بر الگوریتم‌ها، کاربردها و پیامدهای امنیتی محاسبات کوانتومی.','سخنرانی کلیدی: محاسبات کوانتومی','مروری بر الگوریتم‌ها، کاربردها و پیامدهای امنیتی محاسبات کوانتومی.','publish','closed','closed','','day2-0900','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-0900');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'معماری امن سامانه‌های متصل و مدیریت ریسک در زیرساخت‌های هوشمند.','نشست تخصصی اینترنت اشیا و امنیت','معماری امن سامانه‌های متصل و مدیریت ریسک در زیرساخت‌های هوشمند.','publish','closed','closed','','day2-1045','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-1045');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'تجربه‌های پیاده‌سازی هوش مصنوعی و تحول دیجیتال در سازمان‌ها.','پنل تحول دیجیتال در صنعت','تجربه‌های پیاده‌سازی هوش مصنوعی و تحول دیجیتال در سازمان‌ها.','publish','closed','closed','','day2-1400','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-1400');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'معرفی دستاوردهای پژوهشی و نمونه‌های اولیه تیم‌های نوآور.','نمایشگاه پوستر و محصولات نوآورانه','معرفی دستاوردهای پژوهشی و نمونه‌های اولیه تیم‌های نوآور.','publish','closed','closed','','day2-1615','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-1615');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'کاربرد یادگیری عمیق در تصویربرداری، تشخیص و پشتیبانی تصمیم بالینی.','سخنرانی کلیدی: هوش مصنوعی در پزشکی','کاربرد یادگیری عمیق در تصویربرداری، تشخیص و پشتیبانی تصمیم بالینی.','publish','closed','closed','','day3-0900','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day3-0900');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'جمع‌بندی رویداد، تقدیر از مقالات برتر و اعلام مسیر همکاری‌های آینده.','اختتامیه و معرفی آثار برتر','جمع‌بندی رویداد، تقدیر از مقالات برتر و اعلام مسیر همکاری‌های آینده.','publish','closed','closed','','day3-1100','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day3-1100');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'کمیته علمی همایش','committee-scientific','کمیته علمی همایش','publish','closed','closed','','تدوین محورهای علمی، ارزیابی مقاله‌ها و نظارت بر کیفیت برنامه علمی.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='تدوین محورهای علمی، ارزیابی مقاله‌ها و نظارت بر کیفیت برنامه علمی.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'کمیته اجرایی','committee-executive','کمیته اجرایی','publish','closed','closed','','برنامه‌ریزی اجرایی، هماهنگی سالن‌ها و پشتیبانی شرکت‌کنندگان.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='برنامه‌ریزی اجرایی، هماهنگی سالن‌ها و پشتیبانی شرکت‌کنندگان.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'کمیته داوری','committee-review','کمیته داوری','publish','closed','closed','','تخصیص مقاله‌ها به داوران، پایش تعارض منافع و کنترل کیفیت داوری.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='تخصیص مقاله‌ها به داوران، پایش تعارض منافع و کنترل کیفیت داوری.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'روابط عمومی و اطلاع‌رسانی','committee-public-relations','روابط عمومی و اطلاع‌رسانی','publish','closed','closed','','انتشار اطلاعیه‌ها، ارتباط با رسانه‌ها و پاسخ‌گویی به شرکت‌کنندگان.','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='انتشار اطلاعیه‌ها، ارتباط با رسانه‌ها و پاسخ‌گویی به شرکت‌کنندگان.');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'پژوهشگران و دانشجویان می‌توانند آثار علمی خود را در محورهای هوش مصنوعی، امنیت، اینترنت اشیا، سلامت دیجیتال و تحول فناوری ارسال کنند.','فراخوان ارسال مقاله همایش فناوری و نوآوری ۱۴۰۵','پژوهشگران و دانشجویان می‌توانند آثار علمی خود را در محورهای هوش مصنوعی، امنیت، اینترنت اشیا، سلامت دیجیتال و تحول فناوری ارسال کنند.','publish','closed','closed','','news-call-for-papers','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-call-for-papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'فرایند ثبت‌نام حضور در همایش از طریق پنل کاربری انجام می‌شود. برای ثبت درخواست، با شماره موبایل وارد حساب کاربری شوید.','ثبت‌نام شرکت‌کنندگان آغاز شد','فرایند ثبت‌نام حضور در همایش از طریق پنل کاربری انجام می‌شود. برای ثبت درخواست، با شماره موبایل وارد حساب کاربری شوید.','publish','closed','closed','','news-registration','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-registration');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'کارگاه‌های عملی یادگیری ماشین، MLOps و امنیت سامانه‌های هوشمند در برنامه سه‌روزه همایش پیش‌بینی شده‌اند.','کارگاه‌های تخصصی همایش اعلام شد','کارگاه‌های عملی یادگیری ماشین، MLOps و امنیت سامانه‌های هوشمند در برنامه سه‌روزه همایش پیش‌بینی شده‌اند.','publish','closed','closed','','news-workshops','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-workshops');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'مقاله‌های دریافت‌شده پس از بررسی اولیه به داوران تخصصی تخصیص داده می‌شوند و نتیجه از طریق پنل کاربری و پیامک اطلاع‌رسانی خواهد شد.','راهنمای فرایند داوری مقاله‌ها منتشر شد','مقاله‌های دریافت‌شده پس از بررسی اولیه به داوران تخصصی تخصیص داده می‌شوند و نتیجه از طریق پنل کاربری و پیامک اطلاع‌رسانی خواهد شد.','publish','closed','closed','','news-review','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-review');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'<h2>درباره همایش فناوری و نوآوری ۱۴۰۵</h2><p>این رویداد بستری برای ارائه پژوهش‌های کاربردی، تبادل تجربه میان دانشگاه و صنعت و شکل‌گیری همکاری‌های علمی است. برنامه همایش در سه روز و با نشست‌های تخصصی، سخنرانی‌های کلیدی و کارگاه‌های آموزشی برگزار می‌شود.</p><h3>اهداف رویداد</h3><ul><li>انتشار و به‌اشتراک‌گذاری دستاوردهای علمی</li><li>تقویت ارتباط میان پژوهشگران و صنعت</li><li>معرفی راهکارهای نوآورانه در فناوری‌های نوظهور</li></ul>','درباره همایش','درباره همایش','publish','closed','closed','','about','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='about');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'<h2>پرسش‌های متداول</h2><h3>چگونه در همایش ثبت‌نام کنم؟</h3><p>با شماره موبایل وارد حساب کاربری شوید و درخواست حضور را از صفحه ثبت‌نام همایش ثبت کنید.</p><h3>چگونه مقاله ارسال کنم؟</h3><p>پس از ورود، از بخش ارسال مقاله فایل PDF یا Word خود را بارگذاری کنید. سقف حجم فایل ۲۰ مگابایت است.</p><h3>نتیجه داوری از کجا اعلام می‌شود؟</h3><p>وضعیت مقاله در پنل کاربری نمایش داده می‌شود و در صورت پیکربندی سرویس پیامک، اطلاع‌رسانی پیامکی نیز انجام می‌شود.</p>','سوالات متداول','سوالات متداول','publish','closed','closed','','faq','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='faq');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'<h2>راهنمای ارسال مقاله</h2><ol><li>عنوان مقاله و مشخصات نویسندگان را کامل وارد کنید.</li><li>فایل نهایی را با فرمت PDF، DOC یا DOCX آماده کنید.</li><li>حجم فایل نباید از ۲۰ مگابایت بیشتر باشد.</li><li>از ارسال نسخه‌ای که اطلاعات محرمانه یا اطلاعات شخصی غیرضروری دارد خودداری کنید.</li><li>پس از ارسال، شناسه مقاله را برای پیگیری نگه دارید.</li></ol><p>قالب‌بندی نهایی و محورهای علمی باید مطابق آخرین اطلاعیه دبیرخانه باشد.</p>','راهنمای نویسندگان','راهنمای نویسندگان','publish','closed','closed','','author-guidelines','','',NOW(),UTC_TIMESTAMP(),' ',0,'',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='author-guidelines');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_speaker_role','استاد دانشگاه | هوش مصنوعی' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-ali-mohammadi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_speaker_role','پژوهشگر ارشد | علم داده' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-maryam-ahmadi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_speaker_role','معمار راهکار | MLOps' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-nazanin-pour'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_speaker_role','عضو هیئت علمی | امنیت' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-reza-naderi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_speaker_role','پژوهشگر | سلامت دیجیتال' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-sara-karimi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','08:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','09:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','لابی اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','کمیته اجرایی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','09:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','دبیر همایش' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','12:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','دکتر علی محمدی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','12:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','13:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن پذیرایی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','13:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','15:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن A1' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','دکتر مریم احمدی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','16:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','18:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','کارگاه شماره ۱' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','مهندس نازنین پور' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','09:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','پروفسور ماریا اوانس' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','10:45' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','12:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن B1' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','دکتر رضا نادری' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','14:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','16:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','پنل مدیران فناوری' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','16:15' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','18:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن نمایشگاه' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز سوم — ۱۷ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','09:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','دکتر سارا کریمی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_day','روز سوم — ۱۷ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_start','11:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_end','12:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_session_speaker','دبیر علمی همایش' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_committee_role','کمیته علمی' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-scientific'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_committee_role','کمیته اجرایی' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-executive'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_committee_role','کمیته داوری' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-review'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT ID,'_conf_committee_role','روابط عمومی' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-public-relations'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

COMMIT;
