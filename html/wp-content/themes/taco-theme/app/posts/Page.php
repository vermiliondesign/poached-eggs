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
    return [
      'default' => [
        'type' => 'text',
      ],
    ];
  }

  /**
   * Get the template of this page and populate $this->_wp_page_template with it
   * @return string The template of this
   */
  public function getTemplate() {
    // If this is the user facing page, then _wp_page_template will be populated
    // and that can be used as the template.
    //
    // If this is the admin facing page, then loadPost() is run to figure out
    // the page ID and the template is determined that way
    if (!empty($this->_wp_page_template)) {
      $template = $this->_wp_page_template;
    } else {
      if(!$this->loadPost() || !Obj::iterable($this->loaded_post)) {
        return [];
      }

      $template = get_page_template_slug($this->loaded_post->ID);
      $this->_wp_page_template = $template;
    }

    return $template;
  }

  public function getFieldsByPageTemplate($template_file_name) {
    // Default empty template fields array
    $template_fields = [];

    switch($template_file_name) {
      case 'templates/tmpl-demo.php':
        $template_fields = array_merge(
          $this->getDemoFields()
        );
      break;
    }

    return array_merge(
      $this->getDefaultFields(), // Default fields get prepended to returned array
      $template_fields
    );
  }

  public function getAdminColumns() {
    return ['title'];
  }

  // get metaboxes and conditional js to hide/show fields
  public function getMetaBoxes() {
    wp_register_script('taco_page_conditionals', sprintf('%s/themes/taco-theme/app/_/js/page.js', content_url()), 'jquery', THEME_VERSION);
    wp_enqueue_script('taco_page_conditionals');

    $template = $this->getTemplate();

    return $this->getMetaBoxesByTemplate($template);
  }

  public function getMetaBoxesByTemplate($template_file_name) {
    // Default boxes get prepended to returned array
    $default_boxes = [
      'Default' => 'default',
    ];

    // Initialize empty boxes for template
    $template_boxes = [];

    switch ($template_file_name) {
      case 'templates/tmpl-demo.php':
        $template_boxes = [
          'Demo' => array_keys($this->getDemoFields()),
        ];
      break;
    }

    return array_merge(
      $default_boxes,
      $template_boxes
    );
  }

  /**
   * Get an array of demo fields
   */
  public function getDemoFields() {
    return [
      'demo' => [
        'type' => 'text'
      ]
    ];
  }

    /**
   * Load the post fields based on the ID, or by using
   * GET and POST vars on the admin side
   */
  public function loadPost() {
    // Don't do anything if post already loaded
    if (!empty($this->loaded_post)) {
      return true;
    }

    // Don't do extra work to load the post if this post is the same as the global post
    global $post;

    if (!empty($post) && !empty($this->ID) && $post->ID === $this->ID) {
      $this->loaded_post = $post;
      return true;
    }

    // When we're loading the page, it's in the query string.
    // When we're saving the page, it's in the post vars
    if (!empty($this->ID)) {
      $post_id = $this->ID;
    } else if (!empty($_POST['post_ID'])) {
      $post_id = $_POST['post_ID'];
    } else if (!empty($_GET['post'])) {
      $post_id = $_GET['post'];
    }

    if(empty($post_id)) {
      return false;
    }

    $post_object = get_post($post_id);
    if(is_object($post_object)) {
      $this->loaded_post = $post_object;
      return true;
    }
    return false;
  }
}
