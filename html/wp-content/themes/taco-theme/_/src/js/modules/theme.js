// sample module
var poachedEggsTheme = function() {
  // vars
  
  // functions
  
  // make videos in wysiwyg responsive
  function makeVideosResponsive() {
   $('.content').find('iframe').wrap('<div class="flex-video"></div>');
  }
  
  // colorwheel on sample page
  var samplePageColorwheel = function() {
    var box_json_html = '<div class="sample-page-colorwheel-json"></div>';
    var box_grid_html = '<h3 class="center">All Theme Colors</h3>';
    box_grid_html += '<div class="sample-page-colorwheel"><ul></ul></div>';

    // create elements then add vars
    var create_samplepage_elements = function(callback) {
      // add box to samplepage
      $('body.sample-page .content').append(box_grid_html);
      $('body.sample-page .content').append(box_json_html);
      callback();
    };
    
    var populate_colorwheel = function() {
      // colors to object
      var colorsDataEl = $('.sample-page-colorwheel-json');
      var colorsData = colorsDataEl.sassToJs({pseudoEl:":before", cssProperty: "content"});
      colorsDataEl.html(JSON.stringify(colorsData));
      // create the grid
      $.each(colorsData, function(index, data) {
        $('.sample-page-colorwheel ul').append('<li><span class="color" style="background: ' + data + ';"></span><span class="hex"><span class="label">'+ index + '</span> : ' + data +'</span></li>');
      });
    };
    
    // init the creation of the colorwheel
    create_samplepage_elements(populate_colorwheel);
    
  };
  
  
  // inits
  samplePageColorwheel();

};
    
    
export default poachedEggsTheme;