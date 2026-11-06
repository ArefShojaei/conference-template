<?php
/** Dynamic conference page renderer. */
get_header();
$slug = is_singular('page') ? get_post_field('post_name', get_queried_object_id()) : '';
$shortcodes = array('login'=>'[conference_login]','register'=>'[conference_register]','dashboard'=>'[conference_dashboard]','submit-paper'=>'[conference_submit_paper]','papers'=>'[conference_papers]','speakers'=>'[conference_speakers]','team'=>'[conference_team]','news'=>'[conference_news]','contact'=>'[conference_contact]','event-registration'=>'[conference_event_registration]','my-papers'=>'[conference_my_papers]','profile'=>'[conference_profile]','certificates'=>'[conference_certificates]');
?>
<main id="primary" class="site-main">
<?php if (in_array($slug,array('login','register','dashboard','submit-paper','my-papers','profile','certificates','event-registration'),true)): ?>
<section class="section"><div class="container"><?php while(have_posts()):the_post();?><div class="section-header"><h1><?php the_title();?></h1></div><?php endwhile;?><?php echo do_shortcode($shortcodes[$slug]??'');?></div></section>
<?php elseif(isset($shortcodes[$slug])): ?>
<section class="section"><div class="container"><div class="section-header"><h1><?php the_title();?></h1></div><?php echo do_shortcode($shortcodes[$slug]);?></div></section>
<?php elseif($slug==='dates'): ?>
<section class="section" style="background:linear-gradient(135deg,#123d38,#0f766e);color:white"><div class="container text-center"><h1><?php the_title();?></h1><p><?php echo esc_html(get_theme_mod('conf1405_event_name','همایش فناوری و نوآوری ۱۴۰۵'));?></p></div></section><section class="section"><div class="container"><div class="grid grid-4"><?php for($i=1;$i<=4;$i++):?><article class="card" style="padding:24px"><h3><?php echo esc_html(get_theme_mod("conf1405_date{$i}_title",'رویداد مهم'));?></h3><p><?php echo esc_html(get_theme_mod("conf1405_date{$i}_date",'به‌زودی'));?></p></article><?php endfor;?></div></div></section>
<?php elseif($slug==='faq'): ?>
<section class="section"><div class="container"><div class="section-header"><h1><?php the_title();?></h1><p>پاسخ پرسش‌های متداول شرکت‌کنندگان و نویسندگان</p></div><?php while(have_posts()):the_post();?><article class="card" style="padding:24px"><?php the_content();?></article><?php endwhile;?></div></section>
<?php elseif(in_array($slug,array('about','author-guidelines','certificate-info'),true)): ?>
<section class="section" style="background:linear-gradient(135deg,#123d38,#1c6b60);color:white"><div class="container text-center"><h1><?php the_title();?></h1></div></section><section class="section"><div class="container"><article class="card" style="padding:30px"><?php while(have_posts()):the_post();the_content();endwhile;?></article></div></section>
<?php else: ?>
<section class="section"><div class="container"><?php while(have_posts()):the_post();?><article <?php post_class('card');?> style="padding:30px"><h1><?php the_title();?></h1><?php the_content();?></article><?php endwhile;?></div></section>
<?php endif;?></main><?php get_footer(); ?>
