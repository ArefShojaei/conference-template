<?php
/**
 * Plugin Name: Hamayesh Conference Core
 * Description: Backend foundation for a Persian, RTL, free-to-submit academic conference website.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.1
 * Text Domain: hamayesh-core
 */
defined('ABSPATH') || exit;

final class Hamayesh_Conference_Core {
    const VERSION = '1.0.0';
    const VERIFY_META = '_hm_email_verified';
    const VERIFY_HASH_META = '_hm_email_verify_hash';
    const VERIFY_EXP_META = '_hm_email_verify_exp';
    const MAX_UPLOAD = 10485760;
    private static $instance = null;

    public static function instance() {
        if (null === self::$instance) self::$instance = new self();
        return self::$instance;
    }

    private function __construct() {
        add_action('init', [$this, 'register_content_types']);
        add_action('init', [$this, 'register_shortcodes']);
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_post_nopriv_hm_register', [$this, 'handle_register']);
        add_action('admin_post_hm_register', [$this, 'handle_register']);
        add_action('admin_post_nopriv_hm_login', [$this, 'handle_login']);
        add_action('admin_post_hm_login', [$this, 'handle_login']);
        add_action('admin_post_nopriv_hm_verify_email', [$this, 'handle_verify_email']);
        add_action('admin_post_nopriv_hm_resend_verify', [$this, 'handle_resend_verify']);
        add_action('admin_post_hm_resend_verify', [$this, 'handle_resend_verify']);
        add_action('admin_post_nopriv_hm_submit_paper', [$this, 'handle_submit_paper']);
        add_action('admin_post_hm_submit_paper', [$this, 'handle_submit_paper']);
        add_action('admin_post_hm_update_paper_status', [$this, 'handle_update_paper_status']);
        add_action('admin_post_hm_assign_reviewer', [$this, 'handle_assign_reviewer']);
        add_action('admin_post_hm_save_review', [$this, 'handle_save_review']);
        add_action('admin_post_hm_download_paper', [$this, 'handle_download_paper']);
        add_action('admin_post_nopriv_hm_download_paper', [$this, 'handle_download_paper']);
        add_action('admin_post_hm_logout', [$this, 'handle_logout']);
        add_action('template_redirect', [$this, 'maybe_noindex_private_pages']);
    }

    public static function activate() {
        self::create_tables();
        self::create_roles();
        self::create_pages();
        self::instance()->register_content_types();
        flush_rewrite_rules();
    }

    public static function deactivate() { flush_rewrite_rules(); }

    private static function table($name) { global $wpdb; return $wpdb->prefix . 'hm_' . $name; }

    private static function create_tables() {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $collate = $wpdb->get_charset_collate();
        $papers = self::table('papers');
        $reviews = self::table('reviews');
        $registrations = self::table('registrations');
        $notifications = self::table('notifications');
        $certificates = self::table('certificates');
        $audit = self::table('audit_log');
        dbDelta("CREATE TABLE $papers (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            event_id bigint(20) unsigned NOT NULL DEFAULT 0,
            user_id bigint(20) unsigned NOT NULL,
            title varchar(255) NOT NULL,
            title_en varchar(255) NOT NULL DEFAULT '',
            abstract longtext NOT NULL,
            keywords varchar(500) NOT NULL DEFAULT '',
            track varchar(190) NOT NULL DEFAULT '',
            presentation_type varchar(40) NOT NULL DEFAULT 'oral',
            coauthors longtext NULL,
            file_path text NOT NULL,
            file_name varchar(255) NOT NULL,
            file_sha256 char(64) NOT NULL DEFAULT '',
            status varchar(32) NOT NULL DEFAULT 'submitted',
            version int(10) unsigned NOT NULL DEFAULT 1,
            submitted_at datetime NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY event_id (event_id),
            KEY status (status)
        ) $collate;");
        dbDelta("CREATE TABLE $reviews (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            paper_id bigint(20) unsigned NOT NULL,
            reviewer_id bigint(20) unsigned NOT NULL,
            originality tinyint unsigned NOT NULL DEFAULT 0,
            methodology tinyint unsigned NOT NULL DEFAULT 0,
            clarity tinyint unsigned NOT NULL DEFAULT 0,
            relevance tinyint unsigned NOT NULL DEFAULT 0,
            recommendation varchar(32) NOT NULL DEFAULT 'pending',
            comments longtext NOT NULL,
            confidential_comments longtext NULL,
            submitted_at datetime NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY paper_reviewer (paper_id,reviewer_id),
            KEY reviewer_id (reviewer_id),
            KEY recommendation (recommendation)
        ) $collate;");
        dbDelta("CREATE TABLE $registrations (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            event_id bigint(20) unsigned NOT NULL,
            user_id bigint(20) unsigned NOT NULL,
            attendance_type varchar(20) NOT NULL DEFAULT 'in_person',
            status varchar(24) NOT NULL DEFAULT 'registered',
            registration_code varchar(48) NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY event_user (event_id,user_id),
            UNIQUE KEY registration_code (registration_code),
            KEY user_id (user_id)
        ) $collate;");
        dbDelta("CREATE TABLE $notifications (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            title varchar(190) NOT NULL,
            message text NOT NULL,
            read_at datetime NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY user_read (user_id,read_at)
        ) $collate;");
        dbDelta("CREATE TABLE $certificates (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            paper_id bigint(20) unsigned NOT NULL,
            user_id bigint(20) unsigned NOT NULL,
            certificate_code varchar(64) NOT NULL,
            issued_at datetime NOT NULL,
            revoked_at datetime NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY certificate_code (certificate_code),
            UNIQUE KEY paper_id (paper_id)
        ) $collate;");
        dbDelta("CREATE TABLE $audit (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            actor_id bigint(20) unsigned NOT NULL DEFAULT 0,
            action varchar(100) NOT NULL,
            object_type varchar(40) NOT NULL DEFAULT '',
            object_id bigint(20) unsigned NOT NULL DEFAULT 0,
            details longtext NULL,
            ip_hash char(64) NOT NULL DEFAULT '',
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY actor_id (actor_id),
            KEY object_ref (object_type,object_id),
            KEY action (action)
        ) $collate;");
        update_option('hm_core_db_version', self::VERSION);
    }

    private static function create_roles() {
        add_role('hm_researcher', 'پژوهشگر', ['read' => true, 'upload_files' => false]);
        add_role('hm_reviewer', 'داور علمی', ['read' => true, 'hm_review_papers' => true]);
        add_role('hm_secretariat', 'دبیرخانه همایش', ['read' => true, 'hm_manage_conference' => true, 'hm_review_papers' => true]);
        $admin = get_role('administrator');
        if ($admin) foreach (['hm_review_papers','hm_manage_conference'] as $cap) $admin->add_cap($cap);
    }

    private static function create_pages() {
        $pages = [
            'ثبت‌نام' => ['hm-register', '[hm_register]'],
            'ورود' => ['hm-login', '[hm_login]'],
            'تأیید ایمیل' => ['hm-verify-email', '[hm_verify_email]'],
            'ارسال مقاله' => ['hm-submit-paper', '[hm_submit_paper]'],
            'پنل پژوهشگر' => ['hm-dashboard', '[hm_dashboard]'],
            'پنل داور' => ['hm-reviewer', '[hm_reviewer_dashboard]'],
            'استعلام گواهی' => ['hm-certificate-verify', '[hm_certificate_verify]'],
        ];
        foreach ($pages as $title => $data) {
            if (!get_page_by_path($data[0])) {
                wp_insert_post(['post_type'=>'page','post_status'=>'publish','post_title'=>$title,'post_name'=>$data[0],'post_content'=>$data[1]]);
            }
        }
    }

    public function register_content_types() {
        register_post_type('hm_event', [
            'labels'=>['name'=>'همایش‌ها','singular_name'=>'همایش','add_new_item'=>'افزودن همایش'],
            'public'=>true,'has_archive'=>true,'show_in_rest'=>true,'menu_icon'=>'dashicons-calendar-alt',
            'supports'=>['title','editor','excerpt','thumbnail'],'rewrite'=>['slug'=>'events']
        ]);
        register_post_type('hm_speaker', [
            'labels'=>['name'=>'سخنرانان','singular_name'=>'سخنران'],
            'public'=>true,'has_archive'=>true,'show_in_rest'=>true,'menu_icon'=>'dashicons-microphone',
            'supports'=>['title','editor','thumbnail']
        ]);
    }

    public function register_shortcodes() {
        add_shortcode('hm_register', [$this,'register_form']);
        add_shortcode('hm_login', [$this,'login_form']);
        add_shortcode('hm_verify_email', [$this,'verify_page']);
        add_shortcode('hm_submit_paper', [$this,'submit_paper_form']);
        add_shortcode('hm_dashboard', [$this,'dashboard']);
        add_shortcode('hm_reviewer_dashboard', [$this,'reviewer_dashboard']);
        add_shortcode('hm_certificate_verify', [$this,'certificate_verify']);
        add_shortcode('hm_events', [$this,'events_list']);
    }

    private function form_notice() {
        if (empty($_GET['hm_notice'])) return '';
        $messages = [
            'registered'=>'حساب ساخته شد. برای فعال‌سازی، ایمیل خود را بررسی کنید.',
            'verified'=>'ایمیل تأیید شد؛ اکنون می‌توانید وارد شوید.',
            'invalid'=>'اطلاعات واردشده معتبر نیست یا پیوند منقضی شده است.',
            'login'=>'ایمیل یا رمز عبور نادرست است، یا حساب هنوز تأیید نشده.',
            'sent'=>'اگر حسابی با این اطلاعات وجود داشته باشد، ایمیل راهنما ارسال شده است.',
            'submitted'=>'مقاله با موفقیت ثبت شد.',
            'saved'=>'تغییرات ذخیره شد.',
            'denied'=>'اجازه انجام این عملیات را ندارید.',
            'error'=>'عملیات انجام نشد. اطلاعات را بررسی و دوباره تلاش کنید.',
        ];
        $key = sanitize_key(wp_unslash($_GET['hm_notice']));
        return isset($messages[$key]) ? '<div class="hm-notice" role="status">'.esc_html($messages[$key]).'</div>' : '';
    }

    private function field($label,$name,$type='text',$required=true,$attrs='') {
        return '<p class="hm-field"><label for="hm-'.esc_attr($name).'">'.esc_html($label).'</label><input id="hm-'.esc_attr($name).'" name="'.esc_attr($name).'" type="'.esc_attr($type).'" '.($required?'required':'').' '.$attrs.'></p>';
    }

    private function form_start($action) {
        return '<form class="hm-form" method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="'.esc_attr($action).'">';
    }

    public function register_form() {
        if (is_user_logged_in()) return '<p>شما وارد شده‌اید. <a href="'.esc_url(home_url('/hm-dashboard/')).'">رفتن به پنل</a></p>';
        $html = $this->form_notice().$this->form_start('hm_register');
        $html .= wp_nonce_field('hm_register','hm_nonce',true,false);
        $html .= $this->field('نام و نام خانوادگی','display_name');
        $html .= $this->field('ایمیل','email','email',true,'autocomplete="email"');
        $html .= $this->field('شماره موبایل (اختیاری)','phone','tel',false,'autocomplete="tel"');
        $html .= $this->field('وابستگی سازمانی (اختیاری)','organization','text',false);
        $html .= $this->field('رمز عبور (حداقل ۱۲ نویسه)','password','password',true,'minlength="12" autocomplete="new-password"');
        $html .= '<p><label><input type="checkbox" name="terms" value="1" required> قوانین و سیاست حریم خصوصی را می‌پذیرم.</label></p><button type="submit">ساخت حساب رایگان</button></form>';
        return $html;
    }

    public function login_form() {
        if (is_user_logged_in()) return '<p>وارد شده‌اید. <a href="'.esc_url(home_url('/hm-dashboard/')).'">پنل کاربری</a></p>';
        $html = $this->form_notice().$this->form_start('hm_login').wp_nonce_field('hm_login','hm_nonce',true,false);
        $html .= $this->field('ایمیل','email','email',true,'autocomplete="email"');
        $html .= $this->field('رمز عبور','password','password',true,'autocomplete="current-password"');
        $html .= '<button type="submit">ورود</button></form><p><a href="'.esc_url(wp_lostpassword_url()).'">فراموشی رمز عبور</a></p>';
        $html .= '<p>ورود با Google و کد پیامکی فقط پس از پیکربندی ارائه‌دهنده و کلیدهای معتبر قابل فعال‌سازی است.</p>';
        return $html;
    }

    public function verify_page() {
        if (empty($_GET['token']) || empty($_GET['uid'])) {
            $html = $this->form_notice().'<p>برای تأیید ایمیل از پیوندی که برایتان فرستاده شده استفاده کنید.</p>';
            if (isset($_GET['email'])) $html .= $this->form_start('hm_resend_verify').wp_nonce_field('hm_resend_verify','hm_nonce',true,false).$this->field('ایمیل','email','email').'<button type="submit">ارسال دوباره پیوند تأیید</button></form>';
            return $html;
        }
        return $this->form_notice().'<p>در حال بررسی پیوند تأیید…</p>';
    }

    public function submit_paper_form() {
        if (!is_user_logged_in()) return '<p>برای ارسال رایگان مقاله ابتدا <a href="'.esc_url(home_url('/hm-login/')).'">وارد شوید</a>.</p>';
        if (!get_user_meta(get_current_user_id(),self::VERIFY_META,true)) return '<p>ابتدا ایمیل خود را تأیید کنید.</p>';
        $html = $this->form_notice().$this->form_start('hm_submit_paper').wp_nonce_field('hm_submit_paper','hm_nonce',true,false);
        $html .= $this->field('عنوان مقاله','title');
        $html .= $this->field('عنوان انگلیسی (اختیاری)','title_en','text',false);
        $html .= '<p class="hm-field"><label for="hm-abstract">چکیده</label><textarea id="hm-abstract" name="abstract" required minlength="100" rows="8"></textarea></p>';
        $html .= $this->field('کلیدواژه‌ها','keywords');
        $html .= $this->field('محور علمی','track');
        $html .= '<p class="hm-field"><label for="hm-file">فایل مقاله PDF (حداکثر ۱۰ مگابایت)</label><input id="hm-file" name="paper_file" type="file" accept="application/pdf,.pdf" required></p>';
        $html = str_replace('method="post"','method="post" enctype="multipart/form-data"',$html);
        $html .= '<p><label><input type="checkbox" name="originality" value="1" required> مقاله اصیل است و اصول اخلاق پژوهش رعایت شده است.</label></p><button type="submit">ارسال رایگان برای داوری</button></form><p>ارسال و داوری مقاله رایگان است؛ هیچ فیلد یا مرحله پرداختی وجود ندارد.</p>';
        return $html;
    }

    public function dashboard() {
        if (!is_user_logged_in()) return '<p>برای مشاهده پنل <a href="'.esc_url(home_url('/hm-login/')).'">وارد شوید</a>.</p>';
        global $wpdb;
        $rows = $wpdb->get_results($wpdb->prepare('SELECT id,title,status,updated_at FROM '.self::table('papers').' WHERE user_id=%d ORDER BY updated_at DESC',get_current_user_id()));
        $html = '<section class="hm-dashboard"><h2>پنل پژوهشگر</h2><p>ارسال و داوری مقاله رایگان است.</p><p><a href="'.esc_url(home_url('/hm-submit-paper/')).'">ارسال مقاله جدید</a></p><table><thead><tr><th>عنوان</th><th>وضعیت</th><th>آخرین تغییر</th></tr></thead><tbody>';
        foreach ($rows as $row) $html .= '<tr><td>'.esc_html($row->title).'</td><td>'.esc_html($this->status_label($row->status)).'</td><td>'.esc_html($row->updated_at).'</td></tr>';
        return $html.'</tbody></table></section>';
    }

    public function reviewer_dashboard() {
        if (!current_user_can('hm_review_papers')) return '<p>این بخش برای داوران مجاز است.</p>';
        global $wpdb;
        $rows = $wpdb->get_results($wpdb->prepare('SELECT p.id,p.title,p.status FROM '.self::table('papers').' p INNER JOIN '.self::table('reviews').' r ON r.paper_id=p.id WHERE r.reviewer_id=%d ORDER BY p.updated_at DESC',get_current_user_id()));
        $html = '<h2>پنل داور</h2><table><thead><tr><th>مقاله</th><th>وضعیت</th><th>عملیات</th></tr></thead><tbody>';
        foreach ($rows as $row) $html .= '<tr><td>'.esc_html($row->title).'</td><td>'.esc_html($this->status_label($row->status)).'</td><td>'.$this->review_form((int)$row->id).'</td></tr>';
        return $html.'</tbody></table>';
    }

    private function review_form($paper_id) {
        $html = $this->form_start('hm_save_review').wp_nonce_field('hm_review_'.$paper_id,'hm_nonce',true,false);
        $html .= '<input type="hidden" name="paper_id" value="'.absint($paper_id).'">';
        foreach (['originality'=>'اصالت','methodology'=>'روش‌شناسی','clarity'=>'شفافیت','relevance'=>'ارتباط با محور'] as $key=>$label) $html .= '<label>'.esc_html($label).' <select name="'.esc_attr($key).'"><option value="1">۱</option><option value="2">۲</option><option value="3">۳</option><option value="4">۴</option><option value="5">۵</option></select></label> ';
        $html .= '<label>نتیجه <select name="recommendation"><option value="minor_revision">اصلاح جزئی</option><option value="major_revision">اصلاح اساسی</option><option value="accept">پذیرش</option><option value="reject">رد</option></select></label><textarea name="comments" required placeholder="نظر برای نویسنده"></textarea><textarea name="confidential_comments" placeholder="یادداشت محرمانه برای دبیر علمی"></textarea><button type="submit">ثبت داوری</button></form>';
        return $html;
    }

    public function certificate_verify() {
        $code = isset($_GET['code']) ? sanitize_text_field(wp_unslash($_GET['code'])) : '';
        if (!$code) return '<form method="get"><label for="hm-code">کد گواهی</label><input id="hm-code" name="code" required><button type="submit">استعلام</button></form>';
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare('SELECT c.certificate_code,c.issued_at,c.revoked_at,p.title FROM '.self::table('certificates').' c JOIN '.self::table('papers').' p ON p.id=c.paper_id WHERE c.certificate_code=%s',$code));
        if (!$row || $row->revoked_at) return '<p role="status">گواهی معتبر پیدا نشد.</p>';
        return '<div class="hm-certificate-result"><h2>گواهی معتبر است</h2><p>عنوان مقاله: '.esc_html($row->title).'</p><p>کد: '.esc_html($row->certificate_code).'</p><p>تاریخ صدور: '.esc_html($row->issued_at).'</p></div>';
    }

    public function events_list() {
        $events = get_posts(['post_type'=>'hm_event','post_status'=>'publish','numberposts'=>20]);
        if (!$events) return '<p>در حال حاضر همایشی ثبت نشده است.</p>';
        $html = '<div class="hm-events">';
        foreach ($events as $event) $html .= '<article><h3><a href="'.esc_url(get_permalink($event)).'">'.esc_html(get_the_title($event)).'</a></h3><p>'.esc_html(get_the_excerpt($event)).'</p></article>';
        return $html.'</div>';
    }

    public function handle_register() {
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_register')) $this->redirect('invalid');
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $name = sanitize_text_field(wp_unslash($_POST['display_name'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        if (empty($_POST['terms']) || !is_email($email) || email_exists($email) || strlen($password)<12 || strlen($name)<2) $this->redirect('invalid');
        if (function_exists('is_email') && !is_email($email)) $this->redirect('invalid');
        $user_id = wp_insert_user(['user_login'=>$this->unique_login($email),'user_email'=>$email,'user_pass'=>$password,'display_name'=>$name,'role'=>'hm_researcher']);
        if (is_wp_error($user_id)) $this->redirect('error');
        update_user_meta($user_id,'hm_phone',sanitize_text_field(wp_unslash($_POST['phone'] ?? '')));
        update_user_meta($user_id,'hm_organization',sanitize_text_field(wp_unslash($_POST['organization'] ?? '')));
        update_user_meta($user_id,self::VERIFY_META,0);
        $token = bin2hex(random_bytes(32));
        update_user_meta($user_id,self::VERIFY_HASH_META,hash('sha256',$token));
        update_user_meta($user_id,self::VERIFY_EXP_META,time()+DAY_IN_SECONDS);
        $url = add_query_arg(['uid'=>$user_id,'token'=>$token],home_url('/hm-verify-email/'));
        $sent = wp_mail($email,'تأیید ایمیل حساب همایش',"برای فعال‌سازی حساب روی این پیوند کلیک کنید (اعتبار ۲۴ ساعت):\n".$url);
        $this->audit('register',$user_id,'user',$user_id);
        if (!$sent) error_log('Hamayesh: verification email delivery failed for user ID '.$user_id);
        $this->redirect('registered');
    }

    public function handle_verify_email() {
        $uid = absint($_GET['uid'] ?? 0);
        $token = sanitize_text_field(wp_unslash($_GET['token'] ?? ''));
        $hash = get_user_meta($uid,self::VERIFY_HASH_META,true);
        $expiry = (int)get_user_meta($uid,self::VERIFY_EXP_META,true);
        if (!$uid || !$token || !$hash || $expiry < time() || !hash_equals($hash,hash('sha256',$token))) $this->redirect('invalid');
        update_user_meta($uid,self::VERIFY_META,1);
        delete_user_meta($uid,self::VERIFY_HASH_META);
        delete_user_meta($uid,self::VERIFY_EXP_META);
        $this->audit('email_verified',$uid,'user',$uid);
        $this->redirect('verified');
    }

    public function handle_resend_verify() {
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_resend_verify')) $this->redirect('sent');
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $user = get_user_by('email',$email);
        if ($user && !get_user_meta($user->ID,self::VERIFY_META,true)) {
            $token = bin2hex(random_bytes(32));
            update_user_meta($user->ID,self::VERIFY_HASH_META,hash('sha256',$token));
            update_user_meta($user->ID,self::VERIFY_EXP_META,time()+DAY_IN_SECONDS);
            wp_mail($email,'پیوند تأیید ایمیل',add_query_arg(['uid'=>$user->ID,'token'=>$token],home_url('/hm-verify-email/')));
        }
        $this->redirect('sent');
    }

    public function handle_login() {
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_login')) $this->redirect('login');
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $user = get_user_by('email',$email);
        $creds = ['user_login'=>$user ? $user->user_login : $email,'user_password'=>(string)($_POST['password'] ?? ''),'remember'=>!empty($_POST['remember'])];
        $logged = wp_signon($creds,is_ssl());
        if (is_wp_error($logged) || !get_user_meta($logged->ID,self::VERIFY_META,true)) {
            if (!is_wp_error($logged)) wp_logout();
            $this->redirect('login');
        }
        wp_safe_redirect(home_url('/hm-dashboard/')); exit;
    }

    public function handle_submit_paper() {
        if (!is_user_logged_in() || !get_user_meta(get_current_user_id(),self::VERIFY_META,true)) $this->redirect('denied');
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_submit_paper')) $this->redirect('invalid');
        $title = sanitize_text_field(wp_unslash($_POST['title'] ?? ''));
        $abstract = sanitize_textarea_field(wp_unslash($_POST['abstract'] ?? ''));
        $keywords = sanitize_text_field(wp_unslash($_POST['keywords'] ?? ''));
        if (mb_strlen($title)<5 || mb_strlen($abstract)<100 || empty($_POST['originality'])) $this->redirect('invalid');
        if (empty($_FILES['paper_file']) || !empty($_FILES['paper_file']['error'])) $this->redirect('invalid');
        $file = $_FILES['paper_file'];
        if ((int)$file['size'] > self::MAX_UPLOAD || (int)$file['size'] < 1) $this->redirect('invalid');
        $check = wp_check_filetype_and_ext($file['tmp_name'],$file['name'],['pdf'=>'application/pdf']);
        $mime = function_exists('finfo_open') ? (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) : '';
        if (($check['ext'] ?? '') !== 'pdf' || $mime !== 'application/pdf' || substr(file_get_contents($file['tmp_name'],false,null,0,5),0,5) !== '%PDF-') $this->redirect('invalid');
        $path = $this->store_private_upload($file);
        if (is_wp_error($path)) $this->redirect('error');
        global $wpdb;
        $now = current_time('mysql',true);
        $ok = $wpdb->insert(self::table('papers'),[
            'event_id'=>absint($_POST['event_id'] ?? 0),'user_id'=>get_current_user_id(),
            'title'=>$title,'title_en'=>sanitize_text_field(wp_unslash($_POST['title_en'] ?? '')),
            'abstract'=>$abstract,'keywords'=>$keywords,'track'=>sanitize_text_field(wp_unslash($_POST['track'] ?? '')),
            'presentation_type'=>'oral','coauthors'=>wp_json_encode([]),'file_path'=>$path,
            'file_name'=>sanitize_file_name($file['name']),'file_sha256'=>hash_file('sha256',$path),
            'status'=>'submitted','version'=>1,'submitted_at'=>$now,'updated_at'=>$now
        ]);
        if (!$ok) { @unlink($path); $this->redirect('error'); }
        $paper_id = (int)$wpdb->insert_id;
        $this->notify_role('hm_secretariat','مقاله جدید','یک مقاله جدید برای بررسی اولیه ثبت شد: '.$title);
        $this->audit('paper_submitted',$paper_id,'paper',$paper_id);
        $this->redirect('submitted','/hm-dashboard/');
    }

    public function handle_update_paper_status() {
        if (!current_user_can('hm_manage_conference')) $this->redirect('denied');
        $id = absint($_POST['paper_id'] ?? 0);
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_status_'.$id)) $this->redirect('invalid');
        $status = sanitize_key(wp_unslash($_POST['status'] ?? ''));
        $allowed = ['screening','under_review','revision','accepted','rejected','published'];
        if (!in_array($status,$allowed,true)) $this->redirect('invalid');
        global $wpdb;
        $paper = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.self::table('papers').' WHERE id=%d',$id));
        if (!$paper) $this->redirect('invalid');
        $wpdb->update(self::table('papers'),['status'=>$status,'updated_at'=>current_time('mysql',true)],['id'=>$id]);
        $this->notify($paper->user_id,'وضعیت مقاله تغییر کرد','وضعیت مقاله «'.$paper->title.'» به '.$this->status_label($status).' تغییر کرد.');
        if ($status==='accepted' && get_option('hm_auto_certificate',false)) $this->issue_certificate($paper->id,$paper->user_id);
        $this->audit('paper_status_changed',$id,'paper',$id,['status'=>$status]);
        $this->redirect('saved');
    }

    public function handle_assign_reviewer() {
        if (!current_user_can('hm_manage_conference')) $this->redirect('denied');
        $paper_id=absint($_POST['paper_id']??0); $reviewer_id=absint($_POST['reviewer_id']??0);
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_assign_'.$paper_id)) $this->redirect('invalid');
        $reviewer=get_user_by('id',$reviewer_id);
        if (!$reviewer || !in_array('hm_reviewer',(array)$reviewer->roles,true)) $this->redirect('invalid');
        global $wpdb;
        $exists=$wpdb->get_var($wpdb->prepare('SELECT id FROM '.self::table('papers').' WHERE id=%d',$paper_id));
        if (!$exists) $this->redirect('invalid');
        $now=current_time('mysql',true);
        $wpdb->replace(self::table('reviews'),['paper_id'=>$paper_id,'reviewer_id'=>$reviewer_id,'updated_at'=>$now]);
        $this->notify($reviewer_id,'مقاله برای داوری تخصیص یافت','یک مقاله جدید در صف داوری شما قرار گرفت.');
        $this->audit('reviewer_assigned',$paper_id,'paper',$paper_id,['reviewer_id'=>$reviewer_id]);
        $this->redirect('saved');
    }

    public function handle_save_review() {
        $paper_id=absint($_POST['paper_id']??0);
        if (!current_user_can('hm_review_papers') || !isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_review_'.$paper_id)) $this->redirect('denied');
        global $wpdb;
        $table=self::table('reviews');
        $review=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE paper_id=%d AND reviewer_id=%d",$paper_id,get_current_user_id()));
        if (!$review && !current_user_can('hm_manage_conference')) $this->redirect('denied');
        $scores=[];
        foreach (['originality','methodology','clarity','relevance'] as $key) { $scores[$key]=absint($_POST[$key]??0); if ($scores[$key]<1 || $scores[$key]>5) $this->redirect('invalid'); }
        $recommendation=sanitize_key(wp_unslash($_POST['recommendation']??'pending'));
        if (!in_array($recommendation,['minor_revision','major_revision','accept','reject'],true)) $this->redirect('invalid');
        $comments=sanitize_textarea_field(wp_unslash($_POST['comments']??''));
        $confidential=sanitize_textarea_field(wp_unslash($_POST['confidential_comments']??''));
        $data=array_merge($scores,['recommendation'=>$recommendation,'comments'=>$comments,'confidential_comments'=>$confidential,'submitted_at'=>current_time('mysql',true),'updated_at'=>current_time('mysql',true)]);
        $wpdb->update($table,$data,['paper_id'=>$paper_id,'reviewer_id'=>get_current_user_id()]);
        $this->audit('review_saved',$paper_id,'paper',$paper_id,['recommendation'=>$recommendation]);
        $this->redirect('saved');
    }

    public function handle_download_paper() {
        $id=absint($_GET['paper_id']??0);
        if (!$id || !is_user_logged_in()) wp_die('دسترسی مجاز نیست.',403);
        global $wpdb;
        $paper=$wpdb->get_row($wpdb->prepare('SELECT * FROM '.self::table('papers').' WHERE id=%d',$id));
        if (!$paper) wp_die('فایل پیدا نشد.',404);
        $allowed = (int)$paper->user_id===get_current_user_id() || current_user_can('hm_manage_conference') ||
            (current_user_can('hm_review_papers') && (int)$wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM '.self::table('reviews').' WHERE paper_id=%d AND reviewer_id=%d',$id,get_current_user_id()))>0);
        if (!$allowed) wp_die('دسترسی مجاز نیست.',403);
        $path=realpath($paper->file_path);
        $base=realpath($this->private_dir());
        if (!$path || !$base || strpos($path,$base.DIRECTORY_SEPARATOR)!==0 || !is_readable($path)) wp_die('فایل پیدا نشد.',404);
        nocache_headers(); header('Content-Type: application/pdf'); header('X-Content-Type-Options: nosniff');
        header('Content-Disposition: attachment; filename="'.rawurlencode(basename($paper->file_name)).'"');
        header('Content-Length: '.filesize($path)); readfile($path); exit;
    }

    public function handle_logout() {
        if (!isset($_POST['hm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hm_nonce'])),'hm_logout')) wp_die('درخواست نامعتبر است.',403);
        wp_logout(); wp_safe_redirect(home_url('/')); exit;
    }

    private function private_dir() {
        $uploads=wp_upload_dir();
        $dir=trailingslashit(dirname($uploads['basedir'])).'hamayesh-private';
        if (!is_dir($dir)) wp_mkdir_p($dir);
        if (is_dir($dir)) {
            if (!file_exists($dir.'/.htaccess')) file_put_contents($dir.'/.htaccess',"Require all denied\nDeny from all\n");
            if (!file_exists($dir.'/index.php')) file_put_contents($dir.'/index.php',"<?php http_response_code(404); exit;");
        }
        return $dir;
    }

    private function store_private_upload($file) {
        $dir=$this->private_dir();
        if (!is_dir($dir) || !is_writable($dir)) return new WP_Error('hm_storage','ذخیره‌سازی خصوصی در دسترس نیست.');
        $name=wp_generate_uuid4().'.pdf'; $target=trailingslashit($dir).$name;
        if (!move_uploaded_file($file['tmp_name'],$target)) return new WP_Error('hm_upload','ذخیره فایل انجام نشد.');
        @chmod($target,0640);
        return $target;
    }

    private function issue_certificate($paper_id,$user_id) {
        global $wpdb;
        $table=self::table('certificates');
        $existing=$wpdb->get_var($wpdb->prepare("SELECT id FROM $table WHERE paper_id=%d",$paper_id));
        if ($existing) return;
        $code='HM-'.gmdate('Y').'-'.strtoupper(wp_generate_password(12,false,false));
        $wpdb->insert($table,['paper_id'=>$paper_id,'user_id'=>$user_id,'certificate_code'=>$code,'issued_at'=>current_time('mysql',true)]);
        $this->notify($user_id,'گواهی پذیرش صادر شد','کد گواهی شما: '.$code);
    }

    private function notify($user_id,$title,$message) {
        global $wpdb;
        $wpdb->insert(self::table('notifications'),['user_id'=>(int)$user_id,'title'=>sanitize_text_field($title),'message'=>sanitize_textarea_field($message),'created_at'=>current_time('mysql',true)]);
        $user=get_user_by('id',$user_id);
        if ($user && get_option('hm_email_notifications',true)) wp_mail($user->user_email,$title,$message);
    }
    private function notify_role($role,$title,$message) {
        $users=get_users(['role'=>$role,'fields'=>['ID']]);
        foreach ($users as $user) $this->notify($user->ID,$title,$message);
    }
    private function audit($action,$object_id=0,$type='',$id=0,$details=[]) {
        global $wpdb;
        $ip=sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']??''));
        $wpdb->insert(self::table('audit_log'),['actor_id'=>get_current_user_id(),'action'=>sanitize_key($action),'object_type'=>sanitize_key($type),'object_id'=>(int)$id,'details'=>wp_json_encode($details),'ip_hash'=>$ip?hash_hmac('sha256',$ip,wp_salt('auth')):'','created_at'=>current_time('mysql',true)]);
    }
    private function status_label($status) {
        $labels=['submitted'=>'ارسال شده','screening'=>'بررسی اولیه','under_review'=>'در حال داوری','revision'=>'نیازمند اصلاح','accepted'=>'پذیرفته‌شده','rejected'=>'رد شده','published'=>'منتشر شده'];
        return $labels[$status]??$status;
    }
    private function unique_login($email) {
        $base=sanitize_user(strstr($email,'@',true),true); if (!$base) $base='researcher';
        $login=$base; $i=1; while (username_exists($login)) $login=$base.$i++;
        return $login;
    }
    private function redirect($notice,$path='/hm-login/') {
        wp_safe_redirect(add_query_arg('hm_notice',sanitize_key($notice),home_url($path))); exit;
    }

    public function admin_menu() {
        add_menu_page('سامانه همایش','سامانه همایش','hm_manage_conference','hm-conference',[$this,'admin_papers'],'dashicons-welcome-learn-more',27);
        add_submenu_page('hm-conference','مقالات','مقالات','hm_manage_conference','hm-conference',[$this,'admin_papers']);
        add_submenu_page('hm-conference','داوران','داوران','hm_manage_conference','hm-reviewers',[$this,'admin_reviewers']);
        add_submenu_page('hm-conference','تنظیمات','تنظیمات','manage_options','hm-settings',[$this,'admin_settings']);
    }

    public function admin_papers() {
        if (!current_user_can('hm_manage_conference')) return;
        global $wpdb;
        $rows=$wpdb->get_results('SELECT * FROM '.self::table('papers').' ORDER BY updated_at DESC LIMIT 200');
        echo '<div class="wrap"><h1>مدیریت مقالات</h1><p>ارسال و داوری مقاله رایگان است. حداکثر ۲۰۰ رکورد آخر نمایش داده می‌شود.</p><table class="widefat striped"><thead><tr><th>شناسه</th><th>عنوان</th><th>نویسنده</th><th>وضعیت</th><th>فایل</th><th>تغییر وضعیت</th></tr></thead><tbody>';
        foreach ($rows as $row) {
            $user=get_user_by('id',$row->user_id);
            echo '<tr><td>'.absint($row->id).'</td><td>'.esc_html($row->title).'</td><td>'.esc_html($user?$user->display_name:'—').'</td><td>'.esc_html($this->status_label($row->status)).'</td><td><a href="'.esc_url(admin_url('admin-post.php?action=hm_download_paper&paper_id='.$row->id)).'">دانلود امن</a></td><td><form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="hm_update_paper_status"><input type="hidden" name="paper_id" value="'.absint($row->id).'">'.wp_nonce_field('hm_status_'.$row->id,'hm_nonce',true,false).'<select name="status">';
            foreach (['screening','under_review','revision','accepted','rejected','published'] as $s) echo '<option value="'.esc_attr($s).'" '.selected($row->status,$s,false).'>'.esc_html($this->status_label($s)).'</option>';
            echo '</select><button class="button button-primary">ذخیره</button></form></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function admin_reviewers() {
        if (!current_user_can('hm_manage_conference')) return;
        $reviewers=get_users(['role'=>'hm_reviewer','fields'=>['ID','display_name','user_email']]);
        echo '<div class="wrap"><h1>داوران</h1><p>برای تخصیص مقاله، شناسه مقاله و شناسه داور را در فرم زیر وارد کنید.</p><form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="hm_assign_reviewer">'.wp_nonce_field('hm_assign_0','hm_nonce',true,false).'<label>شناسه مقاله <input type="number" name="paper_id" min="1" required></label> <label>داور <select name="reviewer_id">';
        foreach ($reviewers as $reviewer) echo '<option value="'.absint($reviewer->ID).'">'.esc_html($reviewer->display_name.' — '.$reviewer->user_email).'</option>';
        echo '</select></label><button class="button button-primary">تخصیص</button></form><p>شناسه مقاله را از جدول مقالات بردارید.</p></div>';
    }

    public function admin_settings() {
        if (!current_user_can('manage_options')) return;
        if (isset($_POST['hm_settings_submit'])) {
            check_admin_referer('hm_settings');
            update_option('hm_email_notifications',!empty($_POST['hm_email_notifications']));
            update_option('hm_auto_certificate',!empty($_POST['hm_auto_certificate']));
            echo '<div class="updated notice"><p>تنظیمات ذخیره شد.</p></div>';
        }
        echo '<div class="wrap"><h1>تنظیمات همایش</h1><form method="post">';
        wp_nonce_field('hm_settings');
        echo '<p><label><input type="checkbox" name="hm_email_notifications" value="1" '.checked(get_option('hm_email_notifications',true),true,false).'> اعلان ایمیلی</label></p><p><label><input type="checkbox" name="hm_auto_certificate" value="1" '.checked(get_option('hm_auto_certificate',false),true,false).'> صدور خودکار گواهی هنگام پذیرش</label></p><p>SMTP، ورود OAuth و پیامک باید با سرویس‌دهنده معتبر و افزونه/آداپتور مربوط تنظیم شوند؛ در صورت عدم پیکربندی فعال نیستند.</p><button class="button button-primary" name="hm_settings_submit" value="1">ذخیره</button></form></div>';
    }

    public function maybe_noindex_private_pages() {
        if (is_page(['hm-dashboard','hm-reviewer','hm-submit-paper'])) add_action('wp_head',function(){echo '<meta name="robots" content="noindex,nofollow">';});
    }
}

register_activation_hook(__FILE__, ['Hamayesh_Conference_Core','activate']);
register_deactivation_hook(__FILE__, ['Hamayesh_Conference_Core','deactivate']);
Hamayesh_Conference_Core::instance();
