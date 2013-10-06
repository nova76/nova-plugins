<?php jq_add_plugin('jquery.form'); ?>
<?php use_helper('Url') ?>

<div id="new_dialog" style="display:none"></div>
<script type="text/javascript"> 
jQuery(document).ready(function() {
	jQuery('#new_dialog').dialog({ 
	    autoOpen:false, 
	    title: '<?php echo __('Új tartalom rögzítése', array(), 'messages') ?>', 
      minWidth: 600,  
	    modal: true,
	    buttons: {
	      Save: function() {
		      jQuery('.sf_admin_form form').ajaxForm({
            success: function(data){
		          jQuery('#new_dialog').html(data);
		    	    <?php include_partial('afterDialogEdit'); ?>
		        }
          });
          jQuery('.sf_admin_form form').submit();  
        },
	      Close: function() {
          jQuery('#new_dialog').html('');
        	jQuery('#new_dialog').dialog('close');
	      }  
	   }	    
	});
});	 
</script>
