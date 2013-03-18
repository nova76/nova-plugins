
(function($){
//before
	
$.fn.nestedset = function(options) {
  return this.each(function(){
	$.each(options, function(index, value) {
	  $.fn.nestedset.defaults[index] = value;
	});
	var csrf = options.csrf;
    var indexUrl = options.indexUrl;
    
  
    $.jstree._themes = "sfJqueryReloadedPlugin/js/plugins/themes/";
    
    $(this).bind("before.jstree", function (e, data) {
      if(data.func === "delete_node") { 
        
        var res = $.fn.nestedset.deleteNode($(data.args[0]));
       	if (res.status != 200)
       	{
       	  e.stopImmediatePropagation();
       	  return false;
       	}	
       		
      }   
    }); 

    $(this).bind("move_node.jstree", function (e, data) {
       var defaults = $.fn.nestedset.defaults;
       $.ajax({
      	 type: 'POST',
      	 async: false,
      	 dataType: 'json',
      	 url: defaults.indexUrl + '/' + 'moveNode' ,
      	 data : { 
      	        'id'      : $(data.rslt.o).attr('id').replace(defaults.idprefix, ''),
                'parent'  : (data.rslt.cr === -1 ? 1 : data.rslt.np.attr("id").replace(defaults.idprefix, '')),
                'prev'    : ($(data.rslt.o).prev().length == 0 ? false : $(data.rslt.o).prev().attr('id').replace(defaults.idprefix, '')),
                'next'    : ($(data.rslt.o).next().length == 0 ? false : $(data.rslt.o).next().attr('id').replace(defaults.idprefix, ''))
              },
         error: function (r, textStatus, XMLHttpRequest){
      	   $.jstree.rollback(data.rlbk);
      	 }
       });
    });       
    
       

    $(this).jstree({
      "core" : {},        	
      "plugins" : ["html_data", "themes", "ui", "crrm", "cookies", "hotkeys", "contextmenu", "dnd"],
      "themes" : {
        theme : "default",
        url: "/sfJqueryReloadedPlugin/js/plugins/themes/default/style.css"  
      },
      "contextmenu" : {
        items: { 
          rename: false,
	      ccp: false,
	      //remove: marad az eredeti
	      create : {
	 	    "label"       : "New",
	 	    "action"      : function (obj) { $.fn.nestedset.newNode(obj)},
	        "separator_before"  : false,
	        "separator_after" : true,
	        "icon"        : false,
	        "submenu"     : false
	      }, 
	      edit : {
	        "label"       : "Edit",
	        "action"      : function (obj) { $.fn.nestedset.editNode(obj)}, 
	        "separator_before"  : false,  
	        "separator_after" : true,   
	        "icon"        : false,
	        "submenu"     : false 
	      },  
	      show : {
		        "label"       : "Show",
		        "action"      : function (obj) { $.fn.nestedset.showNode(obj)}, 
		        "separator_before"  : false,  
		        "separator_after" : true,   
		        "icon"        : false,
		        "submenu"     : false 
		      }  	      
        }
      }          
    })
    //jQuery(this).jstree("open_all");      
  });
};

$.fn.nestedset.defaults = {
		indexUrl: '', 
		csrfValue: null, 
		csrfFieldName:null,
		dialogNewBoxId  : 'tree-dialog-show',
		dialogEditBoxId : 'tree-dialog-edit',
		dialogShowBoxId : 'tree-dialog-show',
		treeId : 'tree',
		prefix : ''	
};

$.fn.nestedset.showNode = function (node){
	  var defaults = $.fn.nestedset.defaults;
	  if (arguments.length > 0) { node = arguments[0]; node = node.parent('li'); }
	  else node = $("#"+defaults.treeId).jstree("get_selected");
	  if (node.length==0) return false;
	  $('#'+$.fn.nestedset.defaults.dialogShowBoxId).load(
	    $.fn.nestedset.defaults.indexUrl + '/' + node.attr('id').replace(defaults.idprefix, ''), 
	    function(){$('#'+defaults.dialogShowBoxId).dialog('open');}
	  )
}

$.fn.nestedset.editNode = function (node){
	  var defaults = $.fn.nestedset.defaults;
	  if (arguments.length > 0) { node = arguments[0]; node = node.parent('li'); }
	  else node = $("#"+defaults.treeId).jstree("get_selected");
	  if (node.length==0) return false;
	  $('#'+$.fn.nestedset.defaults.dialogEditBoxId).load(
	    $.fn.nestedset.defaults.indexUrl + '/' + node.attr('id').replace(defaults.idprefix, '') + '/edit', 
	    function(){$('#'+defaults.dialogEditBoxId).dialog('open');}
	  )
} 

$.fn.nestedset.deleteNode = function (node){
  var defaults = $.fn.nestedset.defaults;
  var res = false;
  var id = $(node).attr('id').replace(defaults.idprefix, '');
  var data = {'sf_method': 'delete'};
  data[defaults.csrfFieldName] = defaults.csrfValue;
  $.ajax({
  	type: 'POST',
  	async: false,
  	url: defaults.indexUrl + '/' + id,
  	data : data,
      success: function (data, textStatus, XMLHttpRequest){ res = data },
      error:   function (data, textStatus, XMLHttpRequest){ res = data },      
      dataType: 'json'
  });
  return res;		
}



$.fn.nestedset.newNode = function (parentNode){
  var defaults = $.fn.nestedset.defaults;
  if (arguments.length > 0) { parentNode = arguments[0]; parentNode = parentNode.parent('li'); }	  
  else parentNode = $("#"+defaults.treeId).jstree("get_selected")
  if (parentNode.length==0) return false;
  $('#'+$.fn.nestedset.defaults.dialogNewBoxId).load(
	defaults.indexUrl + '/' + parentNode.attr('id').replace(defaults.idprefix, '') + '/new', 
    function(){ $('#'+defaults.dialogNewBoxId).dialog('open'); }
  )          
}


//end
})($);



