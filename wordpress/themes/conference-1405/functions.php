<?php
if (!defined('ABSPATH')) exit;
define('CONF1405_VERSION','1.2.0');
function conf1405_setup(){
 load_theme_textdomain('conference-1405',get_template_directory().'/languages');
 add_theme_support('title-tag'); add_theme_support('post-thumbnails');
 add_theme_support('html5',array('search-form','comment-form','comment-list','gallery','caption','style','script'));
 add_theme_support('custom-logo',array('height'=>80,'width'=>260,'flex-height'=>true,'flex-width'=>true));
 register_nav_menus(array('primary'=>'فهرست اصلی','footer'=>'فهرست پایین صفحه'));
 register_sidebar(array('name'=>'ابزارک ستون اول پاورقی','id'=>'footer-1','before_widget'=>'<section class="footer-widget">','after_widget'=>'</section>','before_title'=>'<h4>','after_title'=>'</h4>'));
 register_sidebar(array('name'=>'ابزارک ستون دوم پاورقی','id'=>'footer-2','before_widget'=>'<section class="footer-widget">','after_widget'=>'</section>','before_title'=>'<h4>','after_title'=>'</h4>'));
 register_sidebar(array('name'=>'ابزارک کناری صفحه اصلی','id'=>'homepage-rail','before_widget'=>'<section class="rail-widget">','after_widget'=>'</section>','before_title'=>'<h3>','after_title'=>'</h3>'));
}
add_action('after_setup_theme','conf1405_setup');
function conf1405_assets(){
 wp_enqueue_style('conf1405-base',get_template_directory_uri().'/assets/css/style.css',array(),CONF1405_VERSION);
 wp_enqueue_style('conf1405-redesign',get_template_directory_uri().'/assets/css/mvp-redesign.css',array('conf1405-base'),CONF1405_VERSION);
 wp_enqueue_style('conf1405-responsive',get_template_directory_uri().'/assets/css/responsive-fixes.css',array('conf1405-redesign'),CONF1405_VERSION);
 wp_enqueue_style('conf1405-theme',get_stylesheet_uri(),array('conf1405-responsive'),CONF1405_VERSION);
 wp_enqueue_script('conf1405-main',get_template_directory_uri().'/assets/js/main.js',array(),CONF1405_VERSION,true);
}
add_action('wp_enqueue_scripts','conf1405_assets');
function conf1405_customize($c){
 $c->add_section('conf1405_event',array('title'=>'اطلاعات همایش','priority'=>30));
 $fields=array('event_name'=>array('عنوان همایش','همایش بین‌المللی فناوری و نوآوری ۱۴۰۵'),'event_date'=>array('تاریخ همایش','۱۵ تا ۱۷ آذر ۱۴۰۵'),'event_location'=>array('محل برگزاری','تهران، مرکز همایش‌های بین‌المللی'),'event_deadline'=>array('مهلت ارسال مقاله','۳۰ مهر ۱۴۰۵'),'event_description'=>array('توضیح کوتاه','جایی برای ارائه پژوهش‌های تازه و ساختن همکاری‌های علمی.'));
 foreach($fields as $id=>$f){$c->add_setting('conf1405_'.$id,array('default'=>$f[1],'sanitize_callback'=>'sanitize_text_field'));$c->add_control('conf1405_'.$id,array('label'=>$f[0],'section'=>'conf1405_event','type'=>'text'));}
 $c->add_section('conf1405_slides',array('title'=>'اسلایدر صفحه اصلی','priority'=>31));
 for($i=1;$i<=3;$i++){
  $c->add_setting("conf1405_slide{$i}_image",array('default'=>'','sanitize_callback'=>'esc_url_raw'));
  $c->add_control(new WP_Customize_Image_Control($c,"conf1405_slide{$i}_image",array('label'=>"تصویر پس‌زمینه اسلاید {$i}",'section'=>'conf1405_slides')));
  foreach(array('title'=>'عنوان','subtitle'=>'متن کوتاه','link'=>'پیوند دکمه') as $key=>$label){
   $default=$key==='link'?home_url('/submit-paper/'):($key==='title'?'ایده‌های بزرگ، آینده‌های روشن':'پژوهش خود را با جامعه علمی به اشتراک بگذارید');
   $c->add_setting("conf1405_slide{$i}_{$key}",array('default'=>$default,'sanitize_callback'=>$key==='link'?'esc_url_raw':'sanitize_text_field'));
   $c->add_control("conf1405_slide{$i}_{$key}",array('label'=>"اسلاید {$i} - {$label}",'section'=>'conf1405_slides','type'=>'text'));
  }
 }
 $c->add_section('conf1405_features',array('title'=>'کارت‌های ویژگی صفحه اصلی','priority'=>32));
 $feature_defaults=array(
  array('📝','ارسال و داوری مقاله','سامانه ارسال مقاله و پیگیری وضعیت داوری به صورت آنلاین'),
  array('🎤','سخنرانان برجسته','حضور استادان و متخصصان برجسته در حوزه‌های علمی'),
  array('🤝','شبکه‌سازی حرفه‌ای','فرصت ارتباط با پژوهشگران و فعالان صنعت'),
  array('🏆','جوایز و تقدیر','تقدیر از مقاله‌ها و ارائه‌های برتر'),
  array('📚','انتشار مقالات','معرفی و انتشار آثار پذیرفته‌شده همایش'),
  array('💻','پنل کاربری کامل','داشبورد اختصاصی برای نویسندگان و داوران')
 );
 $feature_labels=array('icon'=>'آیکن','title'=>'عنوان','text'=>'توضیح');
 foreach($feature_defaults as $i=>$item){$n=$i+1;foreach(array('icon'=>$item[0],'title'=>$item[1],'text'=>$item[2]) as $key=>$value){$c->add_setting("conf1405_feature{$n}_{$key}",array('default'=>$value,'sanitize_callback'=>'sanitize_text_field'));$c->add_control("conf1405_feature{$n}_{$key}",array('label'=>"ویژگی {$n} - ".$feature_labels[$key],'section'=>'conf1405_features','type'=>'text'));}}
 $c->add_section('conf1405_dates',array('title'=>'تاریخ‌های مهم صفحه اصلی','priority'=>33));
 $date_defaults=array(array('مهلت ارسال مقاله','۳۰ مهر ۱۴۰۵'),array('اعلام نتایج داوری','۱۵ آبان ۱۴۰۵'),array('مهلت ثبت‌نام نهایی','۳۰ آبان ۱۴۰۵'),array('برگزاری همایش','۱۵ تا ۱۷ آذر ۱۴۰۵'));
 $date_labels=array('title'=>'عنوان','date'=>'تاریخ');
 foreach($date_defaults as $i=>$item){$n=$i+1;foreach(array('title'=>$item[0],'date'=>$item[1]) as $key=>$value){$c->add_setting("conf1405_date{$n}_{$key}",array('default'=>$value,'sanitize_callback'=>'sanitize_text_field'));$c->add_control("conf1405_date{$n}_{$key}",array('label'=>"تاریخ {$n} - ".$date_labels[$key],'section'=>'conf1405_dates','type'=>'text'));}}
 $c->add_section('conf1405_home_texts',array('title'=>'متن بخش‌های صفحه اصلی','priority'=>34));
 $home_texts=array(
  'hero_eyebrow'=>array('برچسب بالای اسلایدر','رویداد علمی'),
  'hero_submit_label'=>array('متن دکمه ارسال مقاله','ارسال مقاله'),
  'hero_about_label'=>array('متن پیوند درباره همایش','درباره همایش'),
  'rail_topline'=>array('عنوان بالای کارت کناری','ثبت‌نام و ارسال مقاله'),
  'rail_label'=>array('برچسب کارت کناری','رویداد علمی'),
  'rail_location_label'=>array('عنوان محل برگزاری','مکان'),
  'rail_deadline_label'=>array('عنوان مهلت ارسال','مهلت ارسال مقاله'),
  'rail_register_label'=>array('متن دکمه ثبت‌نام کارت کناری','ثبت‌نام در همایش'),
  'schedule_title'=>array('عنوان کارت برنامه','برنامه همایش'),
  'schedule_text'=>array('توضیح کارت برنامه','جلسه‌ها و کارگاه‌ها را ببینید'),
  'features_title'=>array('عنوان بخش ویژگی‌ها','چرا در این همایش شرکت کنید؟'),
  'features_text'=>array('توضیح بخش ویژگی‌ها','فرصتی برای یادگیری، شبکه‌سازی و ارائه پژوهش‌های علمی'),
  'dates_title'=>array('عنوان بخش تاریخ‌های مهم','تاریخ‌های مهم'),
  'dates_text'=>array('توضیح بخش تاریخ‌های مهم','مهلت‌ها و رویدادهای کلیدی همایش'),
  'news_title'=>array('عنوان بخش اخبار','آخرین اخبار و اطلاعیه‌ها'),
  'news_text'=>array('توضیح بخش اخبار','جدیدترین مطالب همایش'),
  'speakers_title'=>array('عنوان بخش سخنرانان','سخنرانان همایش'),
  'speakers_text'=>array('توضیح بخش سخنرانان','چهره‌های علمی و تخصصی'),
  'cta_title'=>array('عنوان دعوت به اقدام پایانی','آماده شرکت در همایش هستید؟'),
  'cta_text'=>array('توضیح دعوت به اقدام پایانی','حساب کاربری خود را ایجاد کنید.'),
  'cta_button'=>array('متن دکمه دعوت به اقدام','ثبت‌نام با شماره موبایل')
 );
 foreach($home_texts as $key=>$item){$mod='conf1405_'.$key;$c->add_setting($mod,array('default'=>$item[1],'sanitize_callback'=>'sanitize_text_field'));$c->add_control($mod,array('label'=>$item[0],'section'=>'conf1405_home_texts','type'=>'text'));}
 $c->add_section('conf1405_colors',array('title'=>'رنگ‌بندی قالب','priority'=>34));
 $c->add_setting('conf1405_primary',array('default'=>'#123d38','sanitize_callback'=>'sanitize_hex_color'));
 $c->add_control(new WP_Customize_Color_Control($c,'conf1405_primary',array('label'=>'رنگ اصلی','section'=>'conf1405_colors')));
}
add_action('customize_register','conf1405_customize');
function conf1405_custom_css(){ $color=get_theme_mod('conf1405_primary','#123d38');echo '<style>:root{--mvp-forest:'.esc_attr($color).';--primary:'.esc_attr($color).';}.nav-menu .current-menu-item>a,.nav-menu .current_page_item>a{background:var(--gray-100);color:var(--primary)}.footer .menu{display:grid;gap:8px}.footer .menu a:hover{color:var(--mvp-gold)}</style>'; }
add_action('wp_head','conf1405_custom_css',30);
function conf1405_excerpt_length($n){return 24;} add_filter('excerpt_length','conf1405_excerpt_length');

function conf1405_meta_description(){
 if(defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) return;
 if(is_front_page()) $description=get_theme_mod('conf1405_event_description','وب‌سایت رسمی همایش؛ ثبت‌نام، ارسال مقاله و اطلاع‌رسانی.');
 elseif(is_singular()) $description=get_the_excerpt();
 else $description=get_bloginfo('description');
 $description=wp_trim_words(wp_strip_all_tags($description),30,'');
 if($description) echo '<meta name="description" content="'.esc_attr($description).'">'.PHP_EOL;
}
add_action('wp_head','conf1405_meta_description',2);
function conf1405_private_page_robots($robots){
 if(is_page(array('login','register','dashboard','submit-paper','event-registration','my-papers','my-registration','certificates','messages','profile','reviewer-dashboard','review-queue','review-paper','my-reviews','admin-dashboard','admin-users','admin-papers','admin-registrations','admin-reviews','admin-reviewers','admin-settings','admin-sms','admin-team','admin-posts'))) { $robots['noindex']=true; $robots['nofollow']=true; }
 return $robots;
}
add_filter('wp_robots','conf1405_private_page_robots');

function conf1405_create_default_menu(){
  $locations=get_theme_mod('nav_menu_locations',array());
  $assigned=!empty($locations['primary'])?wp_get_nav_menu_object((int)$locations['primary']):false;
  if($assigned && $assigned->name!=='منوی اصلی همایش')return;
  $menu=wp_get_nav_menu_object('منوی اصلی همایش');
  $menu_id=$menu?$menu->term_id:wp_create_nav_menu('منوی اصلی همایش');
  if(is_wp_error($menu_id))return;
  $slugs=array('about','speakers','team','schedule','papers','news','event-registration','author-guidelines','faq','contact');
  $items=wp_get_nav_menu_items($menu_id);
  $existing=array();
  foreach((array)$items as $item)$existing[(int)$item->object_id]=true;
  foreach($slugs as $slug){
    $page=get_page_by_path($slug);
    if($page && empty($existing[(int)$page->ID])){
      wp_update_nav_menu_item($menu_id,0,array('menu-item-title'=>$page->post_title,'menu-item-object'=>'page','menu-item-object-id'=>$page->ID,'menu-item-type'=>'post_type','menu-item-status'=>'publish'));
    }
  }
  $locations['primary']=$menu_id;
  if(empty($locations['footer']))$locations['footer']=$menu_id;
  set_theme_mod('nav_menu_locations',$locations);
}
function conf1405_seed_theme_defaults(){
  $defaults=array(
    'conf1405_event_name'=>'همایش بین‌المللی فناوری و نوآوری ۱۴۰۵',
    'conf1405_event_date'=>'۱۵ تا ۱۷ آذر ۱۴۰۵',
    'conf1405_event_location'=>'تهران، مرکز همایش‌های بین‌المللی',
    'conf1405_event_deadline'=>'۳۰ مهر ۱۴۰۵',
    'conf1405_event_description'=>'رویدادی برای ارائه پژوهش‌های تازه، تبادل تجربه و توسعه همکاری‌های علمی.',
    'conf1405_primary'=>'#123d38',
    'conf1405_phone'=>'۰۲۱-۱۲۳۴۵۶۷۸',
    'conf1405_email'=>'info@example.com',
    'conf1405_address'=>'تهران، مرکز همایش‌های بین‌المللی'
  );
  foreach($defaults as $key=>$value)if(get_theme_mod($key,false)===false)set_theme_mod($key,$value);
  $slides=array(
    1=>array('title'=>'ایده‌های بزرگ، آینده‌های روشن','subtitle'=>'پژوهش خود را با جامعه علمی به اشتراک بگذارید'),
    2=>array('title'=>'دانش، تجربه و همکاری','subtitle'=>'با پژوهشگران و متخصصان حوزه فناوری همراه شوید'),
    3=>array('title'=>'از پژوهش تا اثرگذاری','subtitle'=>'در نشست‌ها و کارگاه‌های تخصصی همایش شرکت کنید')
  );
  foreach($slides as $i=>$fields)foreach($fields as $field=>$value){$key="conf1405_slide{$i}_{$field}";if(get_theme_mod($key,false)===false)set_theme_mod($key,$value);}
  for($i=1;$i<=3;$i++){ $key="conf1405_slide{$i}_link"; if(get_theme_mod($key,false)===false)set_theme_mod($key,home_url('/submit-paper/')); }
  $metrics=array(1=>array('03','روز تجربه و یادگیری'),2=>array('۱۲+','کارگاه تخصصی'),3=>array('۴۵+','سخنران و متخصص'),4=>array('۱۲۰۰+','شرکت‌کننده'));
  foreach($metrics as $i=>$pair){foreach(array('value'=>$pair[0],'label'=>$pair[1]) as $key=>$value){$mod="conf1405_metric{$i}_{$key}";if(get_theme_mod($mod,false)===false)set_theme_mod($mod,$value);}}
  $features=array(
    array('📝','ارسال و داوری مقاله','سامانه ارسال مقاله و پیگیری وضعیت داوری به صورت آنلاین'),
    array('🎤','سخنرانان برجسته','حضور استادان و متخصصان برجسته در حوزه‌های علمی'),
    array('🤝','شبکه‌سازی حرفه‌ای','فرصت ارتباط با پژوهشگران و فعالان صنعت'),
    array('🏆','جوایز و تقدیر','تقدیر از مقاله‌ها و ارائه‌های برتر'),
    array('📚','انتشار مقالات','معرفی و انتشار آثار پذیرفته‌شده همایش'),
    array('💻','پنل کاربری کامل','داشبورد اختصاصی برای نویسندگان و داوران')
  );
  foreach($features as $i=>$pair){$n=$i+1;foreach(array('icon'=>$pair[0],'title'=>$pair[1],'text'=>$pair[2]) as $key=>$value){$mod="conf1405_feature{$n}_{$key}";if(get_theme_mod($mod,false)===false)set_theme_mod($mod,$value);}}
  $dates=array(array('مهلت ارسال مقاله','۳۰ مهر ۱۴۰۵'),array('اعلام نتایج داوری','۱۵ آبان ۱۴۰۵'),array('مهلت ثبت‌نام نهایی','۳۰ آبان ۱۴۰۵'),array('برگزاری همایش','۱۵ تا ۱۷ آذر ۱۴۰۵'));
  foreach($dates as $i=>$pair){$n=$i+1;foreach(array('title'=>$pair[0],'date'=>$pair[1]) as $key=>$value){$mod="conf1405_date{$n}_{$key}";if(get_theme_mod($mod,false)===false)set_theme_mod($mod,$value);}}
  $home_texts=array('hero_eyebrow'=>'رویداد علمی','hero_submit_label'=>'ارسال مقاله','hero_about_label'=>'درباره همایش','rail_topline'=>'ثبت‌نام و ارسال مقاله','rail_label'=>'رویداد علمی','rail_location_label'=>'مکان','rail_deadline_label'=>'مهلت ارسال مقاله','rail_register_label'=>'ثبت‌نام در همایش','schedule_title'=>'برنامه همایش','schedule_text'=>'جلسه‌ها و کارگاه‌ها را ببینید','features_title'=>'چرا در این همایش شرکت کنید؟','features_text'=>'فرصتی برای یادگیری، شبکه‌سازی و ارائه پژوهش‌های علمی','dates_title'=>'تاریخ‌های مهم','dates_text'=>'مهلت‌ها و رویدادهای کلیدی همایش','news_title'=>'آخرین اخبار و اطلاعیه‌ها','news_text'=>'جدیدترین مطالب همایش','speakers_title'=>'سخنرانان همایش','speakers_text'=>'چهره‌های علمی و تخصصی','cta_title'=>'آماده شرکت در همایش هستید؟','cta_text'=>'حساب کاربری خود را ایجاد کنید.','cta_button'=>'ثبت‌نام با شماره موبایل');
  foreach($home_texts as $key=>$value){$mod="conf1405_{$key}";if(get_theme_mod($mod,false)===false)set_theme_mod($mod,$value);}
}
function conf1405_seed_default_widgets(){
  $sidebars=get_option('sidebars_widgets',array());
  if(!is_array($sidebars))$sidebars=array();
  $widgets=get_option('widget_text',array('_multiwidget'=>1));
  if(!is_array($widgets))$widgets=array('_multiwidget'=>1);
  $defaults=array(
    'footer-1'=>array(101,'دسترسی سریع','برای مشاهده برنامه، سخنرانان و اخبار همایش از فهرست سایت استفاده کنید.'),
    'footer-2'=>array(102,'دبیرخانه همایش','برای پرسش‌ها از صفحه تماس با ما پیام خود را ثبت کنید.'),
    'homepage-rail'=>array(103,'اطلاعیه دبیرخانه','آخرین اطلاعیه‌ها و مهلت‌های همایش را از بخش اخبار دنبال کنید.')
  );
  foreach($defaults as $sidebar=>$data){
    if(!empty($sidebars[$sidebar]))continue;
    $id=(int)$data[0];
    if(!isset($widgets[$id]))$widgets[$id]=array('title'=>$data[1],'text'=>$data[2],'filter'=>false,'visual'=>true);
    $sidebars[$sidebar]=array('text-'.$id);
  }
  $widgets['_multiwidget']=1;
  update_option('widget_text',$widgets);
  update_option('sidebars_widgets',$sidebars);
}
add_action('after_switch_theme','conf1405_create_default_menu');
add_action('init','conf1405_create_default_menu',30);
add_action('after_switch_theme','conf1405_seed_theme_defaults',5);
add_action('admin_init','conf1405_seed_theme_defaults',5);
add_action('after_switch_theme','conf1405_seed_default_widgets',10);
add_action('admin_init','conf1405_seed_default_widgets',10);

function conf1405_defer_frontend_script($tag,$handle){
 if($handle==='conf1405-main' && strpos($tag,' defer')===false)$tag=str_replace(' src',' defer src',$tag);
 return $tag;
}
add_filter('script_loader_tag','conf1405_defer_frontend_script',10,2);
function conf1405_resource_hints($urls,$relation_type){
 if($relation_type==='preconnect'){$urls[]='https://fonts.googleapis.com';$urls[]=array('href'=>'https://fonts.gstatic.com','crossorigin'=>'anonymous');}
 return $urls;
}
add_filter('wp_resource_hints','conf1405_resource_hints',10,2);


// Additional editable homepage metrics and footer contact details.
function conf1405_extended_customize($c){
 $c->add_section('conf1405_metrics',array('title'=>'آمار صفحه اصلی','priority'=>35));
 $defaults=array(1=>array('03','روز تجربه و یادگیری'),2=>array('۱۲+','کارگاه تخصصی'),3=>array('۴۵+','سخنران و متخصص'),4=>array('۱۲۰۰+','شرکت‌کننده'));
 foreach($defaults as $i=>$pair){foreach(array('value'=>$pair[0],'label'=>$pair[1]) as $key=>$value){$id="conf1405_metric{$i}_{$key}";$c->add_setting($id,array('default'=>$value,'sanitize_callback'=>'sanitize_text_field'));$c->add_control($id,array('label'=>"شاخص {$i} - ".($key==='value'?'عدد':'عنوان'),'section'=>'conf1405_metrics','type'=>'text'));}}
 $c->add_section('conf1405_contact',array('title'=>'اطلاعات تماس و شبکه‌های اجتماعی','priority'=>36));
 $contact=array('phone'=>array('تلفن تماس','۰۲۱-۱۲۳۴۵۶۷۸'),'email'=>array('ایمیل عمومی','info@example.com'),'address'=>array('نشانی','تهران، مرکز همایش‌های بین‌المللی'),'instagram'=>array('پیوند اینستاگرام',''),'telegram'=>array('پیوند تلگرام',''));
 foreach($contact as $key=>$pair){$id='conf1405_'.$key;$c->add_setting($id,array('default'=>$pair[1],'sanitize_callback'=>in_array($key,array('instagram','telegram'),true)?'esc_url_raw':'sanitize_text_field'));$c->add_control($id,array('label'=>$pair[0],'section'=>'conf1405_contact','type'=>'text'));}
}
add_action('customize_register','conf1405_extended_customize');
