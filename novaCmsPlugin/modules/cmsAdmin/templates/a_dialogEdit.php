<?php jq_add_plugin('jquery.form'); ?>
<?php use_helper('Url') ?>

<div id="edit_dialog" style="display:none"></div>
<script type="text/javascript"> 
jQuery(document).ready(function() {
	jQuery('#edit_dialog').dialog({ 
	    autoOpen:false, 
	    title: '<?php echo __('Tartalom szerkesztése', array(), 'messages') ?>', 
      minWidth: 600,  
	    modal: true,
	    buttons: {
	      Save: function() {
		      jQuery('.sf_admin_form form').ajaxForm({
            success: function(data){
		          jQuery('#edit_dialog').html(data);
		    	    <?php include_partial('afterDialogEdit'); ?>
		        }
          });
          jQuery('.sf_admin_form form').submit();  
        },
	      Close: function() {
          jQuery('#edit_dialog').html('');
        	jQuery('#edit_dialog').dialog('close');
	      }  
	   }	    
	});
});	 
</script>
