-- Conference 1405 sample data (DEMO ONLY)
-- 1) Activate wordpress/conference-core first so its tables exist.
-- 2) Replace every "wp_" prefix below with the actual WordPress table prefix.
-- 3) Back up the database first. This creates sample rows for an existing administrator account.
-- Sample file_path values are placeholders; no actual paper files are included.
SET @demo_uid := (SELECT u.ID FROM wp_users u JOIN wp_usermeta m ON m.user_id=u.ID AND m.meta_key='wp_capabilities' WHERE m.meta_value LIKE '%administrator%' ORDER BY u.ID LIMIT 1);
SET @demo_uid := COALESCE(@demo_uid, (SELECT ID FROM wp_users ORDER BY ID LIMIT 1));

INSERT INTO wp_hm_papers (event_id,user_id,title,title_en,abstract,keywords,track,presentation_type,coauthors,file_path,file_name,file_sha256,status,version,submitted_at,updated_at)
SELECT 1405,@demo_uid,'هوش مصنوعی توضیح‌پذیر در سامانه‌های سلامت','Explainable AI in Healthcare Systems','این مقاله نمونه برای نمایش چرخه ارسال، بررسی و اعلام نتیجه است. داده‌ها ساختگی‌اند و نباید به‌عنوان پژوهش واقعی استفاده شوند.','هوش مصنوعی، سلامت، توضیح‌پذیری','هوش مصنوعی','oral','نویسنده همکار نمونه','demo://sample-paper-accepted.pdf','sample-paper-accepted.pdf','', 'accepted',1,UTC_TIMESTAMP(),UTC_TIMESTAMP()
WHERE @demo_uid IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_papers WHERE user_id=@demo_uid AND title='هوش مصنوعی توضیح‌پذیر در سامانه‌های سلامت');

INSERT INTO wp_hm_papers (event_id,user_id,title,title_en,abstract,keywords,track,presentation_type,coauthors,file_path,file_name,file_sha256,status,version,submitted_at,updated_at)
SELECT 1405,@demo_uid,'تحلیل داده‌های شهری با یادگیری ماشین','Urban Data Analysis with Machine Learning','چکیده نمونه دوم برای تست نمایش وضعیت در پنل کاربر و دبیرخانه.','یادگیری ماشین، شهر هوشمند','داده‌کاوی','poster','همکار دوم نمونه','demo://sample-paper-review.pdf','sample-paper-review.pdf','', 'under_review',1,UTC_TIMESTAMP(),UTC_TIMESTAMP()
WHERE @demo_uid IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_papers WHERE user_id=@demo_uid AND title='تحلیل داده‌های شهری با یادگیری ماشین');

INSERT INTO wp_hm_papers (event_id,user_id,title,title_en,abstract,keywords,track,presentation_type,coauthors,file_path,file_name,file_sha256,status,version,submitted_at,updated_at)
SELECT 1405,@demo_uid,'بررسی نمونه‌ای امنیت اینترنت اشیا','A Sample Study of IoT Security','چکیده ساختگی سوم برای مشاهده وضعیت ردشده در محیط آزمایشی.','امنیت، اینترنت اشیا','امنیت سایبری','oral','', 'demo://sample-paper-rejected.pdf','sample-paper-rejected.pdf','', 'rejected',1,UTC_TIMESTAMP(),UTC_TIMESTAMP()
WHERE @demo_uid IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_papers WHERE user_id=@demo_uid AND title='بررسی نمونه‌ای امنیت اینترنت اشیا');

SET @p1 := (SELECT id FROM wp_hm_papers WHERE user_id=@demo_uid AND title='هوش مصنوعی توضیح‌پذیر در سامانه‌های سلامت' LIMIT 1);
SET @p2 := (SELECT id FROM wp_hm_papers WHERE user_id=@demo_uid AND title='تحلیل داده‌های شهری با یادگیری ماشین' LIMIT 1);
SET @p3 := (SELECT id FROM wp_hm_papers WHERE user_id=@demo_uid AND title='بررسی نمونه‌ای امنیت اینترنت اشیا' LIMIT 1);

INSERT INTO wp_hm_reviews (paper_id,reviewer_id,originality,methodology,clarity,relevance,recommendation,comments,confidential_comments,submitted_at,updated_at)
SELECT @p1,@demo_uid,5,4,5,5,'accept','نمونه داوری: ساختار روشن و موضوع مرتبط است.','این نظر محرمانه نمونه است.',UTC_TIMESTAMP(),UTC_TIMESTAMP()
WHERE @p1 IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_reviews WHERE paper_id=@p1 AND reviewer_id=@demo_uid);
INSERT INTO wp_hm_reviews (paper_id,reviewer_id,originality,methodology,clarity,relevance,recommendation,comments,confidential_comments,submitted_at,updated_at)
SELECT @p2,@demo_uid,4,3,4,4,'minor_revision','نمونه داوری: روش اجرا نیازمند توضیح بیشتر است.','داده‌ها ساختگی‌اند.',UTC_TIMESTAMP(),UTC_TIMESTAMP()
WHERE @p2 IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_reviews WHERE paper_id=@p2 AND reviewer_id=@demo_uid);
INSERT INTO wp_hm_reviews (paper_id,reviewer_id,originality,methodology,clarity,relevance,recommendation,comments,confidential_comments,submitted_at,updated_at)
SELECT @p3,@demo_uid,2,2,3,2,'reject','نمونه داوری: شواهد کافی برای نتیجه‌گیری ارائه نشده است.','داده‌ها ساختگی‌اند.',UTC_TIMESTAMP(),UTC_TIMESTAMP()
WHERE @p3 IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_reviews WHERE paper_id=@p3 AND reviewer_id=@demo_uid);

INSERT INTO wp_hm_registrations (event_id,user_id,attendance_type,status,registration_code,created_at)
SELECT 1405,@demo_uid,'in_person','registered','DEMO-1405-REG-001',UTC_TIMESTAMP()
WHERE @demo_uid IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_registrations WHERE event_id=1405 AND user_id=@demo_uid);

INSERT INTO wp_hm_notifications (user_id,title,message,read_at,created_at)
SELECT @demo_uid,'نمونه اعلان همایش','این اعلان ساختگی برای بررسی ظاهر پنل کاربری است.',NULL,UTC_TIMESTAMP()
WHERE @demo_uid IS NOT NULL AND NOT EXISTS (SELECT 1 FROM wp_hm_notifications WHERE user_id=@demo_uid AND title='نمونه اعلان همایش');

-- Demo rows are intentionally attached to an existing admin account, so never run on a live production database.
