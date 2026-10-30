<?php
/**
 * Plugin Name: Conference Core
 * Description: Core conference workflows: mobile OTP, papers, roles, dashboards and demo content.
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Text Domain: conference-core
 */
if (!defined('ABSPATH')) exit;
define('CONFCORE_VERSION','1.0.0');
define('CONFCORE_DIR',plugin_dir_path(__FILE__));

final class Conference_Core {
  private static $instance=null;
  public static function instance(){ if(self::$instance===null) self::$instance=new self(); return self::$instance; }
  private function __construct(){
    add_action('init',array($this,'ensure_role_caps'),1);
    add_action('init',array($this,'register_types'));
    add_action('rest_api_init',array($this,'routes'));
    add_action('template_redirect',array($this,'private_page_headers'),0);
    add_action('admin_menu',array($this,'admin_menu'));
    add_action('admin_init',array($this,'settings'));
    add_action('admin_init',array($this,'ensure_default_pages'));
    add_action('add_meta_boxes',array($this,'contact_meta_box'));
    add_action('add_meta_boxes',array($this,'session_meta_box'));
    add_action('save_post_conf_session',array($this,'save_session_meta'));
    add_action('save_post_conf_paper',array($this,'save_paper_assignment'));
    add_action('admin_head-user-edit.php',array($this,'hide_core_email_field'));
    add_action('admin_head-profile.php',array($this,'hide_core_email_field'));
    add_action('admin_head-user-new.php',array($this,'hide_core_email_field'));
    add_filter('manage_users_columns',array($this,'remove_email_user_column'));
    add_action('show_user_profile',array($this,'admin_phone_profile_field'));
    add_action('edit_user_profile',array($this,'admin_phone_profile_field'));
    add_action('personal_options_update',array($this,'save_admin_phone_profile'));
    add_action('edit_user_profile_update',array($this,'save_admin_phone_profile'));
    add_filter('user_profile_update_errors',array($this,'allow_blank_profile_email'),10,3);
    add_action('admin_post_confcore_download',array($this,'download_paper'));
    add_action('transition_post_status',array($this,'paper_status_notification'),10,3);
    add_action('admin_post_confcore_contact',array($this,'save_contact'));
    add_action('admin_post_nopriv_confcore_contact',array($this,'save_contact'));
    add_action('admin_post_confcore_event_registration',array($this,'save_event_registration'));
    add_action('admin_post_confcore_profile',array($this,'save_profile'));
    add_shortcode('conference_login',array($this,'login_shortcode'));
    add_shortcode('conference_register',array($this,'register_shortcode'));
    add_shortcode('conference_dashboard',array($this,'dashboard_shortcode'));
    add_shortcode('conference_submit_paper',array($this,'submit_shortcode'));
    add_shortcode('conference_papers',array($this,'papers_shortcode'));
    add_shortcode('conference_speakers',array($this,'speakers_shortcode'));
    add_shortcode('conference_schedule',array($this,'schedule_shortcode'));
    add_shortcode('conference_team',array($this,'team_shortcode'));
    add_shortcode('conference_news',array($this,'news_shortcode'));
    add_shortcode('conference_contact',array($this,'contact_shortcode'));
    add_shortcode('conference_event_registration',array($this,'event_registration_shortcode'));
    add_shortcode('conference_my_papers',array($this,'my_papers_shortcode'));
    add_shortcode('conference_review_queue',array($this,'review_queue_shortcode'));
    add_shortcode('conference_my_reviews',array($this,'my_reviews_shortcode'));
    add_shortcode('conference_messages',array($this,'messages_shortcode'));
    add_shortcode('conference_profile',array($this,'profile_shortcode'));
    add_shortcode('conference_certificates',array($this,'certificates_shortcode'));
    add_shortcode('conference_admin_workspace',array($this,'admin_workspace_shortcode'));
    add_shortcode('conference_reviewer_dashboard',array($this,'reviewer_dashboard_shortcode'));
    add_shortcode('conference_review_paper',array($this,'review_paper_shortcode'));
    add_action('wp_enqueue_scripts',array($this,'assets'));
  }
  public static function activate(){
    add_role('conference_author','نویسنده همایش',array('read'=>true,'upload_files'=>true,'submit_conference_papers'=>true));
    add_role('conference_reviewer','داور همایش',array('read'=>true,'review_conference_papers'=>true));
    add_role('conference_manager','مدیر همایش',array('read'=>true,'edit_posts'=>true,'edit_others_posts'=>true,'read_private_posts'=>true,'publish_posts'=>true,'upload_files'=>true,'manage_conference'=>true,'review_conference_papers'=>true,'list_users'=>true));
    $admin_role=get_role('administrator');
    if($admin_role){$admin_role->add_cap('manage_conference');$admin_role->add_cap('review_conference_papers');}

    global $wpdb; $table=$wpdb->prefix.'confcore_otp';
    $charset=$wpdb->get_charset_collate();
    require_once ABSPATH.'wp-admin/includes/upgrade.php';
    dbDelta("CREATE TABLE {$table} (phone varchar(20) NOT NULL, code_hash varchar(255) NOT NULL, expires_at datetime NOT NULL, attempts tinyint unsigned NOT NULL DEFAULT 0, created_at datetime NOT NULL, PRIMARY KEY  (phone), KEY expires_at (expires_at)) {$charset};");
    self::instance()->register_types();
    self::create_default_pages();
    update_option('confcore_site_structure_version','2');
    flush_rewrite_rules();
  }
  public static function deactivate(){ flush_rewrite_rules(); }
  private static function create_default_pages(){
    $pages=array(
      'home'=>array('صفحه اصلی',''),
      'login'=>array('ورود','[conference_login]'),
      'register'=>array('ثبت‌نام','[conference_register]'),
      'dashboard'=>array('داشبورد کاربری','[conference_dashboard]'),
      'submit-paper'=>array('ارسال مقاله','[conference_submit_paper]'),
      'papers'=>array('مقالات پذیرفته‌شده','[conference_papers]'),
      'about'=>array('درباره همایش','<h2>درباره همایش فناوری و نوآوری</h2><p>این رویداد بستری برای ارائه پژوهش‌های نو، تبادل تجربه میان دانشگاه و صنعت و توسعه همکاری‌های علمی است. اهداف، محورهای علمی و اخبار رویداد از همین برگه قابل ویرایش هستند.</p><h3>اهداف همایش</h3><ul><li>ارائه دستاوردهای پژوهشی و کاربردی</li><li>تقویت همکاری میان پژوهشگران و صنعت</li><li>معرفی راهکارهای نوآورانه در فناوری‌های نوظهور</li></ul>'),
      'contact'=>array('تماس با ما','[conference_contact]'),
      'faq'=>array('سوالات متداول','<h2>سوالات متداول</h2><h3>چگونه ثبت‌نام کنم؟</h3><p>با شماره موبایل خود وارد شوید و درخواست حضور را از صفحه ثبت‌نام همایش ثبت کنید.</p><h3>چگونه مقاله ارسال کنم؟</h3><p>پس از ورود به پنل، فایل PDF، DOC یا DOCX خود را با حجم حداکثر ۲۰ مگابایت ارسال کنید.</p><h3>نتیجه داوری کجا نمایش داده می‌شود؟</h3><p>وضعیت مقاله در پنل کاربری و در صورت تنظیم سرویس پیامک، از طریق پیامک اطلاع‌رسانی می‌شود.</p>'),
      'speakers'=>array('سخنرانان','[conference_speakers]'),
      'schedule'=>array('برنامه همایش','[conference_schedule]'),
      'team'=>array('تیم و کمیته‌ها','[conference_team]'),
      'news'=>array('اخبار و اطلاعیه‌ها','[conference_news]'),
      'posts'=>array('اخبار و نوشته‌ها','[conference_news]'),
      'event-registration'=>array('ثبت‌نام در همایش','[conference_event_registration]'),
      'my-papers'=>array('مقالات من','[conference_my_papers]'),
      'my-registration'=>array('ثبت‌نام من','[conference_event_registration]'),
      'certificates'=>array('گواهی‌های من','[conference_certificates]'),
      'messages'=>array('پیام‌ها و اعلان‌ها','[conference_messages]'),
      'profile'=>array('پروفایل من','[conference_profile]'),
      'reviewer-dashboard'=>array('پنل داوری','[conference_reviewer_dashboard]'),
      'review-queue'=>array('صف داوری','[conference_review_queue]'),
      'review-paper'=>array('داوری مقاله','[conference_review_paper]'),
      'my-reviews'=>array('داوری‌های من','[conference_my_reviews]'),
      'author-guidelines'=>array('راهنمای نویسندگان','<h2>راهنمای ارسال مقاله</h2><ol><li>عنوان و مشخصات نویسندگان را کامل وارد کنید.</li><li>فایل نهایی را با فرمت PDF، DOC یا DOCX آماده کنید.</li><li>حجم فایل نباید بیشتر از ۲۰ مگابایت باشد.</li><li>پس از ارسال، شناسه مقاله را برای پیگیری نگه دارید.</li></ol>'),
      'admin-dashboard'=>array('مرکز مدیریت','[conference_admin_workspace section="dashboard"]'),
      'admin-users'=>array('مدیریت کاربران','[conference_admin_workspace section="users"]'),
      'admin-papers'=>array('مدیریت مقالات','[conference_admin_workspace section="papers"]'),
      'admin-registrations'=>array('مدیریت ثبت‌نام‌ها','[conference_admin_workspace section="registrations"]'),
      'admin-reviews'=>array('مدیریت داوری‌ها','[conference_admin_workspace section="reviews"]'),
      'admin-reviewers'=>array('مدیریت داوران','[conference_admin_workspace section="reviewers"]'),
      'admin-settings'=>array('تنظیمات همایش','[conference_admin_workspace section="settings"]'),
      'admin-sms'=>array('تنظیمات پیامک','[conference_admin_workspace section="sms"]'),
      'admin-team'=>array('مدیریت تیم و کمیته‌ها','[conference_admin_workspace section="team"]'),
      'admin-posts'=>array('مدیریت نوشته‌ها','[conference_admin_workspace section="posts"]')
    );
    foreach($pages as $slug=>$item){
      $existing=get_page_by_path($slug);
      if(!$existing){
        $id=wp_insert_post(array('post_type'=>'page','post_status'=>'publish','post_title'=>$item[0],'post_name'=>$slug,'post_content'=>$item[1]),true);
        if(is_wp_error($id))continue;
      } elseif(trim((string)$existing->post_content)===''){
        wp_update_post(array('ID'=>$existing->ID,'post_content'=>$item[1]));
      }
    }
    $home=get_page_by_path('home');
    $posts=get_page_by_path('posts');
    if($home){update_option('show_on_front','page');update_option('page_on_front',(int)$home->ID);}
    if($posts)update_option('page_for_posts',(int)$posts->ID);
  }
  public function ensure_default_pages(){
    if(get_option('confcore_site_structure_version')==='2')return;
    self::create_default_pages();
    update_option('confcore_site_structure_version','2');
  }
  public function ensure_role_caps(){
    $admin=get_role('administrator');
    if($admin){foreach(array('manage_conference','review_conference_papers') as $cap)if(!$admin->has_cap($cap))$admin->add_cap($cap);}
    $manager=get_role('conference_manager');
    if($manager){foreach(array('read','edit_posts','edit_others_posts','read_private_posts','publish_posts','upload_files','manage_conference','review_conference_papers','list_users') as $cap)if(!$manager->has_cap($cap))$manager->add_cap($cap);}
    $author=get_role('conference_author');
    if($author){foreach(array('submit_conference_papers','upload_files') as $cap)if(!$author->has_cap($cap))$author->add_cap($cap);}
    $reviewer=get_role('conference_reviewer');
    if($reviewer && !$reviewer->has_cap('review_conference_papers'))$reviewer->add_cap('review_conference_papers');
  }
  public function register_types(){
    register_post_type('conf_speaker',array('labels'=>array('name'=>'سخنرانان','singular_name'=>'سخنران'),'public'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-microphone','supports'=>array('title','editor','excerpt','thumbnail'),'show_in_rest'=>true));
    register_post_type('conf_session',array('labels'=>array('name'=>'برنامه همایش','singular_name'=>'جلسه'),'public'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-calendar-alt','supports'=>array('title','editor','excerpt'),'show_in_rest'=>true));
    register_post_type('conf_committee',array('labels'=>array('name'=>'تیم و کمیته‌ها','singular_name'=>'عضو تیم'),'public'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-groups','supports'=>array('title','editor','excerpt','thumbnail'),'show_in_rest'=>true));
    register_post_type('conf_message',array('labels'=>array('name'=>'پیام‌های تماس','singular_name'=>'پیام تماس'),'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'menu_icon'=>'dashicons-email-alt','supports'=>array('title','editor','author'),'capability_type'=>'post','map_meta_cap'=>true));
    register_post_type('conf_registration',array('labels'=>array('name'=>'ثبت‌نام شرکت‌کنندگان','singular_name'=>'ثبت‌نام همایش'),'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'menu_icon'=>'dashicons-clipboard','supports'=>array('title','author'),'capability_type'=>'post','map_meta_cap'=>true));
    register_post_type('conf_certificate',array('labels'=>array('name'=>'گواهی‌ها','singular_name'=>'گواهی شرکت'),'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'menu_icon'=>'dashicons-awards','supports'=>array('title','editor','author'),'capability_type'=>'post','map_meta_cap'=>true));
    register_post_type('conf_paper',array('labels'=>array('name'=>'مقالات ارسالی','singular_name'=>'مقاله'),'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'menu_icon'=>'dashicons-media-document','supports'=>array('title','author'),'capability_type'=>'post','map_meta_cap'=>true));
  }
  public function remove_email_user_column($columns){unset($columns['email']);return $columns;}
  public function hide_core_email_field(){ echo '<style>#email,.user-email-wrap,#email-description,label[for="email"]{display:none!important}</style><script>document.addEventListener("DOMContentLoaded",function(){var e=document.getElementById("email");if(e&&e.closest("tr"))e.closest("tr").style.display="none";});</script>'; }
  public function allow_blank_profile_email($errors,$update,$user){ if(isset($_POST['email']) && trim((string)wp_unslash($_POST['email']))==='')$errors->remove('empty_email'); }

  private function find_user_by_phone($phone){
    $user=get_user_by('login',$phone);
    if($user)return $user;
    $ids=get_users(array('meta_key'=>'conference_phone','meta_value'=>$phone,'number'=>1,'fields'=>'ID'));
    return !empty($ids)?get_user_by('id',(int)$ids[0]):false;
  }
  public function admin_phone_profile_field($user){
    if(!current_user_can('manage_options'))return;
    $phone=get_user_meta($user->ID,'conference_phone',true);
    echo '<h2>ورود با شماره موبایل</h2><table class="form-table"><tr><th><label for="conference_phone_admin">شماره موبایل</label></th><td><input type="tel" id="conference_phone_admin" name="conference_phone_admin" value="'.esc_attr($phone).'" class="regular-text" placeholder="09123456789"><p class="description">برای ورود OTP مدیران و کاربران قدیمی؛ شماره باید یکتا باشد.</p>';
    wp_nonce_field('confcore_admin_phone_'.$user->ID,'confcore_admin_phone_nonce');
    echo '</td></tr></table>';
  }
  public function save_admin_phone_profile($user_id){
    if(!current_user_can('manage_options') || !isset($_POST['confcore_admin_phone_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['confcore_admin_phone_nonce'])),'confcore_admin_phone_'.$user_id))return;
    $phone=$this->normalize_phone(wp_unslash($_POST['conference_phone_admin']??''));
    if(!$phone){delete_user_meta($user_id,'conference_phone');return;}
    $existing=$this->find_user_by_phone($phone);
    if($existing && (int)$existing->ID!==(int)$user_id)return;
    update_user_meta($user_id,'conference_phone',$phone);
  }
  private function normalize_phone($phone){
    $digits=array('۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9','٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9');
    $phone=strtr((string)$phone,$digits); $phone=preg_replace('/[^0-9+]/','',$phone);
    if(strpos($phone,'+98')===0)$phone='0'.substr($phone,3);
    if(strpos($phone,'0098')===0)$phone='0'.substr($phone,4);
    if(strpos($phone,'98')===0 && strlen($phone)===12)$phone='0'.substr($phone,2);
    return preg_match('/^09[0-9]{9}$/',$phone)?$phone:false;
  }
  public function private_page_headers(){
    $private_pages=array('login','register','dashboard','submit-paper','event-registration','my-papers','my-registration','certificates','messages','profile','reviewer-dashboard','review-queue','review-paper','my-reviews','admin-dashboard','admin-users','admin-papers','admin-registrations','admin-reviews','admin-reviewers','admin-settings','admin-sms','admin-team','admin-posts');
    if(is_page($private_pages)){
      nocache_headers();
      if(!headers_sent())header('X-Robots-Tag: noindex, nofollow, noarchive',true);
    }
  }
  public function routes(){
    register_rest_route('conference/v1','/otp/request',array('methods'=>'POST','callback'=>array($this,'request_otp'),'permission_callback'=>'__return_true'));
    register_rest_route('conference/v1','/otp/verify',array('methods'=>'POST','callback'=>array($this,'verify_otp'),'permission_callback'=>'__return_true'));
    register_rest_route('conference/v1','/papers/upload',array('methods'=>'POST','callback'=>array($this,'upload_paper'),'permission_callback'=>function(){return is_user_logged_in() && current_user_can('submit_conference_papers');}));
    register_rest_route('conference/v1','/papers/(?P<id>\\d+)/decision',array('methods'=>'POST','callback'=>array($this,'paper_decision'),'permission_callback'=>function(){return is_user_logged_in() && (current_user_can('review_conference_papers') || current_user_can('manage_options'));}));
  }
  private function rate_limited($key,$limit,$seconds){
    $count=(int)get_transient($key); if($count >= $limit)return true; set_transient($key,$count+1,$seconds); return false;
  }
  public function request_otp($request){
    $phone=$this->normalize_phone($request->get_param('phone')); $mode=sanitize_key($request->get_param('mode'));
    if(!$phone || !in_array($mode,array('login','register'),true))return new WP_Error('invalid_input','شماره موبایل معتبر نیست.',array('status'=>400));
    $user=$this->find_user_by_phone($phone);
    // Do not disclose whether a phone number already has an account.
    if(($mode==='login' && !$user) || ($mode==='register' && $user))return rest_ensure_response(array('success'=>true,'message'=>'اگر شماره برای این مسیر قابل استفاده باشد، کد تأیید ارسال می‌شود. در غیر این صورت مسیر ورود یا ثبت‌نام مناسب را انتخاب کنید.'));
    $ip=isset($_SERVER['REMOTE_ADDR'])?sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])):'unknown';
    if($this->rate_limited('conf_otp_phone_'.md5($phone),3,900) || $this->rate_limited('conf_otp_ip_'.md5($ip),12,900))return new WP_Error('rate_limit','تعداد درخواست‌ها زیاد است. کمی بعد تلاش کنید.',array('status'=>429));
    $code=(string)random_int(100000,999999); $hash=hash_hmac('sha256',$code,wp_salt('auth'));
    global $wpdb; $table=$wpdb->prefix.'confcore_otp';
    $wpdb->query("DELETE FROM {$table} WHERE expires_at < UTC_TIMESTAMP()");
    $wpdb->replace($table,array('phone'=>$phone,'code_hash'=>$hash,'expires_at'=>gmdate('Y-m-d H:i:s',time()+300),'attempts'=>0,'created_at'=>current_time('mysql',true)),array('%s','%s','%s','%d','%s'));
    $sent=$this->send_verification_sms($phone,$code);
    if(is_wp_error($sent)){ $wpdb->delete($table,array('phone'=>$phone),array('%s')); return $sent; }
    return rest_ensure_response(array('success'=>true,'message'=>'کد تأیید پیامک شد. کد تا ۵ دقیقه معتبر است.'));
  }
  private function send_verification_sms($phone,$code){
    // API key را در wp-config.php با CONFERENCE_KAVENEGAR_API_KEY یا تنظیمات افزونه وارد کنید.
    // نام قالب باید در پنل کاوه‌نگار برای VerifyLookup تأیید شده باشد.
    $api=defined('CONFERENCE_KAVENEGAR_API_KEY')?CONFERENCE_KAVENEGAR_API_KEY:get_option('confcore_kavenegar_key','');
    $template=get_option('confcore_kavenegar_template',''); $sender=get_option('confcore_kavenegar_sender','');
    if(!$api || !$template)return new WP_Error('sms_not_configured','تنظیمات سرویس پیامک کامل نیست؛ مدیر سایت باید API Key و نام قالب را وارد کند.',array('status'=>503));
    $url='https://api.kavenegar.com/v1/'.rawurlencode($api).'/verify/lookup.json';
    $body=array('receptor'=>$phone,'token'=>$code,'template'=>$template,'type'=>'sms');
    if($sender!=='')$body['sender']=$sender;
    $response=wp_remote_post($url,array('timeout'=>15,'redirection'=>0,'body'=>$body));
    if(is_wp_error($response))return new WP_Error('sms_transport','ارتباط با سرویس پیامک برقرار نشد.',array('status'=>502));
    $status=wp_remote_retrieve_response_code($response); $json=json_decode(wp_remote_retrieve_body($response),true);
    if($status!==200 || empty($json['return']['status']) || (int)$json['return']['status']!==200)return new WP_Error('sms_failed','ارسال پیامک ناموفق بود؛ تنظیمات سرویس را بررسی کنید.',array('status'=>502));
    return true;
  }
  private function send_submission_sms($post_id){
    $post=get_post($post_id); if(!$post)return false;
    $phone=get_user_meta($post->post_author,'conference_phone',true);
    $api=defined('CONFERENCE_KAVENEGAR_API_KEY')?CONFERENCE_KAVENEGAR_API_KEY:get_option('confcore_kavenegar_key','');
    $template=get_option('confcore_kavenegar_submission_template','');
    if(!$phone || !$api || !$template)return false;
    // Approved VerifyLookup template: token = submitted, token2 = paper ID.
    $url='https://api.kavenegar.com/v1/'.rawurlencode($api).'/verify/lookup.json';
    $response=wp_remote_post($url,array('timeout'=>15,'redirection'=>0,'body'=>array('receptor'=>$phone,'token'=>'ثبت شد','token2'=>(string)$post_id,'template'=>$template,'type'=>'sms')));
    return !is_wp_error($response) && wp_remote_retrieve_response_code($response)===200;
  }
  private function send_status_sms($post_id,$status){
    $post=get_post($post_id); if(!$post)return false;
    $phone=get_user_meta($post->post_author,'conference_phone',true);
    $api=defined('CONFERENCE_KAVENEGAR_API_KEY')?CONFERENCE_KAVENEGAR_API_KEY:get_option('confcore_kavenegar_key','');
    $template=get_option('confcore_kavenegar_result_template','');
    if(!$phone || !$api || !$template)return false;
    // Configure a separate approved Kavenegar VerifyLookup template with %token% and optionally %token2%.
    $label=$status==='publish'?'پذیرفته شد':'نیازمند اصلاح';
    $url='https://api.kavenegar.com/v1/'.rawurlencode($api).'/verify/lookup.json';
    $response=wp_remote_post($url,array('timeout'=>15,'redirection'=>0,'body'=>array('receptor'=>$phone,'token'=>$label,'token2'=>(string)$post_id,'template'=>$template,'type'=>'sms')));
    return !is_wp_error($response) && wp_remote_retrieve_response_code($response)===200;
  }
  public function verify_otp($request){
    $phone=$this->normalize_phone($request->get_param('phone')); $first_name=sanitize_text_field($request->get_param('first_name')); $last_name=sanitize_text_field($request->get_param('last_name')); $code=strtr((string)$request->get_param('code'),array('۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9','٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9')); $code=preg_replace('/[^0-9]/','',$code); $mode=sanitize_key($request->get_param('mode'));
    if(!$phone || !preg_match('/^[0-9]{6}$/',$code) || !in_array($mode,array('login','register'),true) || ($mode==='register' && ($first_name==='' || $last_name==='')))return new WP_Error('invalid_input','اطلاعات واردشده معتبر نیست. نام، نام خانوادگی، شماره و کد تأیید را بررسی کنید.',array('status'=>400));
    global $wpdb; $table=$wpdb->prefix.'confcore_otp'; $row=$wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE phone=%s",$phone));
    if(!$row || strtotime($row->expires_at.' UTC')<time())return new WP_Error('expired','کد منقضی شده است؛ دوباره درخواست دهید.',array('status'=>400));
    if((int)$row->attempts>=5){$wpdb->delete($table,array('phone'=>$phone),array('%s'));return new WP_Error('locked','تعداد تلاش مجاز تمام شده است.',array('status'=>429));}
    $hash=hash_hmac('sha256',$code,wp_salt('auth'));
    if(!hash_equals($row->code_hash,$hash)){ $wpdb->update($table,array('attempts'=>(int)$row->attempts+1),array('phone'=>$phone),array('%d'),array('%s'));return new WP_Error('wrong_code','کد تأیید اشتباه است.',array('status'=>400));}
    $user=$this->find_user_by_phone($phone);
    if($mode==='register' && !$user){
      $display_name=trim($first_name.' '.$last_name); $user_id=wp_insert_user(array('user_login'=>$phone,'user_pass'=>wp_generate_password(48,true,true),'user_email'=>'','first_name'=>$first_name,'last_name'=>$last_name,'display_name'=>$display_name,'role'=>'conference_author'));
      if(is_wp_error($user_id))return new WP_Error('register_failed','ساخت حساب کاربری انجام نشد.',array('status'=>500));
      update_user_meta($user_id,'conference_phone',$phone); $user=get_user_by('id',$user_id);
    }
    if(!$user)return new WP_Error('account_missing','حساب کاربری پیدا نشد.',array('status'=>404));
    $wpdb->delete($table,array('phone'=>$phone),array('%s'));
    wp_set_current_user($user->ID); wp_set_auth_cookie($user->ID,true,is_ssl()); do_action('wp_login',$user->user_login,$user);
    return rest_ensure_response(array('success'=>true,'message'=>'ورود با موفقیت انجام شد.','redirect'=>home_url('/dashboard/')));
  }
  private function private_storage_dir(){
    $document_root=isset($_SERVER['DOCUMENT_ROOT'])?realpath(wp_normalize_path(wp_unslash($_SERVER['DOCUMENT_ROOT']))):false;
    $document_root_normalized=$document_root?untrailingslashit(wp_normalize_path($document_root)):'';
    if(defined('CONFERENCE_PRIVATE_STORAGE_DIR') && CONFERENCE_PRIVATE_STORAGE_DIR){
      $candidate=untrailingslashit(CONFERENCE_PRIVATE_STORAGE_DIR);
    } else {
      $candidate=dirname(rtrim(ABSPATH,'/\\')).DIRECTORY_SEPARATOR.'conference-private';
      $candidate_normalized=untrailingslashit(wp_normalize_path($candidate));
      if($document_root_normalized && ($candidate_normalized===$document_root_normalized || strpos($candidate_normalized,$document_root_normalized.'/')===0)){
        $candidate=dirname($document_root_normalized).DIRECTORY_SEPARATOR.'conference-private';
      }
    }
    if(!is_dir($candidate) && !wp_mkdir_p($candidate))return false;
    $real=realpath($candidate);
    if(!$real || !is_writable($real))return false;
    $real_normalized=untrailingslashit(wp_normalize_path($real));
    if($document_root_normalized && ($real_normalized===$document_root_normalized || strpos($real_normalized,$document_root_normalized.'/')===0))return false;
    @chmod($real,0700);
    if(!file_exists($real.DIRECTORY_SEPARATOR.'index.php'))file_put_contents($real.DIRECTORY_SEPARATOR.'index.php',"<?php http_response_code(404); exit;");
    if(!file_exists($real.DIRECTORY_SEPARATOR.'.htaccess'))file_put_contents($real.DIRECTORY_SEPARATOR.'.htaccess',"Require all denied\n<IfModule !mod_authz_core.c> Deny from all </IfModule>\n");
    if(!file_exists($real.DIRECTORY_SEPARATOR.'web.config'))file_put_contents($real.DIRECTORY_SEPARATOR.'web.config','<?xml version="1.0" encoding="UTF-8"?><configuration><system.webServer><authorization><deny users="*" /></authorization></system.webServer></configuration>');
    return $real;
  }
  public function upload_paper($request){
    if($this->rate_limited('conf_upload_user_'.get_current_user_id(),10,3600))return new WP_Error('upload_rate_limit','سقف ارسال فایل در این ساعت پر شده است.',array('status'=>429));
    if(empty($_FILES['paper']) || !isset($_FILES['paper']['tmp_name']))return new WP_Error('missing_file','فایل مقاله انتخاب نشده است.',array('status'=>400));
    $f=$_FILES['paper']; if((int)$f['error']!==UPLOAD_ERR_OK)return new WP_Error('upload_error','بارگذاری فایل با خطا مواجه شد.',array('status'=>400));
    if((int)$f['size']<1 || (int)$f['size']>20*1024*1024)return new WP_Error('file_size','حداکثر حجم فایل ۲۰ مگابایت است.',array('status'=>413));
    $name=sanitize_file_name($f['name']); $ext=strtolower(pathinfo($name,PATHINFO_EXTENSION));
    if(!in_array($ext,array('pdf','doc','docx'),true))return new WP_Error('file_type','فقط فایل PDF، DOC یا DOCX مجاز است.',array('status'=>415));
    $handle=fopen($f['tmp_name'],'rb'); if(!$handle)return new WP_Error('file_read','خواندن فایل بارگذاری‌شده ممکن نیست.',array('status'=>400)); $magic=fread($handle,8); fclose($handle);
    $valid=($ext==='pdf' && strpos($magic,'%PDF-')===0) || ($ext==='doc' && substr($magic,0,8)==="\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1");
    if($ext==='docx'){
      if(!class_exists('ZipArchive'))return new WP_Error('docx_unavailable','برای اعتبارسنجی DOCX، افزونه ZipArchive باید روی هاست فعال باشد.',array('status'=>503));
      $zip=new ZipArchive();
      if($zip->open($f['tmp_name'])===true){
        $valid=$zip->locateName('[Content_Types].xml')!==false && $zip->locateName('word/document.xml')!==false && $zip->numFiles<=2000;
        $uncompressed=0;
        for($z=0;$valid && $z<$zip->numFiles;$z++){
          $stat=$zip->statIndex($z);
          if(!$stat || strpos($stat['name'],'../')!==false || strpos($stat['name'],'\\')===0 || (isset($stat['size']) && (int)$stat['size']>25*1024*1024)){$valid=false;break;}
          $uncompressed+=(int)$stat['size'];
          if($uncompressed>50*1024*1024){$valid=false;break;}
        }
        $zip->close();
      }
    }
    if(!$valid)return new WP_Error('file_signature','محتوای فایل با پسوند آن مطابقت ندارد یا فایل DOCX معتبر نیست.',array('status'=>415));
    $private=$this->private_storage_dir();
    if(!$private)return new WP_Error('storage_error','فضای ذخیره‌سازی خصوصی و خارج از مسیر عمومی وب آماده نیست؛ مسیر دسترسی هاست را بررسی کنید.',array('status'=>500));
    $stored=wp_generate_password(24,false,false).'.'.$ext; $target=$private.'/'.$stored;
    if(!move_uploaded_file($f['tmp_name'],$target))return new WP_Error('storage_error','ذخیره فایل انجام نشد.',array('status'=>500));
    @chmod($target,0600);
    $title=sanitize_text_field($request->get_param('title')); if($title==='')$title=pathinfo($name,PATHINFO_FILENAME);
    $abstract=sanitize_textarea_field($request->get_param('abstract'));
    $keywords=sanitize_text_field($request->get_param('keywords'));
    $track=sanitize_text_field($request->get_param('track'));
    if($abstract==='' || strlen($abstract)>20000 || strlen($title)>720 || strlen($keywords)>1200 || strlen($track)>240){@unlink($target);return new WP_Error('paper_metadata','عنوان و چکیده مقاله معتبر نیستند یا از سقف مجاز بیشترند.',array('status'=>400));}
    $post_id=wp_insert_post(array('post_type'=>'conf_paper','post_status'=>'pending','post_title'=>$title,'post_excerpt'=>wp_trim_words($abstract,45,'…'),'post_author'=>get_current_user_id()),true);
    if(is_wp_error($post_id)){@unlink($target);return new WP_Error('save_error','ثبت اطلاعات مقاله ناموفق بود.',array('status'=>500));}
    update_post_meta($post_id,'_conf_private_path',$target); update_post_meta($post_id,'_conf_original_name',$name); update_post_meta($post_id,'_conf_file_size',(int)$f['size']);
    update_post_meta($post_id,'_conf_paper_abstract',$abstract);update_post_meta($post_id,'_conf_paper_keywords',$keywords);update_post_meta($post_id,'_conf_paper_track',$track);
    $this->send_submission_sms($post_id);
    return rest_ensure_response(array('success'=>true,'message'=>'مقاله با موفقیت ثبت شد و در انتظار بررسی است.','paper_id'=>$post_id));
  }
  public function paper_status_notification($new_status,$old_status,$post){
    if($post instanceof WP_Post && $post->post_type==='conf_paper' && $old_status==='pending' && in_array($new_status,array('publish','draft'),true))$this->send_status_sms($post->ID,$new_status);
    if($post instanceof WP_Post && $post->post_type==='conf_registration' && $old_status==='pending' && in_array($new_status,array('publish','draft'),true))$this->send_registration_sms($post->ID,$new_status==='publish'?'ثبت‌نام تأیید شد':'نیازمند پیگیری');
  }
  public function paper_decision($request){
    $id=absint($request['id']); $decision=sanitize_key($request->get_param('decision')); $note=sanitize_textarea_field($request->get_param('note'));
    $post=get_post($id); if(!$post || $post->post_type!=='conf_paper' || $post->post_status!=='pending')return new WP_Error('paper_unavailable','این مقاله در صف بررسی نیست.',array('status'=>404));
    if(!current_user_can('manage_conference') && !current_user_can('manage_options') && (int)get_post_meta($id,'_conf_assigned_reviewer',true)!==get_current_user_id())return new WP_Error('not_assigned','این مقاله به شما تخصیص داده نشده است.',array('status'=>403));
    if(!in_array($decision,array('accept','reject'),true))return new WP_Error('invalid_decision','تصمیم معتبر نیست.',array('status'=>400));
    $status=$decision==='accept'?'publish':'draft';
    $updated=wp_update_post(array('ID'=>$id,'post_status'=>$status),true);
    if(is_wp_error($updated))return new WP_Error('decision_failed','ثبت نتیجه انجام نشد.',array('status'=>500));
    update_post_meta($id,'_conf_review_note',$note); update_post_meta($id,'_conf_reviewed_by',get_current_user_id());
    return rest_ensure_response(array('success'=>true,'message'=>$decision==='accept'?'مقاله پذیرفته شد.':'مقاله برای اصلاح بازگردانده شد.'));
  }
  public function download_paper(){
    $id=isset($_GET['paper'])?absint($_GET['paper']):0; if(!$id || !wp_verify_nonce(isset($_GET['_wpnonce'])?sanitize_text_field(wp_unslash($_GET['_wpnonce'])):'','confcore_download_'.$id))wp_die('درخواست نامعتبر است.',403);
    $post=get_post($id); if(!$post || $post->post_type!=='conf_paper')wp_die('مقاله پیدا نشد.',404);
    $is_owner=(int)$post->post_author===get_current_user_id();
    $is_manager=current_user_can('manage_conference') || current_user_can('manage_options');
    $is_assigned_reviewer=current_user_can('review_conference_papers') && (int)get_post_meta($id,'_conf_assigned_reviewer',true)===get_current_user_id();
    if(!$is_owner && !$is_manager && !$is_assigned_reviewer)wp_die('دسترسی غیرمجاز.',403);
    $path=get_post_meta($id,'_conf_private_path',true);
    $private_base=$this->private_storage_dir();$legacy_base=realpath(wp_upload_dir()['basedir'].'/conference-private');$real_path=$path?realpath($path):false;$inside_new=$private_base && $real_path && strpos($real_path,$private_base.DIRECTORY_SEPARATOR)===0;$inside_legacy=$legacy_base && $real_path && strpos($real_path,$legacy_base.DIRECTORY_SEPARATOR)===0;
    if((!$inside_new && !$inside_legacy) || !$real_path || !is_file($real_path))wp_die('فایل موجود نیست.',404);
    $path=$real_path;
    $ext=strtolower(pathinfo($path,PATHINFO_EXTENSION)); $mime=$ext==='pdf'?'application/pdf':($ext==='doc'?'application/msword':'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    nocache_headers(); header('X-Content-Type-Options: nosniff'); header('Content-Type: '.$mime); header('Content-Length: '.filesize($path)); header('Content-Disposition: attachment; filename="paper-'.$id.'.'.$ext.'"; filename*=UTF-8\'\''.rawurlencode(get_post_meta($id,'_conf_original_name',true))); readfile($path); exit;
  }
  public function assets(){
    wp_register_style('confcore-front',plugins_url('assets/css/frontend.css',__FILE__),array(),CONFCORE_VERSION);
    wp_register_script('confcore-front',plugins_url('assets/js/frontend.js',__FILE__),array(),CONFCORE_VERSION,true);
    wp_localize_script('confcore-front','ConfCore',array('rest'=>esc_url_raw(rest_url('conference/v1/')),'nonce'=>wp_create_nonce('wp_rest'),'login'=>home_url('/login/'),'dashboard'=>home_url('/dashboard/')));
  }
  private function form_script(){wp_enqueue_style('confcore-front');wp_enqueue_script('confcore-front');}
  private function auth_form($mode){
    if(is_user_logged_in())return '<p>شما وارد شده‌اید. <a href="'.esc_url(home_url('/dashboard/')).'">رفتن به پنل</a></p>';
    $this->form_script(); ob_start(); ?>
    <div class="confcore-auth-content">
      <div class="auth-step"><?php echo $mode==='register'?'ثبت‌نام با شماره موبایل':'ورود با شماره همراه'; ?></div>
      <h2><?php echo $mode==='register'?'ثبت‌نام رایگان':'خوش برگشتید'; ?> <span aria-hidden="true">👋</span></h2>
      <p class="auth-intro"><?php echo $mode==='register'?'نام و نام خانوادگی و شماره همراه خود را وارد کنید. پس از تأیید شماره، حساب اولیه ساخته می‌شود.':'شماره موبایل خود را وارد کنید تا کد یک‌بارمصرف دریافت کنید.'; ?></p>
      <form class="confcore-otp-form auth-form" data-mode="<?php echo esc_attr($mode); ?>" novalidate>
        <?php if($mode==='register'): ?><div class="form-row"><div class="form-group"><label class="form-label" for="conf-first-name">نام</label><input class="form-control" id="conf-first-name" name="first_name" type="text" maxlength="60" autocomplete="given-name" required placeholder="نام شما"></div><div class="form-group"><label class="form-label" for="conf-last-name">نام خانوادگی</label><input class="form-control" id="conf-last-name" name="last_name" type="text" maxlength="80" autocomplete="family-name" required placeholder="نام خانوادگی"></div></div><?php endif; ?>
        <?php if($mode==='register'): ?><label class="check-line terms-line"><input type="checkbox" name="terms" required><span>با <a href="<?php echo esc_url(home_url('/faq/')); ?>">قوانین همایش</a> موافقم و مالک شماره تلفن واردشده هستم.</span></label><?php endif; ?>
        <div class="form-group"><label class="form-label" for="conf-phone">شماره تلفن همراه</label><div class="field-with-icon"><input class="form-control" id="conf-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" dir="ltr" maxlength="14" placeholder="09123456789" required></div><small class="form-hint">شماره موبایل ایران را با ۰۹ وارد کنید.</small></div>
        <button class="btn btn-primary btn-lg btn-block auth-submit" type="submit">دریافت کد تأیید <span>←</span></button>
        <div class="form-group confcore-otp-step" data-otp-step hidden><label class="form-label" for="conf-otp">کد تأیید شش‌رقمی</label><input class="form-control" id="conf-otp" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9۰-۹٠-٩]{6}" maxlength="6" placeholder="کد پیامک‌شده"><small class="form-hint">کد پیامک‌شده را وارد کنید. اعتبار کد پنج دقیقه است.</small><button class="btn btn-primary btn-lg btn-block auth-submit mt-3" type="button" data-verify>تأیید و ادامه</button></div>
        <p class="confcore-message" role="status" aria-live="polite"></p>
      </form>
      <p class="auth-legal"><?php echo $mode==='register'?'با ثبت‌نام، مالکیت شماره تلفن همراه خود را تأیید می‌کنید. نقش و سطح دسترسی پس از ثبت‌نام توسط مدیر سامانه تعیین می‌شود.':'با ادامه، قوانین و راهنمای همایش را می‌پذیرید.'; ?></p>
    </div>
    <?php return ob_get_clean();
  }
  public function login_shortcode(){return $this->auth_form('login');}
  public function register_shortcode(){return $this->auth_form('register');}
  public function submit_shortcode(){
    if(!is_user_logged_in())return '<div class="card confcore-form"><p>برای ارسال مقاله ابتدا <a href="'.esc_url(home_url('/login/')).'">وارد شوید</a>.</p></div>';
    if(!current_user_can('submit_conference_papers'))return '<div class="card confcore-form"><p>دسترسی ارسال مقاله برای حساب شما فعال نیست. با مدیر همایش تماس بگیرید.</p></div>';
    $this->form_script(); ob_start(); ?>
    <div class="card confcore-form"><h2>ارسال مقاله</h2><p>اطلاعات مقاله را کامل کنید. فایل فقط در فضای خصوصی سرور ذخیره می‌شود و از طریق لینک عمومی قابل دریافت نیست.</p>
    <form class="confcore-paper-form"><label for="conf-paper-title">عنوان مقاله</label><input id="conf-paper-title" type="text" name="title" maxlength="180" required>
    <label for="conf-paper-abstract">چکیده مقاله</label><textarea id="conf-paper-abstract" name="abstract" rows="6" maxlength="5000" required></textarea>
    <label for="conf-paper-keywords">کلیدواژه‌ها</label><input id="conf-paper-keywords" type="text" name="keywords" maxlength="300" placeholder="هوش مصنوعی، یادگیری ماشین">
    <label for="conf-paper-track">محور علمی</label><select id="conf-paper-track" name="track"><option value="">انتخاب محور</option><option value="هوش مصنوعی و علم داده">هوش مصنوعی و علم داده</option><option value="امنیت و شبکه">امنیت و شبکه</option><option value="اینترنت اشیا">اینترنت اشیا</option><option value="سلامت دیجیتال">سلامت دیجیتال</option><option value="فناوری و تحول دیجیتال">فناوری و تحول دیجیتال</option></select>
    <label for="conf-paper-file">فایل مقاله (PDF، DOC، DOCX - حداکثر ۲۰ مگابایت)</label><input id="conf-paper-file" type="file" name="paper" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
    <button class="btn btn-primary" type="submit">ارسال برای بررسی</button><p class="confcore-message" role="status" aria-live="polite"></p></form></div>
    <?php return ob_get_clean();
  }
  public function dashboard_shortcode(){
    if(!is_user_logged_in())return '<p>برای مشاهده پنل ابتدا <a href="'.esc_url(home_url('/login/')).'">وارد شوید</a>.</p>';
    $this->form_script();
    $u=wp_get_current_user(); $papers=get_posts(array('post_type'=>'conf_paper','author'=>$u->ID,'posts_per_page'=>50,'post_status'=>array('pending','publish','draft','private')));
    ob_start(); ?><div class="admin-layout"><aside class="admin-sidebar"><h3>پنل کاربری</h3><nav class="admin-nav"><a href="<?php echo esc_url(home_url('/dashboard/')); ?>">داشبورد</a><a href="<?php echo esc_url(home_url('/my-papers/')); ?>">مقالات من</a><a href="<?php echo esc_url(home_url('/submit-paper/')); ?>">ارسال مقاله</a><a href="<?php echo esc_url(home_url('/my-registration/')); ?>">ثبت‌نام من</a><a href="<?php echo esc_url(home_url('/certificates/')); ?>">گواهی‌ها</a><a href="<?php echo esc_url(home_url('/messages/')); ?>">پیام‌ها</a><a href="<?php echo esc_url(home_url('/profile/')); ?>">پروفایل</a><?php if(current_user_can('review_conference_papers')): ?><a href="<?php echo esc_url(home_url('/review-queue/')); ?>">صف داوری</a><a href="<?php echo esc_url(home_url('/my-reviews/')); ?>">داوری‌های من</a><?php endif; ?><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج</a></nav></aside><section class="admin-main"><header class="admin-page-header"><h1>سلام، <?php echo esc_html($u->display_name); ?></h1><p>وضعیت مقالات و فعالیت‌های حساب کاربری شما</p></header><div class="admin-content-grid"><div class="admin-panel"><h2>مقالات من</h2><?php if($papers): ?><div class="table-wrapper"><table><thead><tr><th>عنوان</th><th>وضعیت</th><th>نظر داور</th><th>فایل</th></tr></thead><tbody><?php foreach($papers as $p): ?><tr><td><?php echo esc_html($p->post_title); ?></td><td><?php echo esc_html($p->post_status==='pending'?'در انتظار بررسی':($p->post_status==='publish'?'پذیرفته/منتشرشده':($p->post_status==='draft'?'نیازمند اصلاح':$p->post_status))); ?></td><td><?php echo esc_html(get_post_meta($p->ID,'_conf_review_note',true)); ?></td><td><a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=confcore_download&paper='.$p->ID),'confcore_download_'.$p->ID)); ?>">دریافت فایل</a></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><p>هنوز مقاله‌ای ارسال نکرده‌اید.</p><?php endif; ?><a class="btn btn-primary" href="<?php echo esc_url(home_url('/submit-paper/')); ?>">ارسال مقاله جدید</a></div><?php if(current_user_can('review_conference_papers')): $queue_args=array('post_type'=>'conf_paper','post_status'=>'pending','posts_per_page'=>50);if(!current_user_can('manage_conference') && !current_user_can('manage_options')){$queue_args['meta_key']='_conf_assigned_reviewer';$queue_args['meta_value']=get_current_user_id();}$queue=get_posts($queue_args); ?><div class="admin-panel"><h2>صف داوری مقالات</h2><?php if($queue): ?><div class="table-wrapper"><table><thead><tr><th>عنوان مقاله</th><th>شناسه</th><th>فایل</th></tr></thead><tbody><?php foreach($queue as $item): ?><tr><td><?php echo esc_html($item->post_title); ?></td><td><?php echo esc_html($item->ID); ?></td><td><a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=confcore_download&paper='.$item->ID),'confcore_download_'.$item->ID)); ?>">دریافت فایل</a> <button type="button" class="button" data-paper-decision="<?php echo esc_attr($item->ID); ?>" data-decision="accept">پذیرش</button> <button type="button" class="button" data-paper-decision="<?php echo esc_attr($item->ID); ?>" data-decision="reject">بازگشت برای اصلاح</button></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><p>مقاله‌ای در صف داوری نیست.</p><?php endif; ?></div><?php endif; ?></div></section></div><?php return ob_get_clean();
  }
  public function my_papers_shortcode(){
    if(!is_user_logged_in())return '<p>برای مشاهده مقالات وارد شوید.</p>';
    $items=get_posts(array('post_type'=>'conf_paper','author'=>get_current_user_id(),'posts_per_page'=>50,'post_status'=>array('pending','publish','draft','private')));
    if(!$items)return '<p>هنوز مقاله‌ای ثبت نکرده‌اید.</p>';
    ob_start();echo '<div class="table-wrapper"><table><thead><tr><th>عنوان</th><th>وضعیت</th><th>نظر داور</th><th>فایل</th></tr></thead><tbody>';
    foreach($items as $p){$label=$p->post_status==='pending'?'در انتظار بررسی':($p->post_status==='publish'?'پذیرفته‌شده':($p->post_status==='draft'?'نیازمند اصلاح':'در حال بررسی'));echo '<tr><td>'.esc_html($p->post_title).'</td><td>'.esc_html($label).'</td><td>'.esc_html(get_post_meta($p->ID,'_conf_review_note',true)).'</td><td><a href="'.esc_url(wp_nonce_url(admin_url('admin-post.php?action=confcore_download&paper='.$p->ID),'confcore_download_'.$p->ID)).'">دریافت فایل</a></td></tr>';}
    echo '</tbody></table></div>';return ob_get_clean();
  }
  public function review_queue_shortcode(){
    if(!is_user_logged_in() || !current_user_can('review_conference_papers'))return '<p>این بخش فقط برای داوران و مدیران قابل دسترسی است.</p>';
    $queue_args=array('post_type'=>'conf_paper','post_status'=>'pending','posts_per_page'=>50);
    if(!current_user_can('manage_conference') && !current_user_can('manage_options')){$queue_args['meta_key']='_conf_assigned_reviewer';$queue_args['meta_value']=get_current_user_id();}
    $items=get_posts($queue_args);
    if(!$items)return '<p>مقاله‌ای در صف داوری نیست.</p>';
    $this->form_script();ob_start();echo '<div class="table-wrapper"><table><thead><tr><th>عنوان مقاله</th><th>شناسه</th><th>فایل و تصمیم</th></tr></thead><tbody>';
    foreach($items as $p){echo '<tr><td>'.esc_html($p->post_title).'</td><td>'.esc_html($p->ID).'</td><td><a href="'.esc_url(home_url('/review-paper/?paper_id='.$p->ID)).'">جزئیات و داوری</a> | <a href="'.esc_url(wp_nonce_url(admin_url('admin-post.php?action=confcore_download&paper='.$p->ID),'confcore_download_'.$p->ID)).'">دریافت فایل</a> <button type="button" data-paper-decision="'.esc_attr($p->ID).'" data-decision="accept">پذیرش</button> <button type="button" data-paper-decision="'.esc_attr($p->ID).'" data-decision="reject">بازگشت برای اصلاح</button></td></tr>';}
    echo '</tbody></table></div>';return ob_get_clean();
  }
  public function my_reviews_shortcode(){
    if(!is_user_logged_in() || !current_user_can('review_conference_papers'))return '<p>این بخش فقط برای داوران و مدیران قابل دسترسی است.</p>';
    $items=get_posts(array('post_type'=>'conf_paper','post_status'=>array('publish','draft'),'posts_per_page'=>50,'meta_key'=>'_conf_reviewed_by','meta_value'=>get_current_user_id()));
    if(!$items)return '<p>هنوز داوری ثبت‌شده‌ای ندارید.</p>';
    ob_start();echo '<div class="grid grid-2">';foreach($items as $p){echo '<article class="card"><h3>'.esc_html($p->post_title).'</h3><p>'.esc_html($p->post_status==='publish'?'پذیرفته‌شده':'بازگشت برای اصلاح').'</p><p>'.esc_html(get_post_meta($p->ID,'_conf_review_note',true)).'</p></article>';}echo '</div>';return ob_get_clean();
  }
  public function messages_shortcode(){
    if(!is_user_logged_in())return '<p>برای مشاهده اعلان‌ها وارد شوید.</p>';
    $items=get_posts(array('post_type'=>'conf_paper','author'=>get_current_user_id(),'posts_per_page'=>30,'post_status'=>array('pending','publish','draft')));
    $reg=get_posts(array('post_type'=>'conf_registration','author'=>get_current_user_id(),'posts_per_page'=>1,'post_status'=>array('pending','publish','draft')));
    ob_start();echo '<div class="grid grid-2">';
    foreach($items as $p){$note=get_post_meta($p->ID,'_conf_review_note',true);$status=$p->post_status==='pending'?'مقاله دریافت شد و در صف بررسی است':($p->post_status==='publish'?'مقاله پذیرفته شده است':'مقاله نیازمند اصلاح است');echo '<article class="card"><h3>'.esc_html($p->post_title).'</h3><p>'.esc_html($status).'</p>'.($note?'<p>'.esc_html($note).'</p>':'').'</article>';}
    foreach($reg as $item){$status=$item->post_status==='publish'?'ثبت‌نام همایش تأیید شده است':($item->post_status==='pending'?'درخواست ثبت‌نام در انتظار تأیید است':'درخواست ثبت‌نام نیازمند پیگیری است');echo '<article class="card"><h3>ثبت‌نام همایش</h3><p>'.esc_html($status).'</p></article>';}
    echo '</div>';return ob_get_clean();
  }
  public function profile_shortcode(){
    $this->form_script();
    if(!is_user_logged_in())return '<p>برای مشاهده پروفایل وارد شوید.</p>';
    $u=wp_get_current_user();$phone=get_user_meta($u->ID,'conference_phone',true);
    return '<div class="card confcore-form"><h2>پروفایل کاربری</h2><form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="confcore_profile">'.wp_nonce_field('confcore_profile','confcore_profile_nonce',true,false).'<label>نام نمایشی</label><input name="display_name" maxlength="100" value="'.esc_attr($u->display_name).'" required><label>شماره موبایل تأییدشده</label><input value="'.esc_attr($phone).'" readonly><button class="btn btn-primary" type="submit">ذخیره پروفایل</button></form></div>';
  }
  public function save_profile(){
    if(!is_user_logged_in() || !isset($_POST['confcore_profile_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['confcore_profile_nonce'])),'confcore_profile'))wp_die('درخواست نامعتبر است.',403);
    $name=sanitize_text_field(wp_unslash($_POST['display_name']??''));if(!$name)wp_die('نام نمایشی الزامی است.',400);
    $updated=wp_update_user(array('ID'=>get_current_user_id(),'display_name'=>$name));if(is_wp_error($updated))wp_die('ذخیره پروفایل انجام نشد.',500);
    wp_safe_redirect(home_url('/profile/?updated=1'));exit;
  }
  public function certificates_shortcode(){
    if(!is_user_logged_in())return '<p>برای مشاهده گواهی‌ها وارد شوید.</p>';
    $items=get_posts(array('post_type'=>'conf_certificate','author'=>get_current_user_id(),'posts_per_page'=>50,'post_status'=>'publish'));
    if(!$items)return '<p>گواهی‌ای برای حساب شما ثبت نشده است.</p>';
    ob_start();echo '<div class="grid grid-2">';foreach($items as $p){echo '<article class="card"><h3>'.esc_html($p->post_title).'</h3><div>'.wp_kses_post(apply_filters('the_content',$p->post_content)).'</div></article>';}echo '</div>';return ob_get_clean();
  }
  public function papers_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_paper','post_status'=>'publish','posts_per_page'=>20));
    if(!$q->have_posts())return '<p>هنوز مقاله پذیرفته‌شده‌ای برای نمایش منتشر نشده است.</p>';
    ob_start(); echo '<div class="grid grid-2">'; while($q->have_posts()){$q->the_post();$abstract=get_post_meta(get_the_ID(),'_conf_paper_abstract',true);$track=get_post_meta(get_the_ID(),'_conf_paper_track',true);$author=get_the_author();if(!$author)$author='نمونه نمایشی';echo '<article class="card"><h3>'.esc_html(get_the_title()).'</h3>';if($track)echo '<p class="confcore-speaker-role">'.esc_html($track).'</p>';if($abstract)echo '<p>'.esc_html(wp_trim_words($abstract,45,'…')).'</p>';echo '<p class="text-muted">نویسنده: '.esc_html($author).' | '.esc_html(get_the_date()).'</p></article>';} wp_reset_postdata(); echo '</div>'; return ob_get_clean();
  }
  public function speakers_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_speaker','posts_per_page'=>24,'orderby'=>'menu_order title','order'=>'ASC'));
    if(!$q->have_posts())return '<p>اطلاعات سخنرانان به‌زودی منتشر می‌شود.</p>';
    ob_start(); echo '<div class="grid grid-4">'; while($q->have_posts()){$q->the_post();$role=get_post_meta(get_the_ID(),'_conf_speaker_role',true);echo '<article class="card speaker-card">';if(has_post_thumbnail())the_post_thumbnail('medium');echo '<h3>'.esc_html(get_the_title()).'</h3>';if($role)echo '<p class="confcore-speaker-role">'.esc_html($role).'</p>';echo '<div>'.wp_kses_post(get_the_excerpt()).'</div></article>';} wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function schedule_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_session','posts_per_page'=>100,'meta_query'=>array('day_clause'=>array('key'=>'_conf_session_day','compare'=>'EXISTS'),'start_clause'=>array('key'=>'_conf_session_start','compare'=>'EXISTS')),'orderby'=>array('day_clause'=>'ASC','start_clause'=>'ASC')));
    if(!$q->have_posts())return '<p>برنامه همایش هنوز منتشر نشده است.</p>';
    ob_start();$day='';echo '<div class="confcore-schedule">';
    while($q->have_posts()){$q->the_post();$d=sanitize_text_field(get_post_meta(get_the_ID(),'_conf_session_day',true));$start=sanitize_text_field(get_post_meta(get_the_ID(),'_conf_session_start',true));$end=sanitize_text_field(get_post_meta(get_the_ID(),'_conf_session_end',true));$room=sanitize_text_field(get_post_meta(get_the_ID(),'_conf_session_room',true));$speaker=sanitize_text_field(get_post_meta(get_the_ID(),'_conf_session_speaker',true));
      if($d!==$day){if($day!=='')echo '</div>'; $day=$d;echo '<section class="confcore-schedule-day"><h2>'.esc_html($day?:'برنامه همایش').'</h2><div class="grid grid-2">';}
      echo '<article class="card confcore-session"><div class="confcore-session-time">'.esc_html(trim($start.($end?' تا '.$end:''))).'</div><h3>'.esc_html(get_the_title()).'</h3><div>'.wp_kses_post(get_the_excerpt()).'</div>';
      if($speaker)echo '<p><strong>سخنران:</strong> '.esc_html($speaker).'</p>';if($room)echo '<p><strong>محل برگزاری:</strong> '.esc_html($room).'</p>';echo '</article>';
    }
    if($day!=='')echo '</div></section>';wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function session_meta_box(){
    add_meta_box('confcore_session_details','جزئیات زمان‌بندی جلسه',array($this,'render_session_meta_box'),'conf_session','normal','high');
  }
  public function render_session_meta_box($post){
    wp_nonce_field('confcore_session_meta','confcore_session_nonce');
    $fields=array('_conf_session_day'=>'روز همایش','_conf_session_start'=>'ساعت شروع','_conf_session_end'=>'ساعت پایان','_conf_session_room'=>'سالن / محل','_conf_session_speaker'=>'سخنران');
    foreach($fields as $key=>$label){$value=get_post_meta($post->ID,$key,true);echo '<p><label style="display:block;font-weight:600;margin-bottom:5px">'.esc_html($label).'</label><input class="widefat" type="text" name="'.esc_attr($key).'" value="'.esc_attr($value).'" /></p>';}
  }
  public function save_session_meta($post_id){
    if(!isset($_POST['confcore_session_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['confcore_session_nonce'])),'confcore_session_meta'))return;
    if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;if(!current_user_can('edit_post',$post_id))return;
    foreach(array('_conf_session_day','_conf_session_start','_conf_session_end','_conf_session_room','_conf_session_speaker') as $key){if(isset($_POST[$key]))update_post_meta($post_id,$key,sanitize_text_field(wp_unslash($_POST[$key])));}
  }
  public function team_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_committee','posts_per_page'=>40,'orderby'=>'menu_order title','order'=>'ASC'));
    if(!$q->have_posts())return '<p>اعضای تیم برگزارکننده را از پیشخوان اضافه کنید.</p>';
    ob_start();echo '<div class="grid grid-3">';while($q->have_posts()){$q->the_post();$role=get_post_meta(get_the_ID(),'_conf_committee_role',true);echo '<article class="card">';if(has_post_thumbnail())the_post_thumbnail('medium');echo '<h3>'.esc_html(get_the_title()).'</h3>';if($role)echo '<p class="confcore-speaker-role">'.esc_html($role).'</p>';echo '<div>'.wp_kses_post(get_the_excerpt()).'</div></article>';}wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function news_shortcode(){
    $q=new WP_Query(array('post_type'=>'post','posts_per_page'=>12));
    if(!$q->have_posts())return '<p>هنوز اطلاعیه‌ای منتشر نشده است.</p>';
    ob_start();echo '<div class="grid grid-3">';while($q->have_posts()){$q->the_post();echo '<article class="card"><h3><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a></h3><p>'.esc_html(get_the_excerpt()).'</p></article>';}wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function event_registration_shortcode(){
    $this->form_script();
    if(!is_user_logged_in())return '<p>برای ثبت‌نام در همایش ابتدا <a href="'.esc_url(home_url('/login/')).'">وارد حساب کاربری</a> شوید.</p>';
    $user=wp_get_current_user();$phone=get_user_meta($user->ID,'conference_phone',true);
    $existing=get_posts(array('post_type'=>'conf_registration','author'=>$user->ID,'posts_per_page'=>1,'post_status'=>array('pending','publish','draft','private')));
    if($existing){$reg=$existing[0];$status=$reg->post_status==='pending'?'در انتظار تأیید':($reg->post_status==='publish'?'تأیید شده':'نیازمند پیگیری');return '<div class="card confcore-form"><h2>وضعیت ثبت‌نام همایش</h2><p>وضعیت: <strong>'.esc_html($status).'</strong></p><p>نام: '.esc_html(get_post_meta($reg->ID,'_conf_reg_name',true)).'</p><p>سازمان: '.esc_html(get_post_meta($reg->ID,'_conf_reg_org',true)).'</p><p>شماره موبایل: '.esc_html($phone).'</p></div>';}
    return '<div class="card confcore-form"><h2>ثبت‌نام در همایش</h2><p>این فرم فقط درخواست حضور را ثبت می‌کند؛ هیچ نوع ثبت‌نام پولی یا انتخاب نوع ثبت‌نامی وجود ندارد.</p><form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="confcore_event_registration">'.wp_nonce_field('confcore_event_registration','confcore_event_registration_nonce',true,false).'<label>نام و نام خانوادگی</label><input name="reg_name" maxlength="120" value="'.esc_attr($user->display_name).'" required><label>دانشگاه یا سازمان</label><input name="reg_org" maxlength="180"><label>شماره موبایل تأییدشده</label><input value="'.esc_attr($phone).'" readonly><button class="btn btn-primary" type="submit">ثبت درخواست حضور</button></form></div>';
  }
  public function save_event_registration(){
    if(!is_user_logged_in())wp_die('ابتدا وارد حساب کاربری شوید.',403);
    if(!isset($_POST['confcore_event_registration_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['confcore_event_registration_nonce'])),'confcore_event_registration'))wp_die('درخواست نامعتبر است.',403);
    $user=wp_get_current_user();$phone=get_user_meta($user->ID,'conference_phone',true);$name=sanitize_text_field(wp_unslash($_POST['reg_name']??''));$org=sanitize_text_field(wp_unslash($_POST['reg_org']??''));
    if(!$phone || !$name)wp_die('اطلاعات ثبت‌نام کامل نیست.',400);
    $existing=get_posts(array('post_type'=>'conf_registration','author'=>$user->ID,'posts_per_page'=>1,'post_status'=>array('pending','publish','draft','private')));
    if($existing)wp_die('برای حساب شما قبلاً درخواست ثبت‌نام ثبت شده است.',409);
    $id=wp_insert_post(array('post_type'=>'conf_registration','post_status'=>'pending','post_title'=>'ثبت‌نام همایش - '.$name,'post_author'=>$user->ID),true);
    if(is_wp_error($id))wp_die('ثبت درخواست انجام نشد.',500);
    update_post_meta($id,'_conf_reg_name',$name);update_post_meta($id,'_conf_reg_org',$org);update_post_meta($id,'_conf_reg_phone',$phone);
    $this->send_registration_sms($id,'درخواست ثبت شد');
    wp_safe_redirect(home_url('/event-registration/?registered=1'));exit;
  }
  private function send_registration_sms($id,$token){
    $phone=get_post_meta($id,'_conf_reg_phone',true);$api=defined('CONFERENCE_KAVENEGAR_API_KEY')?CONFERENCE_KAVENEGAR_API_KEY:get_option('confcore_kavenegar_key','');$template=get_option('confcore_kavenegar_registration_template','');
    if(!$phone || !$api || !$template)return false;
    $url='https://api.kavenegar.com/v1/'.rawurlencode($api).'/verify/lookup.json';
    $response=wp_remote_post($url,array('timeout'=>15,'redirection'=>0,'body'=>array('receptor'=>$phone,'token'=>$token,'token2'=>(string)$id,'template'=>$template,'type'=>'sms')));
    return !is_wp_error($response) && wp_remote_retrieve_response_code($response)===200;
  }
  public function contact_shortcode(){
    $this->form_script();
    $notice=isset($_GET['contact']) && sanitize_key(wp_unslash($_GET['contact']))==='sent'?'<p class="confcore-message">پیام شما ثبت شد. از طریق شماره موبایل با شما تماس گرفته خواهد شد.</p>':'';
    return $notice.'<div class="card confcore-form"><h2>ارسال پیام به دبیرخانه</h2><form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="confcore_contact">'.wp_nonce_field('confcore_contact','confcore_contact_nonce',true,false).'<label>نام و نام خانوادگی</label><input name="contact_name" maxlength="120" required><label>شماره موبایل</label><input name="contact_phone" type="tel" inputmode="numeric" placeholder="09123456789" required><label>موضوع</label><input name="contact_subject" maxlength="160" required><label>متن پیام</label><textarea name="contact_message" rows="5" maxlength="4000" required></textarea><button class="btn btn-primary" type="submit">ثبت پیام</button></form></div>';
  }
  public function save_contact(){
    if(!isset($_POST['confcore_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['confcore_contact_nonce'])),'confcore_contact'))wp_die('درخواست نامعتبر است.',403);
    $ip=isset($_SERVER['REMOTE_ADDR'])?sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])):'unknown';
    if($this->rate_limited('conf_contact_ip_'.md5($ip),5,3600))wp_die('تعداد پیام‌های مجاز در بازه زمانی به پایان رسیده است.',429);
    $name=sanitize_text_field(wp_unslash($_POST['contact_name']??''));$phone=$this->normalize_phone(wp_unslash($_POST['contact_phone']??''));$subject=sanitize_text_field(wp_unslash($_POST['contact_subject']??''));$message=sanitize_textarea_field(wp_unslash($_POST['contact_message']??''));
    if(!$name || !$phone || !$subject || !$message)wp_die('لطفاً همه فیلدها را صحیح تکمیل کنید.',400);
    $id=wp_insert_post(array('post_type'=>'conf_message','post_status'=>'private','post_title'=>$subject.' - '.$name,'post_content'=>$message,'post_author'=>get_current_user_id()),true);
    if(is_wp_error($id))wp_die('ثبت پیام انجام نشد.',500);
    update_post_meta($id,'_conf_contact_name',$name);update_post_meta($id,'_conf_contact_phone',$phone);
    $back=wp_get_referer();wp_safe_redirect(add_query_arg('contact','sent',$back?:home_url('/contact/')));exit;
  }
  public function contact_meta_box(){
    add_meta_box('confcore_contact_phone','اطلاعات تماس',function($post){
      echo '<p>شماره موبایل: <strong>'.esc_html(get_post_meta($post->ID,'_conf_contact_phone',true)).'</strong></p>';
      echo '<p>نام: '.esc_html(get_post_meta($post->ID,'_conf_contact_name',true)).'</p>';
    },'conf_message','side','high');
    add_meta_box('confcore_paper_assignment','تخصیص داور مقاله',function($post){
      wp_nonce_field('confcore_assign_reviewer','confcore_reviewer_nonce');
      $assigned=(int)get_post_meta($post->ID,'_conf_assigned_reviewer',true);
      $reviewers=get_users(array('role'=>'conference_reviewer','fields'=>array('ID','display_name')));
      echo '<p><label for="confcore_assigned_reviewer">داور مسئول</label><select id="confcore_assigned_reviewer" name="confcore_assigned_reviewer" style="width:100%"><option value="0">بدون تخصیص</option>';
      foreach($reviewers as $reviewer)echo '<option value="'.esc_attr($reviewer->ID).'" '.selected($assigned,$reviewer->ID,false).'>'.esc_html($reviewer->display_name).'</option>';
      echo '</select></p>';
    },'conf_paper','side','high');
    add_meta_box('confcore_registration_details','اطلاعات ثبت‌نام',function($post){
      echo '<p>نام: '.esc_html(get_post_meta($post->ID,'_conf_reg_name',true)).'</p>';
      echo '<p>شماره موبایل: '.esc_html(get_post_meta($post->ID,'_conf_reg_phone',true)).'</p>';
      echo '<p>دانشگاه/سازمان: '.esc_html(get_post_meta($post->ID,'_conf_reg_org',true)).'</p>';
    },'conf_registration','side','high');
  }
  public function save_paper_assignment($post_id){
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)return;
    if(wp_is_post_revision($post_id) || !current_user_can('edit_post',$post_id))return;
    if(!isset($_POST['confcore_reviewer_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['confcore_reviewer_nonce'])),'confcore_assign_reviewer'))return;
    $reviewer=absint($_POST['confcore_assigned_reviewer']??0);
    if($reviewer){$user=get_user_by('id',$reviewer);if(!$user || !in_array('conference_reviewer',(array)$user->roles,true))$reviewer=0;}
    if($reviewer)update_post_meta($post_id,'_conf_assigned_reviewer',$reviewer);else delete_post_meta($post_id,'_conf_assigned_reviewer');
  }
  public function reviewer_dashboard_shortcode(){
    if(!is_user_logged_in() || !current_user_can('review_conference_papers'))return '<div class="card"><p>این بخش فقط برای داوران و مدیران قابل دسترسی است.</p><a href="'.esc_url(home_url('/login/')).'">ورود به سامانه</a></div>';
    $args=array('post_type'=>'conf_paper','post_status'=>'pending','posts_per_page'=>100);
    if(!current_user_can('manage_conference') && !current_user_can('manage_options')){$args['meta_key']='_conf_assigned_reviewer';$args['meta_value']=get_current_user_id();}
    $queue=get_posts($args);
    $reviewed=get_posts(array('post_type'=>'conf_paper','post_status'=>array('publish','draft'),'posts_per_page'=>100,'meta_key'=>'_conf_reviewed_by','meta_value'=>get_current_user_id()));
    ob_start(); ?>
    <div class="admin-layout confcore-workspace"><aside class="admin-sidebar"><h3>پنل داوری</h3><nav class="admin-nav"><a href="<?php echo esc_url(home_url('/reviewer-dashboard/')); ?>">داشبورد داور</a><a href="<?php echo esc_url(home_url('/review-queue/')); ?>">صف داوری</a><a href="<?php echo esc_url(home_url('/my-reviews/')); ?>">تاریخچه داوری</a><a href="<?php echo esc_url(home_url('/dashboard/')); ?>">پنل کاربری</a><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج</a></nav></aside><section class="admin-main"><div class="admin-page-heading"><div><h1>پنل داوری مقالات</h1><p>فقط مقاله‌های تخصیص‌یافته به حساب شما در این بخش نمایش داده می‌شوند.</p></div></div><div class="stats-grid"><div class="stat-card"><div class="stat-card-info"><h3><?php echo esc_html(count($queue)); ?></h3><p>در صف داوری</p></div></div><div class="stat-card"><div class="stat-card-info"><h3><?php echo esc_html(count($reviewed)); ?></h3><p>داوری ثبت‌شده</p></div></div></div><?php echo do_shortcode('[conference_review_queue]'); ?></section></div>
    <?php return ob_get_clean();
  }
  public function review_paper_shortcode(){
    if(!is_user_logged_in() || !current_user_can('review_conference_papers'))return '<div class="card"><p>برای داوری مقاله باید با حساب داور وارد شوید.</p></div>';
    $id=isset($_GET['paper_id'])?absint($_GET['paper_id']):(isset($_GET['paper'])?absint($_GET['paper']):0);
    $paper=$id?get_post($id):false;
    if(!$paper || $paper->post_type!=='conf_paper')return '<div class="card"><p>مقاله موردنظر پیدا نشد. از صف داوری یک مقاله را انتخاب کنید.</p><a href="'.esc_url(home_url('/review-queue/')).'">بازگشت به صف داوری</a></div>';
    if(!current_user_can('manage_conference') && !current_user_can('manage_options') && (int)get_post_meta($id,'_conf_assigned_reviewer',true)!==get_current_user_id())return '<div class="card"><p>این مقاله به شما تخصیص داده نشده است.</p></div>';
    $download=wp_nonce_url(admin_url('admin-post.php?action=confcore_download&paper='.$id),'confcore_download_'.$id);
    ob_start(); ?>
    <div class="card confcore-review-paper"><div class="admin-page-heading"><div><span class="admin-breadcrumb">داوری / مقاله #<?php echo esc_html($id); ?></span><h1><?php echo esc_html(get_the_title($paper)); ?></h1><p>وضعیت فعلی: <?php echo esc_html($paper->post_status==='pending'?'در انتظار داوری':$paper->post_status); ?></p></div></div><p><a class="btn btn-outline" href="<?php echo esc_url($download); ?>">دریافت امن فایل مقاله</a></p><div class="confcore-paper-details"><?php $abstract=get_post_meta($id,'_conf_paper_abstract',true);$keywords=get_post_meta($id,'_conf_paper_keywords',true);$track=get_post_meta($id,'_conf_paper_track',true);if($track): ?><p><strong>محور:</strong> <?php echo esc_html($track); ?></p><?php endif; ?><?php if($keywords): ?><p><strong>کلیدواژه‌ها:</strong> <?php echo esc_html($keywords); ?></p><?php endif; ?><?php if($abstract): ?><h2>چکیده</h2><p><?php echo nl2br(esc_html($abstract)); ?></p><?php endif; ?></div><?php $note=get_post_meta($id,'_conf_review_note',true);if($note): ?><div class="card"><strong>یادداشت قبلی:</strong><p><?php echo esc_html($note); ?></p></div><?php endif; ?><?php if($paper->post_status==='pending'): ?><label for="confcore-review-note">یادداشت داوری</label><textarea id="confcore-review-note" class="confcore-review-note" rows="5" maxlength="5000" placeholder="نکات اصلاحی یا توضیحات داوری"></textarea><p><button type="button" class="btn btn-primary" data-paper-decision="<?php echo esc_attr($id); ?>" data-decision="accept">پذیرش مقاله</button> <button type="button" class="btn btn-outline" data-paper-decision="<?php echo esc_attr($id); ?>" data-decision="reject">نیازمند اصلاح</button></p><?php else: ?><p>این مقاله قبلاً تعیین تکلیف شده است.</p><?php endif; ?><a href="<?php echo esc_url(home_url('/review-queue/')); ?>">بازگشت به صف داوری</a></div>
    <?php return ob_get_clean();
  }
  public function admin_workspace_shortcode($atts){
    if(!current_user_can('manage_conference') && !current_user_can('manage_options'))return '<div class="card"><p>شما اجازه دسترسی به مرکز مدیریت همایش را ندارید.</p><a href="'.esc_url(home_url('/login/')).'">ورود به سامانه</a></div>';
    $atts=shortcode_atts(array('section'=>'dashboard'),$atts,'conference_admin_workspace');
    $section=sanitize_key($atts['section']);
    $sections=array('dashboard'=>'مرکز مدیریت','users'=>'کاربران','papers'=>'مقالات','registrations'=>'ثبت‌نام‌ها','reviews'=>'داوری‌ها','reviewers'=>'داوران','settings'=>'تنظیمات','sms'=>'تنظیمات پیامک','team'=>'تیم و کمیته‌ها','posts'=>'نوشته‌ها');
    if(!isset($sections[$section]))$section='dashboard';
    $counts=array('papers'=>wp_count_posts('conf_paper'),'registrations'=>wp_count_posts('conf_registration'),'speakers'=>wp_count_posts('conf_speaker'),'sessions'=>wp_count_posts('conf_session'));
    $total=function($o){$n=0;foreach((array)$o as $v)$n+=(int)$v;return $n;};
    $links=array('dashboard'=>'admin-dashboard','users'=>'admin-users','papers'=>'admin-papers','registrations'=>'admin-registrations','reviews'=>'admin-reviews','reviewers'=>'admin-reviewers','settings'=>'admin-settings','sms'=>'admin-sms','team'=>'admin-team','posts'=>'admin-posts');
    ob_start(); ?>
    <div class="admin-layout confcore-workspace"><aside class="admin-sidebar"><h3>مرکز مدیریت</h3><nav class="admin-nav"><?php foreach($sections as $key=>$label): ?><a class="<?php echo $section===$key?'is-active':''; ?>" href="<?php echo esc_url(home_url('/'.$links[$key].'/')); ?>"><?php echo esc_html($label); ?></a><?php endforeach; ?><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج</a></nav></aside><section class="admin-main"><div class="admin-page-heading"><div><div class="admin-breadcrumb">مدیریت همایش / <?php echo esc_html($sections[$section]); ?></div><h1><?php echo esc_html($sections[$section]); ?></h1><p>اطلاعات این صفحه مستقیماً از پایگاه داده وردپرس خوانده می‌شود.</p></div></div>
    <?php if($section==='dashboard'): ?>
      <div class="stats-grid"><?php foreach(array('papers'=>'مقالات','registrations'=>'ثبت‌نام‌ها','speakers'=>'سخنرانان','sessions'=>'جلسات') as $key=>$label): ?><div class="stat-card"><div class="stat-card-info"><h3><?php echo esc_html(number_format_i18n($total($counts[$key]))); ?></h3><p><?php echo esc_html($label); ?></p></div></div><?php endforeach; ?></div>
      <div class="grid grid-2"><?php foreach(array('papers'=>'مدیریت مقالات','registrations'=>'ثبت‌نام شرکت‌کنندگان','users'=>'مدیریت کاربران','reviewers'=>'مدیریت داوران','reviews'=>'نتایج داوری','team'=>'تیم و کمیته‌ها','posts'=>'اخبار و نوشته‌ها','settings'=>'تنظیمات ظاهر و صفحات','sms'=>'تنظیمات پیامک') as $key=>$label): ?><a class="card" href="<?php echo esc_url(home_url('/'.$links[$key].'/')); ?>"><h3><?php echo esc_html($label); ?> ←</h3><p>مشاهده و مدیریت اطلاعات</p></a><?php endforeach; ?></div>
    <?php elseif($section==='settings'): ?>
      <div class="grid grid-2"><a class="card" href="<?php echo esc_url(admin_url('customize.php')); ?>"><h3>سفارشی‌سازی ظاهر</h3><p>اسلایدر، رنگ، آمار و اطلاعات همایش</p></a><a class="card" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"><h3>فهرست‌های سایت</h3><p>ویرایش منوی اصلی و فوتر</p></a><a class="card" href="<?php echo esc_url(admin_url('widgets.php')); ?>"><h3>ابزارک‌ها</h3><p>مدیریت ستون‌های فوتر و صفحه اصلی</p></a><a class="card" href="<?php echo esc_url(admin_url('edit.php?post_type=page')); ?>"><h3>برگه‌ها و مسیرها</h3><p>ویرایش محتوای صفحات و نامک‌ها</p></a></div>
    <?php elseif($section==='sms'): ?>
      <div class="card"><h2>درگاه پیامک</h2><p>کلید خصوصی و نام قالب‌های تأییدشده باید در بخش امن مدیریت تنظیم شوند.</p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('admin.php?page=confcore-settings')); ?>">باز کردن تنظیمات پیامک</a></div>
    <?php elseif($section==='users'): ?>
      <?php $items=get_users(array('number'=>100,'orderby'=>'registered','order'=>'DESC')); ?><div class="card"><h2>کاربران سایت</h2><?php if(current_user_can('create_users')): ?><p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('user-new.php')); ?>">افزودن کاربر / تعیین نقش</a></p><?php else: ?><p>نمایش کاربران برای مدیر همایش فعال است؛ تغییر نقش و ساخت کاربر فقط توسط مدیرکل وردپرس انجام می‌شود.</p><?php endif; ?><div class="table-wrapper"><table><thead><tr><th>کاربر</th><th>موبایل</th><th>نقش</th><th>مدیریت</th></tr></thead><tbody><?php foreach($items as $u): ?><tr><td><?php echo esc_html($u->display_name); ?></td><td><?php echo esc_html(get_user_meta($u->ID,'conference_phone',true)); ?></td><td><?php echo esc_html(implode(', ',(array)$u->roles)); ?></td><td><?php if(current_user_can('edit_users')): ?><a href="<?php echo esc_url(get_edit_user_link($u->ID)); ?>">ویرایش نقش و مشخصات</a><?php else: ?>فقط مدیرکل<?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div></div>
    <?php elseif($section==='papers'): ?>
      <?php $items=get_posts(array('post_type'=>'conf_paper','post_status'=>array('pending','publish','draft','private'),'posts_per_page'=>100)); ?><div class="card"><h2>مقالات ارسالی</h2><div class="table-wrapper"><table><thead><tr><th>عنوان</th><th>نویسنده</th><th>وضعیت</th><th>داور</th><th>مدیریت</th></tr></thead><tbody><?php foreach($items as $p): $reviewer=get_user_by('id',(int)get_post_meta($p->ID,'_conf_assigned_reviewer',true)); ?><tr><td><?php echo esc_html($p->post_title); ?></td><td><?php echo esc_html(get_the_author_meta('display_name',$p->post_author)); ?></td><td><?php echo esc_html($p->post_status); ?></td><td><?php echo esc_html($reviewer?$reviewer->display_name:'تخصیص نیافته'); ?></td><td><a href="<?php echo esc_url(get_edit_post_link($p->ID)); ?>">تخصیص داور / ویرایش</a></td></tr><?php endforeach; ?></tbody></table></div></div>
    <?php elseif($section==='registrations'): ?>
      <?php $items=get_posts(array('post_type'=>'conf_registration','post_status'=>array('pending','publish','draft','private'),'posts_per_page'=>100)); ?><div class="card"><h2>درخواست‌های حضور</h2><div class="table-wrapper"><table><thead><tr><th>نام</th><th>موبایل</th><th>سازمان</th><th>وضعیت</th><th>مدیریت</th></tr></thead><tbody><?php foreach($items as $p): ?><tr><td><?php echo esc_html(get_post_meta($p->ID,'_conf_reg_name',true)); ?></td><td><?php echo esc_html(get_post_meta($p->ID,'_conf_reg_phone',true)); ?></td><td><?php echo esc_html(get_post_meta($p->ID,'_conf_reg_org',true)); ?></td><td><?php echo esc_html($p->post_status); ?></td><td><a href="<?php echo esc_url(get_edit_post_link($p->ID)); ?>">مشاهده</a></td></tr><?php endforeach; ?></tbody></table></div></div>
    <?php elseif($section==='reviewers'): ?>
      <?php $items=get_users(array('role'=>'conference_reviewer','number'=>100)); ?><div class="card"><h2>داوران</h2><?php if(current_user_can('create_users')): ?><p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('user-new.php')); ?>">افزودن داور</a></p><?php endif; ?><div class="table-wrapper"><table><thead><tr><th>نام</th><th>موبایل</th><th>مقالات تخصیص‌یافته</th><th>مدیریت</th></tr></thead><tbody><?php foreach($items as $u): $assigned=get_posts(array('post_type'=>'conf_paper','post_status'=>'any','posts_per_page'=>-1,'meta_key'=>'_conf_assigned_reviewer','meta_value'=>$u->ID,'fields'=>'ids')); ?><tr><td><?php echo esc_html($u->display_name); ?></td><td><?php echo esc_html(get_user_meta($u->ID,'conference_phone',true)); ?></td><td><?php echo esc_html(count($assigned)); ?></td><td><?php if(current_user_can('edit_users')): ?><a href="<?php echo esc_url(get_edit_user_link($u->ID)); ?>">ویرایش</a><?php else: ?>فقط مدیرکل<?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div></div>
    <?php elseif($section==='reviews'): ?>
      <?php $items=get_posts(array('post_type'=>'conf_paper','post_status'=>array('publish','draft'),'posts_per_page'=>100,'meta_key'=>'_conf_reviewed_by','meta_compare'=>'EXISTS')); ?><div class="card"><h2>نتایج ثبت‌شده</h2><div class="table-wrapper"><table><thead><tr><th>مقاله</th><th>نتیجه</th><th>داور</th><th>یادداشت</th></tr></thead><tbody><?php foreach($items as $p): $u=get_user_by('id',(int)get_post_meta($p->ID,'_conf_reviewed_by',true)); ?><tr><td><?php echo esc_html($p->post_title); ?></td><td><?php echo esc_html($p->post_status==='publish'?'پذیرفته':'نیازمند اصلاح'); ?></td><td><?php echo esc_html($u?$u->display_name:'—'); ?></td><td><?php echo esc_html(get_post_meta($p->ID,'_conf_review_note',true)); ?></td></tr><?php endforeach; ?></tbody></table></div></div>
    <?php elseif($section==='team'): ?>
      <div class="grid grid-2"><?php foreach(array('conf_speaker'=>'سخنرانان','conf_session'=>'برنامه همایش','conf_committee'=>'تیم و کمیته‌ها') as $type=>$label): ?><a class="card" href="<?php echo esc_url(admin_url('edit.php?post_type='.$type)); ?>"><h3><?php echo esc_html($label); ?></h3><p>مدیریت محتوا و جزئیات</p></a><?php endforeach; ?></div>
    <?php elseif($section==='posts'): ?>
      <?php $items=get_posts(array('post_type'=>'post','post_status'=>array('publish','draft','pending'),'posts_per_page'=>100)); ?><div class="card"><h2>نوشته‌ها و اطلاعیه‌ها</h2><p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('post-new.php')); ?>">افزودن نوشته</a></p><div class="table-wrapper"><table><thead><tr><th>عنوان</th><th>تاریخ</th><th>وضعیت</th><th>مدیریت</th></tr></thead><tbody><?php foreach($items as $p): ?><tr><td><?php echo esc_html($p->post_title); ?></td><td><?php echo esc_html(get_the_date('', $p)); ?></td><td><?php echo esc_html($p->post_status); ?></td><td><a href="<?php echo esc_url(get_edit_post_link($p->ID)); ?>">ویرایش</a></td></tr><?php endforeach; ?></tbody></table></div></div>
    <?php endif; ?></section></div>
    <?php return ob_get_clean();
  }
  public function admin_menu(){
    add_menu_page('سامانه همایش','سامانه همایش','manage_conference','confcore',array($this,'admin_page'),'dashicons-groups',26);
    add_submenu_page('confcore','تنظیمات پیامک','تنظیمات پیامک','manage_options','confcore-settings',array($this,'settings_page'));
    add_submenu_page('confcore','ابزارها و داده نمونه','ابزارها','manage_options','confcore-tools',array($this,'tools_page'));
  }
  public function sanitize_api_key($value){$value=sanitize_text_field($value);return $value!==''?$value:get_option('confcore_kavenegar_key','');}
  public function settings(){
    register_setting('confcore_settings','confcore_kavenegar_key',array('sanitize_callback'=>array($this,'sanitize_api_key')));
    register_setting('confcore_settings','confcore_kavenegar_template',array('sanitize_callback'=>'sanitize_text_field'));
    register_setting('confcore_settings','confcore_kavenegar_sender',array('sanitize_callback'=>'sanitize_text_field'));
    register_setting('confcore_settings','confcore_kavenegar_result_template',array('sanitize_callback'=>'sanitize_text_field'));
    register_setting('confcore_settings','confcore_kavenegar_submission_template',array('sanitize_callback'=>'sanitize_text_field'));
    register_setting('confcore_settings','confcore_kavenegar_registration_template',array('sanitize_callback'=>'sanitize_text_field'));
  }
  public function admin_page(){
    if(!current_user_can('manage_conference'))return;
    $counts=array('مقالات دریافت‌شده'=>wp_count_posts('conf_paper'),'ثبت‌نام شرکت‌کنندگان'=>wp_count_posts('conf_registration'),'سخنرانان'=>wp_count_posts('conf_speaker'),'جلسه‌های برنامه'=>wp_count_posts('conf_session'));
    echo '<div class="wrap"><h1>مرکز مدیریت همایش</h1><p>آمار زیر مستقیماً از محتوای ثبت‌شده در وردپرس محاسبه می‌شود؛ هیچ عدد نمایشی یا ثابت در داشبورد استفاده نشده است.</p><div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin:22px 0">';
    foreach($counts as $label=>$status){$total=0;if($status)foreach((array)$status as $n)$total+=(int)$n;echo '<div style="background:#fff;border:1px solid #dcdcde;border-radius:10px;padding:18px"><strong style="display:block;color:#123d38;font-size:28px">'.esc_html(number_format_i18n($total)).'</strong><span>'.esc_html($label).'</span></div>';}
    echo '</div><h2>مدیریت بخش‌ها</h2><p>';
    $links=array('مدیریت مقالات'=>admin_url('edit.php?post_type=conf_paper'),'ثبت‌نام‌ها'=>admin_url('edit.php?post_type=conf_registration'),'پیام‌های تماس'=>admin_url('edit.php?post_type=conf_message'),'گواهی‌ها'=>admin_url('edit.php?post_type=conf_certificate'),'کاربران و نقش‌ها'=>admin_url('users.php'),'سخنرانان'=>admin_url('edit.php?post_type=conf_speaker'),'برنامه و زمان‌بندی'=>admin_url('edit.php?post_type=conf_session'),'تیم و کمیته‌ها'=>admin_url('edit.php?post_type=conf_committee'),'اخبار'=>admin_url('edit.php?post_type=post'),'برگه‌ها و صفحات'=>admin_url('edit.php?post_type=page'));
    foreach($links as $label=>$url)echo '<a class="button button-primary" style="margin:4px" href="'.esc_url($url).'">'.esc_html($label).'</a>';
    echo '</p><p>تنظیمات پیامک و ورود یک‌بارمصرف در «تنظیمات پیامک» است. تنظیم محتوای صفحه اصلی، اسلایدر، آمار، رنگ و اطلاعات تماس در نمایش ← سفارشی‌سازی انجام می‌شود.</p></div>';
  }
  public function settings_page(){if(!current_user_can('manage_options'))return; ?><div class="wrap"><h1>تنظیمات پیامک همایش</h1><p>از Kavenegar VerifyLookup استفاده کنید. API Key در مرورگر یا کد جاوااسکریپت قرار نمی‌گیرد.</p><form method="post" action="options.php"><?php settings_fields('confcore_settings'); ?><table class="form-table"><tr><th>API Key</th><td><input type="password" autocomplete="new-password" name="confcore_kavenegar_key" value="" placeholder="کلید فعلی محفوظ است؛ برای تغییر کلید جدید وارد کنید" class="regular-text" <?php disabled(defined('CONFERENCE_KAVENEGAR_API_KEY')); ?>><p class="description"><?php echo defined('CONFERENCE_KAVENEGAR_API_KEY')?'کلید از wp-config.php خوانده می‌شود.':'کلید را از پنل کاوه‌نگار وارد کنید یا در wp-config.php ثابت CONFERENCE_KAVENEGAR_API_KEY تعریف کنید.'; ?></p></td></tr><tr><th>نام قالب VerifyLookup</th><td><input name="confcore_kavenegar_template" value="<?php echo esc_attr(get_option('confcore_kavenegar_template','')); ?>" class="regular-text"></td></tr><tr><th>شماره فرستنده (اختیاری)</th><td><input name="confcore_kavenegar_sender" value="<?php echo esc_attr(get_option('confcore_kavenegar_sender','')); ?>" class="regular-text"></td></tr><tr><th>قالب پیامک نتیجه داوری</th><td><input name="confcore_kavenegar_result_template" value="<?php echo esc_attr(get_option('confcore_kavenegar_result_template','')); ?>" class="regular-text"><p class="description">قالب جداگانه VerifyLookup؛ متغیر token وضعیت و token2 شناسه مقاله است.</p></td></tr><tr><th>قالب پیامک ثبت مقاله</th><td><input name="confcore_kavenegar_submission_template" value="<?php echo esc_attr(get_option('confcore_kavenegar_submission_template','')); ?>" class="regular-text"><p class="description">قالب VerifyLookup جداگانه؛ token متن «ثبت شد» و token2 شناسه مقاله است.</p></td></tr><tr><th>قالب پیامک ثبت‌نام شرکت‌کننده</th><td><input name="confcore_kavenegar_registration_template" value="<?php echo esc_attr(get_option('confcore_kavenegar_registration_template','')); ?>" class="regular-text"><p class="description">قالب VerifyLookup؛ token متن وضعیت و token2 شناسه ثبت‌نام است.</p></td></tr></table><?php submit_button('ذخیره تنظیمات'); ?></form></div><?php }
  public function tools_page(){
    if(!current_user_can('manage_options'))return;
    if(isset($_POST['confcore_seed']) && check_admin_referer('confcore_seed_demo')){$this->seed_demo();echo '<div class="notice notice-success"><p>محتوای نمونه ایجاد شد. اجرای دوباره، موارد تکراری را نادیده می‌گیرد.</p></div>';}
    ?><div class="wrap"><h1>ابزارها و داده آزمایشی</h1><p>این ابزار چند سخنران، جلسه، نوشته و برگه راهنما ایجاد می‌کند. حساب آزمایشی با رمز ثابت ساخته نمی‌شود.</p><form method="post"><?php wp_nonce_field('confcore_seed_demo'); ?><input type="hidden" name="confcore_seed" value="1"><?php submit_button('وارد کردن محتوای نمونه'); ?></form></div><?php
  }
  private function seed_demo(){
    $items=array(
      array('conf_speaker','دکتر نمونه محمدی','پژوهشگر هوش مصنوعی و یادگیری ماشین.'),
      array('conf_speaker','دکتر نمونه کریمی','متخصص داده‌کاوی و فناوری‌های سلامت.'),
      array('conf_session','افتتاحیه و سخنرانی کلیدی','آغاز همایش و معرفی محورهای علمی.'),
      array('conf_session','کارگاه پژوهش و نوآوری','کارگاه آموزشی ویژه پژوهشگران.'),
      array('conf_committee','دبیر علمی همایش','مسئولیت برنامه‌ریزی علمی و ارزیابی مقالات.'),
      array('conf_committee','کمیته اجرایی','هماهنگی اجرایی، ثبت‌نام و پشتیبانی شرکت‌کنندگان.')
    );
    foreach($items as $item){$exists=get_page_by_title($item[1],OBJECT,$item[0]);if(!$exists)wp_insert_post(array('post_type'=>$item[0],'post_status'=>'publish','post_title'=>$item[1],'post_content'=>$item[2],'post_excerpt'=>$item[2]));}
    if(!get_page_by_title('اطلاعیه نمونه همایش',OBJECT,'post'))wp_insert_post(array('post_type'=>'post','post_status'=>'publish','post_title'=>'اطلاعیه نمونه همایش','post_content'=>'این یک نوشته آزمایشی برای نمایش امکانات مدیریت نوشته‌هاست.'));
    self::create_default_pages();
  }
}
register_activation_hook(__FILE__,array('Conference_Core','activate'));
register_deactivation_hook(__FILE__,array('Conference_Core','deactivate'));
Conference_Core::instance();
