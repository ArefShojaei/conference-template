-- Conference 1405: idempotent sample seed for a fresh WordPress install
-- Replace ALL wp_ prefixes with the real $table_prefix from wp-config.php.
-- Install WordPress, activate Conference Core and Conference 1405, then import this file.
-- No users, passwords, phone numbers, private papers, API keys or live credentials are created.
SET NAMES utf8mb4;
START TRANSACTION;

-- Public accepted-paper examples. They intentionally have no attached private file or demo user.
INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'این پژوهش روشی ترکیبی برای بهبود دقت مدل‌های یادگیری عمیق در تحلیل تصاویر پزشکی ارائه می‌کند و عملکرد مدل را روی مجموعه داده ارزیابی می‌کند.','بهبود دقت مدل‌های یادگیری عمیق در تشخیص بیماری','این پژوهش روشی ترکیبی برای بهبود دقت مدل‌های یادگیری عمیق در تحلیل تصاویر پزشکی ارائه می‌کند و عملکرد مدل را روی مجموعه داده ارزیابی می‌کند.','publish','closed','closed','','demo-paper-deep-learning','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_paper:demo-paper-deep-learning',0,'conf_paper','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_paper' AND post_name='demo-paper-deep-learning');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_abstract','این پژوهش روشی ترکیبی برای بهبود دقت مدل‌های یادگیری عمیق در تحلیل تصاویر پزشکی ارائه می‌کند و عملکرد مدل را روی مجموعه داده ارزیابی می‌کند.' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-deep-learning'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_abstract');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_keywords','یادگیری عمیق، تصویربرداری پزشکی، طبقه‌بندی' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-deep-learning'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_keywords');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_track','هوش مصنوعی و علم داده' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-deep-learning'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_track');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_demo_record','1' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-deep-learning'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_demo_record');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'این مقاله چارچوبی برای ارزیابی تهدیدها و بهبود کنترل دسترسی در زیرساخت‌های ابری توزیع‌شده بررسی می‌کند.','امنیت در سیستم‌های ابری توزیع‌شده','این مقاله چارچوبی برای ارزیابی تهدیدها و بهبود کنترل دسترسی در زیرساخت‌های ابری توزیع‌شده بررسی می‌کند.','publish','closed','closed','','demo-paper-cloud-security','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_paper:demo-paper-cloud-security',0,'conf_paper','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_paper' AND post_name='demo-paper-cloud-security');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_abstract','این مقاله چارچوبی برای ارزیابی تهدیدها و بهبود کنترل دسترسی در زیرساخت‌های ابری توزیع‌شده بررسی می‌کند.' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-cloud-security'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_abstract');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_keywords','رایانش ابری، امنیت، کنترل دسترسی' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-cloud-security'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_keywords');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_track','امنیت و شبکه' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-cloud-security'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_track');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_demo_record','1' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-cloud-security'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_demo_record');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT 0,NOW(),UTC_TIMESTAMP(),'این مطالعه معماری حسگرمحور برای پایش شرایط محیطی و بهینه‌سازی مصرف آب در سامانه‌های کشاورزی هوشمند معرفی می‌کند.','کاربرد اینترنت اشیا در کشاورزی هوشمند','این مطالعه معماری حسگرمحور برای پایش شرایط محیطی و بهینه‌سازی مصرف آب در سامانه‌های کشاورزی هوشمند معرفی می‌کند.','publish','closed','closed','','demo-paper-smart-agriculture','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_paper:demo-paper-smart-agriculture',0,'conf_paper','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_paper' AND post_name='demo-paper-smart-agriculture');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_abstract','این مطالعه معماری حسگرمحور برای پایش شرایط محیطی و بهینه‌سازی مصرف آب در سامانه‌های کشاورزی هوشمند معرفی می‌کند.' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-smart-agriculture'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_abstract');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_keywords','IoT، کشاورزی هوشمند، حسگر' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-smart-agriculture'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_keywords');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_paper_track','اینترنت اشیا' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-smart-agriculture'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_paper_track');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_demo_record','1' FROM wp_posts p WHERE p.post_type='conf_paper' AND p.post_name='demo-paper-smart-agriculture'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_demo_record');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'استاد مهندسی کامپیوتر و پژوهشگر هوش مصنوعی؛ تمرکز بر مدل‌های زبانی و یادگیری عمیق.','دکتر علی محمدی','استاد مهندسی کامپیوتر و پژوهشگر هوش مصنوعی؛ تمرکز بر مدل‌های زبانی و یادگیری عمیق.','publish','closed','closed','','speaker-ali-mohammadi','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_speaker:speaker-ali-mohammadi',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-ali-mohammadi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'پژوهشگر علم داده و تحلیل کلان‌داده با سابقه هدایت پروژه‌های پژوهشی میان‌رشته‌ای.','دکتر مریم احمدی','پژوهشگر علم داده و تحلیل کلان‌داده با سابقه هدایت پروژه‌های پژوهشی میان‌رشته‌ای.','publish','closed','closed','','speaker-maryam-ahmadi','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_speaker:speaker-maryam-ahmadi',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-maryam-ahmadi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'متخصص زیرساخت یادگیری ماشین و مهندسی سامانه‌های داده‌محور در مقیاس تولید.','مهندس نازنین پور','متخصص زیرساخت یادگیری ماشین و مهندسی سامانه‌های داده‌محور در مقیاس تولید.','publish','closed','closed','','speaker-nazanin-pour','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_speaker:speaker-nazanin-pour',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-nazanin-pour');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'عضو هیئت علمی حوزه شبکه و امنیت؛ پژوهشگر اینترنت اشیا و سامانه‌های توزیع‌شده.','دکتر رضا نادری','عضو هیئت علمی حوزه شبکه و امنیت؛ پژوهشگر اینترنت اشیا و سامانه‌های توزیع‌شده.','publish','closed','closed','','speaker-reza-naderi','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_speaker:speaker-reza-naderi',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-reza-naderi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'پژوهشگر هوش مصنوعی پزشکی و پردازش تصویر در کاربردهای سلامت دیجیتال.','دکتر سارا کریمی','پژوهشگر هوش مصنوعی پزشکی و پردازش تصویر در کاربردهای سلامت دیجیتال.','publish','closed','closed','','speaker-sara-karimi','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_speaker:speaker-sara-karimi',0,'conf_speaker','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_speaker' AND post_name='speaker-sara-karimi');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'تحویل کارت ورود، دریافت بسته همایش و پذیرایی صبحگاهی.','پذیرش و ثبت‌نام شرکت‌کنندگان','تحویل کارت ورود، دریافت بسته همایش و پذیرایی صبحگاهی.','publish','closed','closed','','day1-0830','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day1-0830',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-0830');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'خوشامدگویی دبیر همایش و تشریح برنامه سه روزه.','مراسم افتتاحیه همایش','خوشامدگویی دبیر همایش و تشریح برنامه سه روزه.','publish','closed','closed','','day1-0930','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day1-0930',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-0930');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'روندهای مدل‌های زبانی، کاربردهای سازمانی و چالش‌های اعتمادپذیری.','سخنرانی کلیدی: آینده هوش مصنوعی مولد','روندهای مدل‌های زبانی، کاربردهای سازمانی و چالش‌های اعتمادپذیری.','publish','closed','closed','','day1-1030','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day1-1030',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1030');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'فرصت گفت‌وگو با سخنرانان و پژوهشگران.','ناهار و شبکه‌سازی','فرصت گفت‌وگو با سخنرانان و پژوهشگران.','publish','closed','closed','','day1-1200','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day1-1200',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1200');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'ارائه مقالات منتخب در حوزه یادگیری ماشین، داده‌کاوی و تحلیل کلان‌داده.','ارائه مقالات: هوش مصنوعی و داده','ارائه مقالات منتخب در حوزه یادگیری ماشین، داده‌کاوی و تحلیل کلان‌داده.','publish','closed','closed','','day1-1330','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day1-1330',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1330');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'از توسعه مدل تا استقرار، پایش و نگهداری در محیط عملیاتی.','کارگاه عملی MLOps','از توسعه مدل تا استقرار، پایش و نگهداری در محیط عملیاتی.','publish','closed','closed','','day1-1600','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day1-1600',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day1-1600');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'مروری بر الگوریتم‌ها، کاربردها و پیامدهای امنیتی محاسبات کوانتومی.','سخنرانی کلیدی: محاسبات کوانتومی','مروری بر الگوریتم‌ها، کاربردها و پیامدهای امنیتی محاسبات کوانتومی.','publish','closed','closed','','day2-0900','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day2-0900',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-0900');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'معماری امن سامانه‌های متصل و مدیریت ریسک در زیرساخت‌های هوشمند.','نشست تخصصی اینترنت اشیا و امنیت','معماری امن سامانه‌های متصل و مدیریت ریسک در زیرساخت‌های هوشمند.','publish','closed','closed','','day2-1045','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day2-1045',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-1045');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'تجربه‌های پیاده‌سازی هوش مصنوعی و تحول دیجیتال در سازمان‌ها.','پنل تحول دیجیتال در صنعت','تجربه‌های پیاده‌سازی هوش مصنوعی و تحول دیجیتال در سازمان‌ها.','publish','closed','closed','','day2-1400','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day2-1400',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-1400');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'معرفی دستاوردهای پژوهشی و نمونه‌های اولیه تیم‌های نوآور.','نمایشگاه پوستر و محصولات نوآورانه','معرفی دستاوردهای پژوهشی و نمونه‌های اولیه تیم‌های نوآور.','publish','closed','closed','','day2-1615','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day2-1615',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day2-1615');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'کاربرد یادگیری عمیق در تصویربرداری، تشخیص و پشتیبانی تصمیم بالینی.','سخنرانی کلیدی: هوش مصنوعی در پزشکی','کاربرد یادگیری عمیق در تصویربرداری، تشخیص و پشتیبانی تصمیم بالینی.','publish','closed','closed','','day3-0900','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day3-0900',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day3-0900');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'جمع‌بندی رویداد، تقدیر از مقالات برتر و اعلام مسیر همکاری‌های آینده.','اختتامیه و معرفی آثار برتر','جمع‌بندی رویداد، تقدیر از مقالات برتر و اعلام مسیر همکاری‌های آینده.','publish','closed','closed','','day3-1100','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_session:day3-1100',0,'conf_session','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_session' AND post_name='day3-1100');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'تدوین محورهای علمی، ارزیابی مقاله‌ها و نظارت بر کیفیت برنامه علمی.','کمیته علمی همایش','تدوین محورهای علمی، ارزیابی مقاله‌ها و نظارت بر کیفیت برنامه علمی.','publish','closed','closed','','committee-scientific','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_committee:committee-scientific',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-scientific');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'برنامه‌ریزی اجرایی، هماهنگی سالن‌ها و پشتیبانی شرکت‌کنندگان.','کمیته اجرایی','برنامه‌ریزی اجرایی، هماهنگی سالن‌ها و پشتیبانی شرکت‌کنندگان.','publish','closed','closed','','committee-executive','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_committee:committee-executive',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-executive');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'تخصیص مقاله‌ها به داوران، پایش تعارض منافع و کنترل کیفیت داوری.','کمیته داوری','تخصیص مقاله‌ها به داوران، پایش تعارض منافع و کنترل کیفیت داوری.','publish','closed','closed','','committee-review','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_committee:committee-review',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-review');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'انتشار اطلاعیه‌ها، ارتباط با رسانه‌ها و پاسخ‌گویی به شرکت‌کنندگان.','روابط عمومی و اطلاع‌رسانی','انتشار اطلاعیه‌ها، ارتباط با رسانه‌ها و پاسخ‌گویی به شرکت‌کنندگان.','publish','closed','closed','','committee-public-relations','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:conf_committee:committee-public-relations',0,'conf_committee','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='conf_committee' AND post_name='committee-public-relations');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'پژوهشگران و دانشجویان می‌توانند آثار علمی خود را در محورهای هوش مصنوعی، امنیت، اینترنت اشیا، سلامت دیجیتال و تحول فناوری ارسال کنند.','فراخوان ارسال مقاله همایش فناوری و نوآوری ۱۴۰۵','پژوهشگران و دانشجویان می‌توانند آثار علمی خود را در محورهای هوش مصنوعی، امنیت، اینترنت اشیا، سلامت دیجیتال و تحول فناوری ارسال کنند.','publish','closed','closed','','news-call-for-papers','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:post:news-call-for-papers',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-call-for-papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'فرایند ثبت‌نام حضور در همایش از طریق پنل کاربری انجام می‌شود. برای ثبت درخواست، با شماره موبایل وارد حساب کاربری شوید.','ثبت‌نام شرکت‌کنندگان آغاز شد','فرایند ثبت‌نام حضور در همایش از طریق پنل کاربری انجام می‌شود. برای ثبت درخواست، با شماره موبایل وارد حساب کاربری شوید.','publish','closed','closed','','news-registration','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:post:news-registration',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-registration');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'کارگاه‌های عملی یادگیری ماشین، MLOps و امنیت سامانه‌های هوشمند در برنامه سه‌روزه همایش پیش‌بینی شده‌اند.','کارگاه‌های تخصصی همایش اعلام شد','کارگاه‌های عملی یادگیری ماشین، MLOps و امنیت سامانه‌های هوشمند در برنامه سه‌روزه همایش پیش‌بینی شده‌اند.','publish','closed','closed','','news-workshops','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:post:news-workshops',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-workshops');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'مقاله‌های دریافت‌شده پس از بررسی اولیه به داوران تخصصی تخصیص داده می‌شوند و نتیجه از طریق پنل کاربری و پیامک اطلاع‌رسانی خواهد شد.','راهنمای فرایند داوری مقاله‌ها منتشر شد','مقاله‌های دریافت‌شده پس از بررسی اولیه به داوران تخصصی تخصیص داده می‌شوند و نتیجه از طریق پنل کاربری و پیامک اطلاع‌رسانی خواهد شد.','publish','closed','closed','','news-review','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:post:news-review',0,'post','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='post' AND post_name='news-review');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'','صفحه اصلی','','publish','closed','closed','','home','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:home',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='home');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_login]','ورود','[conference_login]','publish','closed','closed','','login','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:login',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='login');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_register]','ثبت‌نام','[conference_register]','publish','closed','closed','','register','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:register',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='register');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_dashboard]','داشبورد کاربری','[conference_dashboard]','publish','closed','closed','','dashboard','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:dashboard',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='dashboard');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_submit_paper]','ارسال مقاله','[conference_submit_paper]','publish','closed','closed','','submit-paper','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:submit-paper',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='submit-paper');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_papers]','مقالات پذیرفته‌شده','[conference_papers]','publish','closed','closed','','papers','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:papers',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'<h2>درباره همایش فناوری و نوآوری</h2><p>این رویداد بستری برای ارائه پژوهش‌های نو، تبادل تجربه میان دانشگاه و صنعت و توسعه همکاری‌های علمی است.</p>','درباره همایش',' درباره همایش فناوری و نوآوری  این رویداد بستری برای ارائه پژوهش‌های نو، تبادل تجربه میان دانشگاه و صنعت و توسعه همکاری‌های علمی است. ','publish','closed','closed','','about','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:about',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='about');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_contact]','تماس با ما','[conference_contact]','publish','closed','closed','','contact','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:contact',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='contact');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'<h2>سوالات متداول</h2><h3>چگونه ثبت‌نام کنم؟</h3><p>با شماره موبایل وارد شوید و درخواست حضور را ثبت کنید.</p>','سوالات متداول',' سوالات متداول  چگونه ثبت‌نام کنم؟  با شماره موبایل وارد شوید و درخواست حضور را ثبت کنید. ','publish','closed','closed','','faq','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:faq',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='faq');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_speakers]','سخنرانان','[conference_speakers]','publish','closed','closed','','speakers','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:speakers',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='speakers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_schedule]','برنامه همایش','[conference_schedule]','publish','closed','closed','','schedule','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:schedule',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='schedule');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_team]','تیم و کمیته‌ها','[conference_team]','publish','closed','closed','','team','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:team',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='team');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_news]','اخبار و اطلاعیه‌ها','[conference_news]','publish','closed','closed','','news','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:news',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='news');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_news]','اخبار و نوشته‌ها','[conference_news]','publish','closed','closed','','posts','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:posts',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='posts');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_event_registration]','ثبت‌نام در همایش','[conference_event_registration]','publish','closed','closed','','event-registration','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:event-registration',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='event-registration');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_my_papers]','مقالات من','[conference_my_papers]','publish','closed','closed','','my-papers','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:my-papers',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='my-papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_event_registration]','ثبت‌نام من','[conference_event_registration]','publish','closed','closed','','my-registration','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:my-registration',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='my-registration');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_certificates]','گواهی‌های من','[conference_certificates]','publish','closed','closed','','certificates','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:certificates',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='certificates');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_messages]','پیام‌ها و اعلان‌ها','[conference_messages]','publish','closed','closed','','messages','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:messages',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='messages');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_profile]','پروفایل من','[conference_profile]','publish','closed','closed','','profile','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:profile',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='profile');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_reviewer_dashboard]','پنل داوری','[conference_reviewer_dashboard]','publish','closed','closed','','reviewer-dashboard','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:reviewer-dashboard',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='reviewer-dashboard');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_review_queue]','صف داوری','[conference_review_queue]','publish','closed','closed','','review-queue','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:review-queue',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='review-queue');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_review_paper]','داوری مقاله','[conference_review_paper]','publish','closed','closed','','review-paper','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:review-paper',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='review-paper');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_my_reviews]','داوری‌های من','[conference_my_reviews]','publish','closed','closed','','my-reviews','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:my-reviews',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='my-reviews');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'<h2>راهنمای ارسال مقاله</h2><ol><li>عنوان و مشخصات نویسندگان را کامل وارد کنید.</li><li>فایل PDF، DOC یا DOCX با حجم حداکثر ۲۰ مگابایت ارسال کنید.</li><li>پس از ارسال، شناسه مقاله را برای پیگیری نگه دارید.</li></ol>','راهنمای نویسندگان',' راهنمای ارسال مقاله   عنوان و مشخصات نویسندگان را کامل وارد کنید.  فایل PDF، DOC یا DOCX با حجم حداکثر ۲۰ مگابایت ارسال کنید.  پس از ارسال، شناسه مقاله را برای پیگیری نگه دارید.  ','publish','closed','closed','','author-guidelines','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:author-guidelines',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='author-guidelines');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="dashboard"]','مرکز مدیریت','[conference_admin_workspace section="dashboard"]','publish','closed','closed','','admin-dashboard','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-dashboard',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-dashboard');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="users"]','مدیریت کاربران','[conference_admin_workspace section="users"]','publish','closed','closed','','admin-users','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-users',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-users');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="papers"]','مدیریت مقالات','[conference_admin_workspace section="papers"]','publish','closed','closed','','admin-papers','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-papers',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-papers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="registrations"]','مدیریت ثبت‌نام‌ها','[conference_admin_workspace section="registrations"]','publish','closed','closed','','admin-registrations','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-registrations',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-registrations');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="reviews"]','مدیریت داوری‌ها','[conference_admin_workspace section="reviews"]','publish','closed','closed','','admin-reviews','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-reviews',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-reviews');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="reviewers"]','مدیریت داوران','[conference_admin_workspace section="reviewers"]','publish','closed','closed','','admin-reviewers','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-reviewers',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-reviewers');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="settings"]','تنظیمات همایش','[conference_admin_workspace section="settings"]','publish','closed','closed','','admin-settings','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-settings',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-settings');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="sms"]','تنظیمات پیامک','[conference_admin_workspace section="sms"]','publish','closed','closed','','admin-sms','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-sms',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-sms');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="team"]','مدیریت تیم و کمیته‌ها','[conference_admin_workspace section="team"]','publish','closed','closed','','admin-team','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-team',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-team');

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),'[conference_admin_workspace section="posts"]','مدیریت نوشته‌ها','[conference_admin_workspace section="posts"]','publish','closed','closed','','admin-posts','','',NOW(),UTC_TIMESTAMP(),' ',0,'urn:conference-demo:page:admin-posts',0,'page','',0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type='page' AND post_name='admin-posts');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_speaker_role','استاد دانشگاه | هوش مصنوعی' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-ali-mohammadi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_speaker_role','پژوهشگر ارشد | علم داده' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-maryam-ahmadi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_speaker_role','معمار راهکار | MLOps' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-nazanin-pour'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_speaker_role','عضو هیئت علمی | امنیت' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-reza-naderi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_speaker_role','پژوهشگر | سلامت دیجیتال' FROM wp_posts p WHERE p.post_type='conf_speaker' AND p.post_name='speaker-sara-karimi'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_speaker_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','08:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','09:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','لابی اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','کمیته اجرایی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0830'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','09:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','دبیر همایش' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-0930'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','12:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','دکتر علی محمدی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1030'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','12:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','13:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن پذیرایی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1200'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','13:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','15:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن A1' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','دکتر مریم احمدی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1330'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز اول — ۱۵ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','16:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','18:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','کارگاه شماره ۱' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','مهندس نازنین پور' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day1-1600'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','09:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','پروفسور ماریا اوانس' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','10:45' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','12:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن B1' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','دکتر رضا نادری' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1045'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','14:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','16:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','پنل مدیران فناوری' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1400'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز دوم — ۱۶ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','16:15' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','18:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن نمایشگاه' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day2-1615'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز سوم — ۱۷ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','09:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','10:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','دکتر سارا کریمی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-0900'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_day','روز سوم — ۱۷ آذر ۱۴۰۵' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_day');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_start','11:00' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_start');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_end','12:30' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_end');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_room','سالن اصلی' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_room');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_session_speaker','دبیر علمی همایش' FROM wp_posts p WHERE p.post_type='conf_session' AND p.post_name='day3-1100'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_session_speaker');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_committee_role','کمیته علمی' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-scientific'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_committee_role','کمیته اجرایی' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-executive'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_committee_role','کمیته داوری' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-review'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT p.ID,'_conf_committee_role','روابط عمومی' FROM wp_posts p WHERE p.post_type='conf_committee' AND p.post_name='committee-public-relations'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=p.ID AND m.meta_key='_conf_committee_role');

-- Create the primary demo navigation menu and attach existing page records.
INSERT INTO wp_terms (name,slug,term_group)
SELECT 'منوی اصلی همایش','conference-main-menu',0
WHERE NOT EXISTS (SELECT 1 FROM wp_terms t JOIN wp_term_taxonomy tt ON tt.term_id=t.term_id WHERE tt.taxonomy='nav_menu' AND t.name='منوی اصلی همایش');
SET @conf_menu_term_id=(SELECT t.term_id FROM wp_terms t JOIN wp_term_taxonomy tt ON tt.term_id=t.term_id WHERE tt.taxonomy='nav_menu' AND t.name='منوی اصلی همایش' ORDER BY t.term_id ASC LIMIT 1);
INSERT INTO wp_term_taxonomy (term_id,taxonomy,description,parent,count)
SELECT @conf_menu_term_id,'nav_menu','منوی اصلی همایش',0,0
WHERE NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id=@conf_menu_term_id AND taxonomy='nav_menu');
SET @conf_menu_taxonomy_id=(SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id=@conf_menu_term_id AND taxonomy='nav_menu' LIMIT 1);

INSERT INTO wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
SELECT COALESCE((SELECT ID FROM wp_users WHERE user_status=0 ORDER BY ID ASC LIMIT 1),1),NOW(),UTC_TIMESTAMP(),' ',p.post_title,'', 'publish','closed','closed','',CONCAT('conference-page-menu-item-',p.ID),'','',NOW(),UTC_TIMESTAMP(),' ',0,CONCAT('urn:conference-menu-item:',p.ID),
CASE p.post_name WHEN 'about' THEN 1 WHEN 'speakers' THEN 2 WHEN 'team' THEN 3 WHEN 'schedule' THEN 4 WHEN 'papers' THEN 5 WHEN 'news' THEN 6 WHEN 'event-registration' THEN 7 WHEN 'author-guidelines' THEN 8 WHEN 'faq' THEN 9 WHEN 'contact' THEN 10 ELSE 99 END,
'nav_menu_item','',0
FROM wp_posts p
WHERE p.post_type='page' AND p.post_name IN ('about','speakers','team','schedule','papers','news','event-registration','author-guidelines','faq','contact')
AND NOT EXISTS (SELECT 1 FROM wp_posts mi JOIN wp_postmeta m ON m.post_id=mi.ID AND m.meta_key='_menu_item_object_id' AND m.meta_value=CAST(p.ID AS CHAR) WHERE mi.post_type='nav_menu_item');

INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_type','post_type' FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_type');
INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_object','page' FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_object');
INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_object_id',p.ID FROM wp_posts mi JOIN wp_posts p ON mi.post_name=CONCAT('conference-page-menu-item-',p.ID)
WHERE mi.post_type='nav_menu_item' AND p.post_type='page'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_object_id');
INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_menu_item_parent','0' FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_menu_item_parent');
INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_classes','a:1:{i:0;s:0:"";}' FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_classes');
INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_xfn','' FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_xfn');
INSERT INTO wp_postmeta (post_id,meta_key,meta_value)
SELECT mi.ID,'_menu_item_url','' FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_postmeta m WHERE m.post_id=mi.ID AND m.meta_key='_menu_item_url');

INSERT INTO wp_term_relationships (object_id,term_taxonomy_id,term_order)
SELECT mi.ID,@conf_menu_taxonomy_id,mi.menu_order FROM wp_posts mi
WHERE mi.post_type='nav_menu_item' AND mi.post_name LIKE 'conference-page-menu-item-%'
AND NOT EXISTS (SELECT 1 FROM wp_term_relationships tr WHERE tr.object_id=mi.ID AND tr.term_taxonomy_id=@conf_menu_taxonomy_id);
UPDATE wp_term_taxonomy SET count=(SELECT COUNT(*) FROM wp_term_relationships WHERE term_taxonomy_id=@conf_menu_taxonomy_id) WHERE term_taxonomy_id=@conf_menu_taxonomy_id;

-- Create a category for sample announcements and attach the four demo news posts.
INSERT INTO wp_terms (name,slug,term_group)
SELECT 'اخبار همایش','conference-news',0
WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug='conference-news');
SET @conf_news_term_id=(SELECT term_id FROM wp_terms WHERE slug='conference-news' LIMIT 1);
INSERT INTO wp_term_taxonomy (term_id,taxonomy,description,parent,count)
SELECT @conf_news_term_id,'category','اطلاعیه‌های نمونه همایش',0,0
WHERE NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id=@conf_news_term_id AND taxonomy='category');
SET @conf_news_taxonomy_id=(SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id=@conf_news_term_id AND taxonomy='category' LIMIT 1);
INSERT INTO wp_term_relationships (object_id,term_taxonomy_id,term_order)
SELECT p.ID,@conf_news_taxonomy_id,0 FROM wp_posts p
WHERE p.post_type='post' AND p.post_name IN ('news-call-for-papers','news-registration','news-workshops','news-review')
AND NOT EXISTS (SELECT 1 FROM wp_term_relationships tr WHERE tr.object_id=p.ID AND tr.term_taxonomy_id=@conf_news_taxonomy_id);
UPDATE wp_term_taxonomy SET count=(SELECT COUNT(*) FROM wp_term_relationships WHERE term_taxonomy_id=@conf_news_taxonomy_id) WHERE term_taxonomy_id=@conf_news_taxonomy_id;

-- Default theme customizer values and menu locations; never overwrite existing custom settings.
INSERT INTO wp_options (option_name,option_value,autoload)
SELECT 'theme_mods_conference-1405',CONCAT('a:74:{s:18:"nav_menu_locations";a:2:{s:7:"primary";i:',@conf_menu_term_id,';s:6:"footer";i:',@conf_menu_term_id,';}', 's:19:"conf1405_event_name";s:70:"همایش بین‌المللی فناوری و نوآوری ۱۴۰۵";s:19:"conf1405_event_date";s:30:"۱۵ تا ۱۷ آذر ۱۴۰۵";s:23:"conf1405_event_location";s:63:"تهران، مرکز همایش‌های بین‌المللی";s:23:"conf1405_event_deadline";s:20:"۳۰ مهر ۱۴۰۵";s:26:"conf1405_event_description";s:133:"رویدادی برای ارائه پژوهش‌های تازه، تبادل تجربه و توسعه همکاری‌های علمی.";s:16:"conf1405_primary";s:7:"#123d38";s:14:"conf1405_phone";s:23:"۰۲۱-۱۲۳۴۵۶۷۸";s:14:"conf1405_email";s:16:"info@example.com";s:16:"conf1405_address";s:63:"تهران، مرکز همایش‌های بین‌المللی";s:22:"conf1405_metric1_value";s:2:"03";s:22:"conf1405_metric1_label";s:35:"روز تجربه و یادگیری";s:22:"conf1405_metric2_value";s:5:"۱۲+";s:22:"conf1405_metric2_label";s:23:"کارگاه تخصصی";s:22:"conf1405_metric3_value";s:5:"۴۵+";s:22:"conf1405_metric3_label";s:26:"سخنران و متخصص";s:22:"conf1405_metric4_value";s:9:"۱۲۰۰+";s:22:"conf1405_metric4_label";s:21:"شرکت‌کننده";s:21:"conf1405_slide1_title";s:57:"ایده‌های بزرگ، آینده‌های روشن";s:24:"conf1405_slide1_subtitle";s:80:"پژوهش خود را با جامعه علمی به اشتراک بگذارید";s:20:"conf1405_slide1_link";s:14:"/submit-paper/";s:21:"conf1405_slide2_title";s:37:"دانش، تجربه و همکاری";s:24:"conf1405_slide2_subtitle";s:83:"با پژوهشگران و متخصصان حوزه فناوری همراه شوید";s:20:"conf1405_slide2_link";s:14:"/submit-paper/";s:21:"conf1405_slide3_title";s:37:"از پژوهش تا اثرگذاری";s:24:"conf1405_slide3_subtitle";s:85:"در نشست‌ها و کارگاه‌های تخصصی همایش شرکت کنید";s:20:"conf1405_slide3_link";s:14:"/submit-paper/";s:22:"conf1405_feature1_icon";s:4:"📝";s:23:"conf1405_feature1_title";s:35:"ارسال و داوری مقاله";s:22:"conf1405_feature1_text";s:99:"سامانه ارسال مقاله و پیگیری وضعیت داوری به صورت آنلاین";s:22:"conf1405_feature2_icon";s:4:"🎤";s:23:"conf1405_feature2_title";s:29:"سخنرانان برجسته";s:22:"conf1405_feature2_text";s:86:"حضور استادان و متخصصان برجسته در حوزه‌های علمی";s:22:"conf1405_feature3_icon";s:4:"🤝";s:23:"conf1405_feature3_title";s:35:"شبکه‌سازی حرفه‌ای";s:22:"conf1405_feature3_text";s:70:"فرصت ارتباط با پژوهشگران و فعالان صنعت";s:22:"conf1405_feature4_icon";s:4:"🏆";s:23:"conf1405_feature4_title";s:24:"جوایز و تقدیر";s:22:"conf1405_feature4_text";s:65:"تقدیر از مقاله‌ها و ارائه‌های برتر";s:22:"conf1405_feature5_icon";s:4:"📚";s:23:"conf1405_feature5_title";s:25:"انتشار مقالات";s:22:"conf1405_feature5_text";s:70:"معرفی و انتشار آثار پذیرفته‌شده همایش";s:22:"conf1405_feature6_icon";s:4:"💻";s:23:"conf1405_feature6_title";s:28:"پنل کاربری کامل";s:22:"conf1405_feature6_text";s:73:"داشبورد اختصاصی برای نویسندگان و داوران";s:20:"conf1405_date1_title";s:30:"مهلت ارسال مقاله";s:19:"conf1405_date1_date";s:20:"۳۰ مهر ۱۴۰۵";s:20:"conf1405_date2_title";s:32:"اعلام نتایج داوری";s:19:"conf1405_date2_date";s:22:"۱۵ آبان ۱۴۰۵";s:20:"conf1405_date3_title";s:35:"مهلت ثبت‌نام نهایی";s:19:"conf1405_date3_date";s:22:"۳۰ آبان ۱۴۰۵";s:20:"conf1405_date4_title";s:25:"برگزاری همایش";s:19:"conf1405_date4_date";s:30:"۱۵ تا ۱۷ آذر ۱۴۰۵";s:21:"conf1405_hero_eyebrow";s:21:"رویداد علمی";s:26:"conf1405_hero_submit_label";s:21:"ارسال مقاله";s:25:"conf1405_hero_about_label";s:23:"درباره همایش";s:21:"conf1405_rail_topline";s:40:"ثبت‌نام و ارسال مقاله";s:19:"conf1405_rail_label";s:21:"رویداد علمی";s:28:"conf1405_rail_location_label";s:8:"مکان";s:28:"conf1405_rail_deadline_label";s:30:"مهلت ارسال مقاله";s:28:"conf1405_rail_register_label";s:31:"ثبت‌نام در همایش";s:23:"conf1405_schedule_title";s:23:"برنامه همایش";s:22:"conf1405_schedule_text";s:56:"جلسه‌ها و کارگاه‌ها را ببینید";s:23:"conf1405_features_title";s:49:"چرا در این همایش شرکت کنید؟";s:22:"conf1405_features_text";s:99:"فرصتی برای یادگیری، شبکه‌سازی و ارائه پژوهش‌های علمی";s:20:"conf1405_dates_title";s:26:"تاریخ‌های مهم";s:19:"conf1405_dates_text";s:59:"مهلت‌ها و رویدادهای کلیدی همایش";s:19:"conf1405_news_title";s:46:"آخرین اخبار و اطلاعیه‌ها";s:18:"conf1405_news_text";s:38:"جدیدترین مطالب همایش";s:23:"conf1405_speakers_title";s:27:"سخنرانان همایش";s:22:"conf1405_speakers_text";s:40:"چهره‌های علمی و تخصصی";s:18:"conf1405_cta_title";s:48:"آماده شرکت در همایش هستید؟";s:17:"conf1405_cta_text";s:54:"حساب کاربری خود را ایجاد کنید.";s:19:"conf1405_cta_button";s:44:"ثبت‌نام با شماره موبایل";','}'),'yes'
WHERE NOT EXISTS (SELECT 1 FROM wp_options WHERE option_name='theme_mods_conference-1405');

-- Widget instances and sidebar assignments. PHP serialized string lengths are UTF-8 byte lengths.
INSERT INTO wp_options (option_name,option_value,autoload)
SELECT 'widget_text','a:4:{i:101;a:4:{s:5:"title";s:21:"دسترسی سریع";s:4:"text";s:128:"برای مشاهده برنامه، سخنرانان و اخبار همایش از فهرست سایت استفاده کنید.";s:6:"filter";b:0;s:6:"visual";b:1;}i:102;a:4:{s:5:"title";s:27:"دبیرخانه همایش";s:4:"text";s:95:"برای پرسش‌ها از صفحه تماس با ما پیام خود را ثبت کنید.";s:6:"filter";b:0;s:6:"visual";b:1;}i:103;a:4:{s:5:"title";s:31:"اطلاعیه دبیرخانه";s:4:"text";s:113:"آخرین اطلاعیه‌ها و مهلت‌های همایش را از بخش اخبار دنبال کنید.";s:6:"filter";b:0;s:6:"visual";b:1;}s:12:"_multiwidget";i:1;}','yes'
WHERE NOT EXISTS (SELECT 1 FROM wp_options WHERE option_name='widget_text');
INSERT INTO wp_options (option_name,option_value,autoload)
SELECT 'sidebars_widgets','a:5:{s:19:"wp_inactive_widgets";a:0:{}s:8:"footer-1";a:1:{i:0;s:8:"text-101";}s:8:"footer-2";a:1:{i:0;s:8:"text-102";}s:13:"homepage-rail";a:1:{i:0;s:8:"text-103";}s:13:"array_version";i:3;}','yes'
WHERE NOT EXISTS (SELECT 1 FROM wp_options WHERE option_name='sidebars_widgets');

COMMIT;
