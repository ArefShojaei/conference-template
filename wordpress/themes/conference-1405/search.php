<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main id="primary" class="section"><div class="container">
<header class="section-header"><h1>نتایج جست‌وجو برای: <?php echo esc_html(get_search_query()); ?></h1></header>
<div class="grid grid-3">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article <?php post_class('card'); ?>>
<?php if (has_post_thumbnail()) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large'); ?></a><?php endif; ?>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<p><?php echo esc_html(get_the_excerpt()); ?></p>
<a href="<?php the_permalink(); ?>">ادامه مطلب ←</a>
</article>
<?php endwhile; the_posts_pagination(); else : ?>
<div class="card"><p>موردی مطابق جست‌وجوی شما پیدا نشد.</p><?php get_search_form(); ?></div>
<?php endif; ?>
</div></div></main>
<?php get_footer(); ?>
