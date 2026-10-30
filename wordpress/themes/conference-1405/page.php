<?php
if (!defined('ABSPATH')) exit;
get_header();
$slug = get_post_field('post_name', get_queried_object_id());
$admin_slugs = array('admin-dashboard','admin-users','admin-papers','admin-registrations','admin-reviews','admin-reviewers','admin-settings','admin-sms','admin-team','admin-posts');
$reviewer_slugs = array('review-queue','review-paper','my-reviews');
$user_slugs = array('my-papers','my-registration','certificates','messages','profile','submit-paper','event-registration');
$is_workspace = in_array($slug, array_merge(array('dashboard','reviewer-dashboard'),$admin_slugs,$reviewer_slugs,$user_slugs), true);
?>
<main id="primary" class="<?php echo $is_workspace ? 'conf-page conf-page-workspace' : 'section conf-page'; ?>">
  <div class="<?php echo $is_workspace ? 'container-fluid' : 'container'; ?>">
    <?php while (have_posts()) : the_post(); ?>
      <?php if (in_array($slug,$user_slugs,true)) : ?>
        <div class="admin-layout confcore-page-shell">
          <aside class="admin-sidebar"><h3>پنل کاربری</h3><nav class="admin-nav">
            <a href="<?php echo esc_url(home_url('/dashboard/')); ?>">داشبورد</a>
            <a href="<?php echo esc_url(home_url('/my-papers/')); ?>">مقالات من</a>
            <a href="<?php echo esc_url(home_url('/submit-paper/')); ?>">ارسال مقاله</a>
            <a href="<?php echo esc_url(home_url('/my-registration/')); ?>">ثبت‌نام من</a>
            <a href="<?php echo esc_url(home_url('/certificates/')); ?>">گواهی‌ها</a>
            <a href="<?php echo esc_url(home_url('/messages/')); ?>">پیام‌ها</a>
            <a href="<?php echo esc_url(home_url('/profile/')); ?>">پروفایل</a>
            <?php if(current_user_can('review_conference_papers')): ?><a href="<?php echo esc_url(home_url('/reviewer-dashboard/')); ?>">پنل داوری</a><?php endif; ?>
            <?php if(current_user_can('manage_conference') || current_user_can('manage_options')): ?><a href="<?php echo esc_url(home_url('/admin-dashboard/')); ?>">پنل مدیریت</a><?php endif; ?>
            <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج</a>
          </nav></aside>
          <section class="admin-main"><?php if($slug!=='review-paper'): ?><header class="admin-page-heading"><h1><?php the_title(); ?></h1></header><?php endif; ?><article id="page-<?php the_ID(); ?>" <?php post_class('conf-page-content'); ?>><?php the_content(); ?></article></section>
        </div>
      <?php elseif (in_array($slug,$reviewer_slugs,true)) : ?>
        <div class="admin-layout confcore-page-shell">
          <aside class="admin-sidebar"><h3>پنل داوری</h3><nav class="admin-nav">
            <a href="<?php echo esc_url(home_url('/reviewer-dashboard/')); ?>">داشبورد داور</a>
            <a href="<?php echo esc_url(home_url('/review-queue/')); ?>">صف داوری</a>
            <a href="<?php echo esc_url(home_url('/my-reviews/')); ?>">داوری‌های من</a>
            <a href="<?php echo esc_url(home_url('/dashboard/')); ?>">پنل کاربری</a>
            <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">خروج</a>
          </nav></aside>
          <section class="admin-main"><header class="admin-page-heading"><h1><?php the_title(); ?></h1></header><article id="page-<?php the_ID(); ?>" <?php post_class('conf-page-content'); ?>><?php the_content(); ?></article></section>
        </div>
      <?php elseif ($is_workspace) : ?>
        <article id="page-<?php the_ID(); ?>" <?php post_class('conf-page-content'); ?>><?php the_content(); ?></article>
      <?php else : ?>
        <article id="page-<?php the_ID(); ?>" <?php post_class('card content-card conf-page-content'); ?>>
          <header class="section-header"><h1><?php the_title(); ?></h1></header>
          <div class="entry-content"><?php the_content(); ?></div>
        </article>
      <?php endif; ?>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer(); ?>