<?php /* Template Name: Page - Home */
get_header();

//setup the page
$page = \Taco\Post\Factory::create($post);
// get theme
$theme = AppOption::getInstance();
?>

<article class="content">
  <?php echo $page->getTheContent(); ?>
</article>

<?php get_footer(); ?>