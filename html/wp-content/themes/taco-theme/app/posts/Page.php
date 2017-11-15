<?php

class Page extends \Taco\Post {

  public $loaded_post = null;

  /**
   * Get the fields for this page type by merging the default template fields
   * with page specific ones
   * @return array The array of fields
   */
  public function getFields() {
    $template = $this->getTemplate();
    $loaded_post_fields = [];

    if (!empty($template)) {
      $loaded_post_fields = $this->getFieldsByPageTemplate($template);
    } else {
      $loaded_post_fields = [];
    }

    return array_merge(
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
    // Don't do anything if post already loaded
    if (isset($this->_wp_page_template)) {
      return $this->_wp_page_template;
    }

    if ($_GET['preview'] == 'true' && !empty($this->post_parent)) {
      // First check if this is a preview and if we need to get the parent ID
      $post_id = $this->post_parent;
    } else if ($_GET['preview'] == 'true' && !empty($_GET['preview_id'])) {
      // For some reason, sometimes the preview_id is set and sometimes it isn't
      $post_id = $_GET['preview_id'];
    } else if (!empty($this->ID)) {
      // Next, if this object has an ID then use it
      $post_id = $this->ID;
    } else if (!empty($_POST['post_ID'])) {
      // Now we get into weird cases in the admin or previewing where we need to get the post ID from global vars
      // When loading the page, it's in the POST vars
      $post_id = $_POST['post_ID'];
    } else if (!empty($_POST['post_id'])) {
      // I have no idea why ID is sometimes capitalized and sometimes it's not
      $post_id = $_POST['post_id'];
    } else if (!empty($_GET['post'])) {
      // When saving the page, it's in the GET vars
      $post_id = $_GET['post'];
    } else if (!empty($_GET['revision'])) {
      // We always need the parent when this is a revision
      $revision = get_post($_GET['revision']);
      $post_id = $revision->post_parent;
    }

    if(empty($post_id)) {
      return false;
    }

    $post_object = get_post($post_id);
    if( is_object($post_object)) {
      $this->_wp_page_template = get_page_template_slug($post_object);

      if ($this->_wp_page_template === '') {
        $this->_wp_page_template = 'default';
      }

      if (isset($this->_wp_page_template)) {
        return $this->_wp_page_template;
      }
    }

    return false;
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
}
