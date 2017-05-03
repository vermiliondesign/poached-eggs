<?php /* Template Name: Page - Demo (delete) */
get_header();
//setup the page
$page = \Taco\Post\Factory::create($post);
?>

<h1>
  <?php echo $page->getTheTitle(); ?>
</h1>

<article class="content">
  <?php echo $page->getTheContent(); ?>
</article>


<?php get_footer(); ?>