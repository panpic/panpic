(function($){
  var hasPlaceholder = 'placeholder' in document.createElement('input');
  var isOldOpera = $.browser.opera && $.browser.version < 10.5;

  $.fn.placeholder = function(options) {
    var options = $.extend({}, $.fn.placeholder.defaults, options),
    o_left = options.placeholderCSS.left;
    return (hasPlaceholder) ? this : this.each(function() {
      var $this = $(this),
          inputVal = $.trim($this.val()),
          inputWidth = $this.width(),
          inputHeight = $this.height(),
          inputId = (this.id) ? this.id : 'placeholder' + (+new Date()),
          placeholderText = $this.attr('placeholder'),
          placeholder = $('<label for='+ inputId +'>'+ placeholderText + '</label>');
          options.placeholderCSS['width'] = inputWidth;
          options.placeholderCSS['height'] = inputHeight;
          options.placeholderCSS.left = (isOldOpera && (this.type == 'email' || this.type == 'url')) ?
            '11%' : o_left;
          placeholder.css(options.placeholderCSS);
      if (!inputVal){
        $this.wrap(options.inputWrapper);
        $this.attr('id', inputId).after(placeholder);
      };
      $this.focus(function(){
        if (!$.trim($this.val())){
         $this.next().hide();
        };
      });
      $this.blur(function(){
        if (!$.trim($this.val())){
          $this.next().show();
        };
      });
    });
  };
  $.fn.placeholder.defaults = {
    inputWrapper: '<span style="position:relative"></span>',
    placeholderCSS: {
      'font':'0.75em sans-serif', 
      'color':'#bababa', 
      'position': 'absolute', 
      'left':'5px',
      'top':'3px', 
      'overflow-x': 'hidden'
    }
  };
})(jQuery);
