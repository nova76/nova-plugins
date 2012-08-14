(function( $ ){
  $.fn.otherlist = function( options ) {  
    var settings = {
      'other'         : null,
      'default'       : null,
    };
    return this.each(function() {        
      settings.value = jQuery(this).val() 
      if ( options ) { 
        $.extend( settings, options );
      }
      $(this).children('option').remove();
      var target = this;
      $('#'+settings['other']+" option:selected").each(function(){
        $(target).append($(this).clone());
      });       
      if (settings.value)
      {
        $(target).val(settings.value);
      }
      else
      {
        $(target).val(settings.default);
      }
    });
  };
})( jQuery );

