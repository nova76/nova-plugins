(function( $ ){
  Date.prototype.getWeek = function() {
  	var onejan = new Date(this.getFullYear(),0,1);
  	return Math.ceil((((this - onejan) / 86400000) + onejan.getDay())/7);
  } 
  Date.prototype.getWeekMonday = function() {
  	var res = new Date();
  	(this.getDay() == 0) ? res.setTime(this.getTime() - (6 * 86400000)) : res.setTime(this.getTime() + 86400000 - (this.getDay() * 86400000));
  	return res;
  } 
  
  Date.prototype.getWeekSunday = function() {
  	res = this.getWeekMonday()
  	res.setTime(res.getTime() + 6*86400000);
  	return res;
  }   

  Date.prototype.fromString = function(myString) {
    var parts = myString.split(/[- :]/);
    this.setFullYear(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));  
    // this.setFullYear(parts[0]);  
    // this.setMonth(parts[1] - 1);  
    // this.setDate(parts[2]);  
  } 
  
  $.fn.weeklyDatepicker = function( options ) {  
    var settings = {
      'from_id'             : null,
      'to_id'               : null
    };
    return this.each(function() {        
      settings.value = jQuery(this).val() 
      if ( options ) { 
        $.extend( settings, options );
      }

      var date = new Date();  
      date.fromString($('#'+settings.from_id).val());
      $(this).datepicker("setDate", date);  
      
      $(this).datepicker("option", "beforeShowDay", function(date) { 
    			var selectedWeek = $(this).datepicker("getDate").getWeek();	
    			var thisWeek = date.getWeek();
    			if (selectedWeek == thisWeek)	
    			{
    				$('#'+settings.from_id).val($.datepicker.formatDate('yy-mm-dd', date.getWeekMonday()))
    				$('#'+settings.to_id).val($.datepicker.formatDate('yy-mm-dd', date))
    				return [1,'has_event'];					
    			}
          return [1] 
    	})
    	
      $(this).datepicker("option", "onSelect", function(dateText) { 
        var date = new Date();  
        date.fromString(String(dateText))
    		$('#'+settings.from_id).val($.datepicker.formatDate('yy-mm-dd', date.getWeekMonday()))
    		$('#'+settings.to_id).val($.datepicker.formatDate('yy-mm-dd', date.getWeekSunday()))
    	  $('#'+settings.from_id).trigger('change');
      });
    	
    });
  };
})( jQuery );