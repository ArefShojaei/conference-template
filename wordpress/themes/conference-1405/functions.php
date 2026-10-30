<?php
if (!defined('ABSPATH')) exit;
define('CONF1405_VERSION','1.0.0');
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
 $c->add_section('conf1405_colors',array('title'=>'رنگ‌بندی قالب','priority'=>32));
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
 if(is_page(array('login','register','dashboard','submit-paper'))) $robots['noindex']=true;
 return $robots;
}
add_filter('wp_robots','conf1405_private_page_robots');

function conf1405_create_default_menu(){
  $locations=get_theme_mod('nav_menu_locations',array());
  $menu_id=!empty($locations['primary'])?absint($locations['primary']):0;
  if($menu_id){$assigned=wp_get_nav_menu_object($menu_id);if(!$assigned || $assigned->name!=='منوی اصلی همایش')return;}
  else{$menu=wp_get_nav_menu_object('منوی اصلی همایش');$menu_id=$menu?$menu->term_id:wp_create_nav_menu('منوی اصلی همایش');}
  if(is_wp_error($menu_id))return;
  $slugs=array('about','speakers','team','schedule','papers','news','event-registration','contact');
  $items=wp_get_nav_menu_items($menu_id);
  if(!$items)$items=array();
  foreach($slugs as $slug){
    $page=get_page_by_path($slug);
    if($page){
      $exists=false;
      foreach($items as $item){if((int)$item->object_id===(int)$page->ID){$exists=true;break;}}
      if(!$exists){wp_update_nav_menu_item($menu_id,0,array('menu-item-title'=>$page->post_title,'menu-item-object'=>'page','menu-item-object-id'=>$page->ID,'menu-item-type'=>'post_type','menu-item-status'=>'publish'));$items[]=(object)array('object_id'=>$page->ID);}
    }
  }
  $locations['primary']=$menu_id;
  $locations['footer']=$menu_id;
  set_theme_mod('nav_menu_locations',$locations);
}
add_action('after_switch_theme','conf1405_create_default_menu');
add_action('admin_init','conf1405_create_default_menu');
