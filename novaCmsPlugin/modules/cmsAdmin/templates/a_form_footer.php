<script type="text/javascript">

/***
 * Pacth for dialog-fix ckeditor problem [ by ticket #4727 ]
 * 	http://dev.jqueryui.com/ticket/4727
 */

$.extend($.ui.dialog.overlay, { create: function(dialog){
	if (this.instances.length === 0) {
		// prevent use of anchors and inputs
		// we use a setTimeout in case the overlay is created from an
		// event that we're going to be cancelling (see #2804)
		setTimeout(function() {
			// handle $(el).dialog().dialog('close') (see #4065)
			if ($.ui.dialog.overlay.instances.length) {
				$(document).bind($.ui.dialog.overlay.events, function(event) {
					var parentDialog = $(event.target).parents('.ui-dialog');
					if (parentDialog.length > 0) {
						var parentDialogZIndex = parentDialog.css('zIndex') || 0;
						return parentDialogZIndex > $.ui.dialog.overlay.maxZ;
					}
					
					var aboveOverlay = false;
					$(event.target).parents().each(function() {
						var currentZ = $(this).css('zIndex') || 0;
						if (currentZ > $.ui.dialog.overlay.maxZ) {
							aboveOverlay = true;
							return;
						}
					});
					
					return aboveOverlay;
				});
			}
		}, 1);
		
		// allow closing by pressing the escape key
		$(document).bind('keydown.dialog-overlay', function(event) {
			(dialog.options.closeOnEscape && event.keyCode
					&& event.keyCode == $.ui.keyCode.ESCAPE && dialog.close(event));
		});
			
		// handle window resize
		$(window).bind('resize.dialog-overlay', $.ui.dialog.overlay.resize);
	}
	
	var $el = $('<div></div>').appendTo(document.body)
		.addClass('ui-widget-overlay').css({
		width: this.width(),
		height: this.height()
	});
	
	(dialog.options.stackfix && $.fn.stackfix && $el.stackfix());
	
	this.instances.push($el);
	return $el;
}});

$(function() {	

  function slugize(str) 
  {
    str = str.toLowerCase();
    str = str.replace(/á/g,"a");
    str = str.replace(/Á/g,"a");
    str = str.replace(/é/g,"e");
    str = str.replace(/É/g,"e");
    str = str.replace(/í/g,"i");
    str = str.replace(/Í/g,"i");
    str = str.replace(/ó/g,"o");
    str = str.replace(/Ó/g,"o");
    str = str.replace(/ö/g,"o");
    str = str.replace(/Ö/g,"o");
    str = str.replace(/ő/g,"o");
    str = str.replace(/Ő/g,"o");
    str = str.replace(/ú/g,"u");
    str = str.replace(/Ú/g,"u");
    str = str.replace(/ü/g,"u");
    str = str.replace(/Ü/g,"u");
    str = str.replace(/ű/g,"u");
    str = str.replace(/Ű/g,"u");
    str = str.replace(/[^A-Za-z0-9\-_]/g,"-");
    
    return str
  }
  
  $('.title').bind('keyup', function(event){
    title_id = $(this).attr('id') ;
    slug_id = title_id.replace('title', 'slug') ;
    $('#'+slug_id).val(slugize($('#'+title_id).val()));
  })

  $('.slug').bind('change', function(){
    slug_id = $(this).attr('id') ;
    title_id = slug_id.replace('slug', 'title') ;
    if ($('#'+slug_id).val() != slugize($('#'+title_id).val()))
    {
      $('#'+title_id).unbind('keyup');  
    }
  })


})  
</script>