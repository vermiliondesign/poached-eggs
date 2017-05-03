<?php get_header(); ?>

<div class="first-panel">
  
  <div class="banner default">
    <div class="figure-wrapper">
      &nbsp;
    </div>
    <div class="row">
      <div class="columns small-10 medium-8">
        <div class="inner">
          <h1>404</h1>
          <p class="sub-title">Not Found.</p>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- main-content -->
<div class="panel main-content <?php echo $page_main_content_image_class; ?>" style="padding-top: 40px;">
  <article class="row">
    <div class="columns small-10 medium-8 content">
    <div class="banner-below page-excerpt">
      <p>
        If you are trying to login to your account, <br> please <a href="https://portal.caintravel.com/profolio/login.aspx" target="_blank">click here.</a>
      </p>
    </div>
      
<!--       <form class="search-default" role="search" method="get" action="<?php // echo home_url(); ?>">
        <input type="text" placeholder="Search...." name="s" class="searchbox-input">
        <button type="submit" class="searchbox-submit" value="GO"><i class="icon-symbol-search-open"></i></button>
      </form> -->
      
      <?php // get header search desktop only
        include __DIR__.'/includes/incl-search-default.php';
      ?>
      



      <?php wp_nav_menu( array(
        'theme_location' => 'menu_primary'
      ) ); ?>

      
    </div>
  </article>
  <!-- for styling of the main content figure image -->
  <div class="image-wrapper">&nbsp;</div>
</div>







<?php get_footer(); ?>