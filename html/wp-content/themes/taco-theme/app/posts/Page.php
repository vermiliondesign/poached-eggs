<?php

class Page extends \Taco\Post {

  public $loaded_post = null;

/**
 * Get the fields for this page type by merging the default template fields
 * with page specific ones
 * @return array The array of fields
*/
  public function getFields() {
    $this->loadPost();
    $loaded_post_fields = [];

    if (!empty($this->loaded_post)) {
      $loaded_post_fields = $this->getFieldsByPageTemplate(
        get_page_template_slug($this->loaded_post->ID)
      );
    } else {
      $loaded_post_fields = [];
    }

    return array_merge(
      $this->getDefaultFields(),
      $loaded_post_fields
    );
  }


  public function getDefaultFields() {
    return array();
  }
  
  
  
  public function getFieldsByPageTemplate($template_file_name) {
    // setup empty array to return at the end
    $template_fields = [];
    
    
    if($template_file_name === 'templates/tmpl-demo.php') {
      $template_fields = array_merge($template_fields, array(
        'addmany_slider' => array(
          'type' => 'textarea'
        )
      ));
    }
    
    // all pages except the home page get these default values
    if($template_file_name !== 'templates/tmpl-home.php') {
      $template_fields = array_merge($template_fields, array(
        'banner_style' => array(
          'type'=>'select',
          'description'=>'If no banner style is selected, it will default to "Banner - Default"',
          'options'=>array(
            'banner_default'=>'Banner - Default',
            'banner_with_image'=>'Banner - with Image',
          )
        ),
        'banner_image' => array(
          'type' => 'image',
          'description' => 'Dimensions work best if pre-cropped at ## x ## pixels.'
        )
      ));
    }
    
    // homepage only
    if($template_file_name === 'templates/tmpl-home.php') {
      $template_fields = array_merge($template_fields, array());
    }
    
    
    return $template_fields;
  }
  
  public function getAdminColumns() {
    return array('title');
  }
  
  // get metaboxes and conditional js to hide/show fields
  public function getMetaBoxes() {

    wp_register_script('taco_page_conditionals', sprintf('%s/themes/taco-theme/app/_/js/page.js', content_url()), 'jquery', THEME_VERSION);
    wp_enqueue_script('taco_page_conditionals');
    
    // return parent::getMetaBoxes();
    return self::METABOX_GROUPING_PREFIX;
  }
  
  /**
   * This should only be used on the admin side to manually load the post in getFields()
   * because the global $post var isn't accessible when we need it
   */
  public function loadPost() {
    // When we're loading the page, it's in the query string.
    // When we're saving the page, it's in the post vars
    if (!empty($_POST['post_ID'])) {
      $post_id = $_POST['post_ID'];
    } else if (!empty($_GET['post'])) {
      $post_id = $_GET['post'];
    }

    if(empty($post_id)) return false;

    $post_object = get_post($post_id);
    if(is_object($post_object)) {
      $this->loaded_post = $post_object;
      return true;
    }
    return false;
  }
}
