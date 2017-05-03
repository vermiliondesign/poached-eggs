<?php
// get theme
$theme = AppOption::getInstance();
?>


</div>
<!--/.page-wrap -->



<footer>
  <div class="row">
    <div class="columns small-12">
      
      <?php wp_nav_menu( array(
        'theme_location' => 'menu_primary',
        'container' => false,
        'walker'=> new Arrow_Walker_Nav_Menu()
      ) ); ?>
      
    </div>
  </div>
</footer>


<?php wp_footer(); ?>

<!-- Deferred styles https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery -->
<noscript id="deferred-styles">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Slab" rel="stylesheet">
</noscript>

<script>
  var loadDeferredStyles = function() {
    var addStylesNode = document.getElementById("deferred-styles");
    var replacement = document.createElement("div");
    replacement.innerHTML = addStylesNode.textContent;
    document.body.appendChild(replacement)
    addStylesNode.parentElement.removeChild(addStylesNode);
  };
  var raf = requestAnimationFrame || mozRequestAnimationFrame ||
      webkitRequestAnimationFrame || msRequestAnimationFrame;
  if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
  else window.addEventListener('load', loadDeferredStyles);
</script>


<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-589919bb75172165"></script>

</body>
</html>