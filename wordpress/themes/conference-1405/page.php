<?php
if (!defined('ABSPATH')) exit;
get_header();
$slug = get_post_field('post_name', get_queried_object_id());
$workspace_slugs = array('dashboard','my-papers','my-registration','certificates','messages','profile','reviewer-dashboard','review-queue','review-paper','my-reviews','admin-dashboard','admin-users','admin-papers','admin-registrations','admin-reviews','admin-reviewers','admin-settings','admin-sms','admin-team','admin-posts');
$is_workspace = in_array($slug, $workspace_slugs, true);
?>
<main id="primary" class="<?php echo $is_workspace ? 'conf-page conf-page-workspace' : 'section conf-page'; ?>">
  <div class="<?php echo $is_workspace ? 'container-fluid' : 'container'; ?>">
    <?php while (have_posts()) : the_post(); ?>
      <?php if ($is_workspace) : ?>
        <article id="page-<?php the_ID(); ?>" <?php post_class('conf-page-content'); ?>>
          <?php the_content(); ?>
        </article>
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