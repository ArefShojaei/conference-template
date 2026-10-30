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
    add_action('admin_menu',array($this,'admin_menu'));
    add_action('admin_init',array($this,'settings'));
    add_action('add_meta_boxes',array($this,'contact_meta_box'));
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
    flush_rewrite_rules();
  }
  public static function deactivate(){ flush_rewrite_rules(); }
  private static function create_default_pages(){
    $pages=array('ورود'=>'login','ثبت‌نام'=>'register','داشبورد'=>'dashboard','ارسال مقاله'=>'submit-paper','مقالات'=>'papers');
    foreach($pages as $title=>$slug){
      if(!get_page_by_path($slug)){
        $shortcode=$slug==='login'?'[conference_login]':($slug==='register'?'[conference_register]':($slug==='dashboard'?'[conference_dashboard]':($slug==='submit-paper'?'[conference_submit_paper]':'[conference_papers]')));
        wp_insert_post(array('post_title'=>$title,'post_name'=>$slug,'post_type'=>'page','post_status'=>'publish','post_content'=>$shortcode));
      }
    }
    // Create editable public information pages and connect dynamic listings/forms.
    $extra=array(
      'about'=>array('درباره همایش','معرفی رویداد، اهداف و محورهای علمی همایش را از ویرایشگر برگه مدیریت کنید.'),
      'contact'=>array('تماس با ما','[conference_contact]'),
      'faq'=>array('سوالات متداول','پاسخ پرسش‌های متداول را از ویرایشگر برگه اضافه کنید.'),
      'speakers'=>array('سخنرانان','[conference_speakers]'),
      'schedule'=>array('برنامه زمانی','[conference_schedule]'),
      'team'=>array('تیم برگزارکننده','[conference_team]'),
      'news'=>array('اخبار و اطلاعیه‌ها','[conference_news]'),
      'event-registration'=>array('ثبت‌نام در همایش','[conference_event_registration]'),
      'my-papers'=>array('مقالات من','[conference_my_papers]'),
      'my-registration'=>array('ثبت‌نام من','[conference_event_registration]'),
      'certificates'=>array('گواهی‌های من','[conference_certificates]'),
      'messages'=>array('پیام‌ها و اعلان‌ها','[conference_messages]'),
      'profile'=>array('پروفایل من','[conference_profile]'),
      'review-queue'=>array('صف داوری','[conference_review_queue]'),
      'my-reviews'=>array('داوری‌های من','[conference_my_reviews]'),
      'author-guidelines'=>array('راهنمای نویسندگان','راهنمای نگارش و ارسال مقاله را از ویرایشگر برگه تکمیل کنید.')
    );
    foreach($extra as $slug=>$item){if(!get_page_by_path($slug))wp_insert_post(array('post_type'=>'page','post_status'=>'publish','post_title'=>$item[0],'post_name'=>$slug,'post_content'=>$item[1]));}
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
    $user=$this->find_user_by_phone($phone);
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
    $user=get_user_by('login',$phone);
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
    $phone=$this->normalize_phone($request->get_param('phone')); $code=strtr((string)$request->get_param('code'),array('۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9','٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9')); $code=preg_replace('/[^0-9]/','',$code); $mode=sanitize_key($request->get_param('mode'));
    if(!$phone || !preg_match('/^[0-9]{6}$/',$code) || !in_array($mode,array('login','register'),true))return new WP_Error('invalid_input','اطلاعات واردشده معتبر نیست.',array('status'=>400));
    global $wpdb; $table=$wpdb->prefix.'confcore_otp'; $row=$wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE phone=%s",$phone));
    if(!$row || strtotime($row->expires_at.' UTC')<time())return new WP_Error('expired','کد منقضی شده است؛ دوباره درخواست دهید.',array('status'=>400));
    if((int)$row->attempts>=5){$wpdb->delete($table,array('phone'=>$phone),array('%s'));return new WP_Error('locked','تعداد تلاش مجاز تمام شده است.',array('status'=>429));}
    $hash=hash_hmac('sha256',$code,wp_salt('auth'));
    if(!hash_equals($row->code_hash,$hash)){ $wpdb->update($table,array('attempts'=>(int)$row->attempts+1),array('phone'=>$phone),array('%d'),array('%s'));return new WP_Error('wrong_code','کد تأیید اشتباه است.',array('status'=>400));}
    $user=get_user_by('login',$phone);
    if($mode==='register' && !$user){
      $user_id=wp_insert_user(array('user_login'=>$phone,'user_pass'=>wp_generate_password(48,true,true),'user_email'=>'','display_name'=>$phone,'role'=>'conference_author'));
      if(is_wp_error($user_id))return new WP_Error('register_failed','ساخت حساب کاربری انجام نشد.',array('status'=>500));
      update_user_meta($user_id,'conference_phone',$phone); $user=get_user_by('id',$user_id);
    }
    if(!$user)return new WP_Error('account_missing','حساب کاربری پیدا نشد.',array('status'=>404));
    $wpdb->delete($table,array('phone'=>$phone),array('%s'));
    wp_set_current_user($user->ID); wp_set_auth_cookie($user->ID,true,is_ssl()); do_action('wp_login',$user->user_login,$user);
    return rest_ensure_response(array('success'=>true,'message'=>'ورود با موفقیت انجام شد.','redirect'=>home_url('/dashboard/')));
  }
  public function upload_paper($request){
    if($this->rate_limited('conf_upload_user_'.get_current_user_id(),10,3600))return new WP_Error('upload_rate_limit','سقف ارسال فایل در این ساعت پر شده است.',array('status'=>429));
    if(empty($_FILES['paper']) || !isset($_FILES['paper']['tmp_name']))return new WP_Error('missing_file','فایل مقاله انتخاب نشده است.',array('status'=>400));
    $f=$_FILES['paper']; if((int)$f['error']!==UPLOAD_ERR_OK)return new WP_Error('upload_error','بارگذاری فایل با خطا مواجه شد.',array('status'=>400));
    if((int)$f['size']<1 || (int)$f['size']>20*1024*1024)return new WP_Error('file_size','حداکثر حجم فایل ۲۰ مگابایت است.',array('status'=>413));
    $name=sanitize_file_name($f['name']); $ext=strtolower(pathinfo($name,PATHINFO_EXTENSION));
    if(!in_array($ext,array('pdf','doc','docx'),true))return new WP_Error('file_type','فقط فایل PDF، DOC یا DOCX مجاز است.',array('status'=>415));
    $handle=fopen($f['tmp_name'],'rb'); $magic=$handle?fread($handle,8):''; if($handle)fclose($handle);
    $valid=($ext==='pdf' && strpos($magic,'%PDF-')===0) || ($ext==='doc' && substr($magic,0,8)==="\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1");
    if($ext==='docx' && class_exists('ZipArchive')){ $zip=new ZipArchive(); if($zip->open($f['tmp_name'])===true){$valid=$zip->locateName('[Content_Types].xml')!==false && $zip->locateName('word/document.xml')!==false;$zip->close();} }
    if(!$valid)return new WP_Error('file_signature','محتوای فایل با پسوند آن مطابقت ندارد یا فایل DOCX معتبر نیست.',array('status'=>415));
    $dir=wp_upload_dir(); $private=$dir['basedir'].'/conference-private';
    if(!wp_mkdir_p($private))return new WP_Error('storage_error','فضای ذخیره‌سازی آماده نیست.',array('status'=>500));
    @chmod($private,0700);
    $deny=file_put_contents($private.'/.htaccess',"Require all denied\n<IfModule !mod_authz_core.c> Deny from all </IfModule>\n");
    if($deny===false)return new WP_Error('storage_protection','امکان محافظت از پوشه فایل‌ها وجود ندارد.',array('status'=>500));
    if(!file_exists($private.'/index.php'))file_put_contents($private.'/index.php',"<?php http_response_code(404); exit;");
    $stored=wp_generate_password(24,false,false).'.'.$ext; $target=$private.'/'.$stored;
    if(!move_uploaded_file($f['tmp_name'],$target))return new WP_Error('storage_error','ذخیره فایل انجام نشد.',array('status'=>500));
    @chmod($target,0600);
    $title=sanitize_text_field($request->get_param('title')); if($title==='')$title=pathinfo($name,PATHINFO_FILENAME);
    $post_id=wp_insert_post(array('post_type'=>'conf_paper','post_status'=>'pending','post_title'=>$title,'post_author'=>get_current_user_id()),true);
    if(is_wp_error($post_id)){@unlink($target);return new WP_Error('save_error','ثبت اطلاعات مقاله ناموفق بود.',array('status'=>500));}
    update_post_meta($post_id,'_conf_private_path',$target); update_post_meta($post_id,'_conf_original_name',$name); update_post_meta($post_id,'_conf_file_size',(int)$f['size']);
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
    $private_base=realpath(wp_upload_dir()['basedir'].'/conference-private');$real_path=$path?realpath($path):false;
    if(!$private_base || !$real_path || strpos($real_path,$private_base.DIRECTORY_SEPARATOR)!==0 || !is_file($real_path))wp_die('فایل موجود نیست.',404);
    $path=$real_path;
    $ext=strtolower(pathinfo($path,PATHINFO_EXTENSION)); $mime=$ext==='pdf'?'application/pdf':($ext==='doc'?'application/msword':'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    nocache_headers(); header('X-Content-Type-Options: nosniff'); header('Content-Type: '.$mime); header('Content-Length: '.filesize($path)); header('Content-Disposition: attachment; filename="paper-'.$id.'.'.$ext.'"; filename*=UTF-8\'\''.rawurlencode(get_post_meta($id,'_conf_original_name',true))); readfile($path); exit;
  }
  public function assets(){
    wp_enqueue_style('confcore-front',plugins_url('assets/css/frontend.css',__FILE__),array(),CONFCORE_VERSION);
    wp_register_script('confcore-front',plugins_url('assets/js/frontend.js',__FILE__),array(),CONFCORE_VERSION,true);
    wp_localize_script('confcore-front','ConfCore',array('rest'=>esc_url_raw(rest_url('conference/v1/')),'nonce'=>wp_create_nonce('wp_rest'),'login'=>home_url('/login/'),'dashboard'=>home_url('/dashboard/')));
  }
  private function form_script(){wp_enqueue_script('confcore-front');}
  private function auth_form($mode){
    if(is_user_logged_in())return '<p>شما وارد شده‌اید. <a href="'.esc_url(home_url('/dashboard/')).'">رفتن به پنل</a></p>';
    $this->form_script(); ob_start(); ?>
    <div class="card confcore-form"><h2><?php echo $mode==='register'?'ثبت‌نام با شماره موبایل':'ورود با شماره موبایل'; ?></h2>
    <form class="confcore-otp-form" data-mode="<?php echo esc_attr($mode); ?>"><label>شماره موبایل</label><input type="tel" name="phone" inputmode="numeric" autocomplete="tel" placeholder="09123456789" required><button class="btn btn-primary" type="submit">دریافت کد تأیید</button><div class="confcore-otp-step" hidden><label>کد پیامک‌شده</label><input type="text" name="code" inputmode="numeric" maxlength="6" autocomplete="one-time-code"><button class="btn btn-primary" type="button" data-verify>تأیید و ادامه</button></div><p class="confcore-message" role="status"></p></form></div><?php return ob_get_clean();
  }
  public function login_shortcode(){return $this->auth_form('login');}
  public function register_shortcode(){return $this->auth_form('register');}
  public function submit_shortcode(){
    if(!is_user_logged_in())return '<p>برای ارسال مقاله ابتدا <a href="'.esc_url(home_url('/login/')).'">وارد شوید</a>.</p>';
    if(!current_user_can('submit_conference_papers'))return '<p>دسترسی ارسال مقاله برای حساب شما فعال نیست. با مدیر همایش تماس بگیرید.</p>';
    $this->form_script(); ob_start(); ?><div class="card confcore-form"><h2>ارسال مقاله</h2><form class="confcore-paper-form"><label>عنوان مقاله</label><input type="text" name="title" maxlength="180" required><label>فایل مقاله (PDF، DOC، DOCX - حداکثر ۲۰ مگابایت)</label><input type="file" name="paper" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required><button class="btn btn-primary" type="submit">ارسال برای بررسی</button><p class="confcore-message" role="status"></p></form></div><?php return ob_get_clean();
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
    foreach($items as $p){echo '<tr><td>'.esc_html($p->post_title).'</td><td>'.esc_html($p->ID).'</td><td><a href="'.esc_url(wp_nonce_url(admin_url('admin-post.php?action=confcore_download&paper='.$p->ID),'confcore_download_'.$p->ID)).'">دریافت فایل</a> <button type="button" data-paper-decision="'.esc_attr($p->ID).'" data-decision="accept">پذیرش</button> <button type="button" data-paper-decision="'.esc_attr($p->ID).'" data-decision="reject">بازگشت برای اصلاح</button></td></tr>';}
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
    ob_start(); echo '<div class="grid grid-2">'; while($q->have_posts()){$q->the_post();echo '<article class="card"><h3>'.esc_html(get_the_title()).'</h3></article>';} wp_reset_postdata(); echo '</div>'; return ob_get_clean();
  }
  public function speakers_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_speaker','posts_per_page'=>24));
    if(!$q->have_posts())return '<p>اطلاعات سخنرانان به‌زودی منتشر می‌شود.</p>';
    ob_start(); echo '<div class="grid grid-4">'; while($q->have_posts()){$q->the_post();echo '<article class="card speaker-card">';if(has_post_thumbnail())the_post_thumbnail('medium');echo '<h3>'.esc_html(get_the_title()).'</h3><div>'.wp_kses_post(get_the_excerpt()).'</div></article>';} wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function schedule_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_session','posts_per_page'=>50,'orderby'=>'menu_order date','order'=>'ASC'));
    if(!$q->have_posts())return '<p>برنامه همایش هنوز منتشر نشده است.</p>';
    ob_start();echo '<div class="grid grid-2">';while($q->have_posts()){$q->the_post();echo '<article class="card"><h3>'.esc_html(get_the_title()).'</h3><div>'.wp_kses_post(get_the_excerpt()).'</div></article>';}wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function team_shortcode(){
    $q=new WP_Query(array('post_type'=>'conf_committee','posts_per_page'=>40));
    if(!$q->have_posts())return '<p>اعضای تیم برگزارکننده را از پیشخوان اضافه کنید.</p>';
    ob_start();echo '<div class="grid grid-3">';while($q->have_posts()){$q->the_post();echo '<article class="card">';if(has_post_thumbnail())the_post_thumbnail('medium');echo '<h3>'.esc_html(get_the_title()).'</h3><div>'.wp_kses_post(get_the_excerpt()).'</div></article>';}wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function news_shortcode(){
    $q=new WP_Query(array('post_type'=>'post','posts_per_page'=>12));
    if(!$q->have_posts())return '<p>هنوز اطلاعیه‌ای منتشر نشده است.</p>';
    ob_start();echo '<div class="grid grid-3">';while($q->have_posts()){$q->the_post();echo '<article class="card"><h3><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a></h3><p>'.esc_html(get_the_excerpt()).'</p></article>';}wp_reset_postdata();echo '</div>';return ob_get_clean();
  }
  public function event_registration_shortcode(){
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
    echo '<div class="wrap"><h1>سامانه همایش</h1><p>مدیریت بخش‌های اصلی سامانه از اینجا انجام می‌شود. تخصیص نقش کاربران فقط توسط مدیر سایت انجام می‌شود.</p><p>';
    $links=array('مدیریت مقالات'=>admin_url('edit.php?post_type=conf_paper'),'پیام‌های تماس'=>admin_url('edit.php?post_type=conf_message'),'ثبت‌نام‌ها'=>admin_url('edit.php?post_type=conf_registration'),'گواهی‌ها'=>admin_url('edit.php?post_type=conf_certificate'),'کاربران و نقش‌ها'=>admin_url('users.php'),'سخنرانان'=>admin_url('edit.php?post_type=conf_speaker'),'برنامه همایش'=>admin_url('edit.php?post_type=conf_session'),'تیم و کمیته‌ها'=>admin_url('edit.php?post_type=conf_committee'));
    foreach($links as $label=>$url)echo '<a class="button button-primary" style="margin:4px" href="'.esc_url($url).'">'.esc_html($label).'</a>';
    echo '</p><p>برای تنظیم سرویس پیامک، از منوی تنظیمات پیامک استفاده کنید. داده‌های نمونه از بخش ابزارها قابل ورود است.</p></div>';
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
