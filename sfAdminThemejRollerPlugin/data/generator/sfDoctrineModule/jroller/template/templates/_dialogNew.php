[?php jq_add_plugin('jquery.form'); ?]
[?php use_helper('Url') ?]

<?php if ($jq_dialogbox = $this->configuration->getValue('list.actions._new.jq_dialogbox')): ?>
<div id="<?php echo $jq_dialogbox?>" style="display:none"></div>
<script type="text/javascript"> 
jQuery(document).ready(function() {
	jQuery('#<?php echo $jq_dialogbox?>').dialog({ 
	    autoOpen:false, 
	    title: '[?php echo <?php echo $this->getI18NString('new.title') ?> ?]', 
      minWidth: 600,  
	    modal: true,
	    buttons: {
	      Save: function() {
		      jQuery('.sf_admin_form form').ajaxForm({
            success: function(data){
		          jQuery('#<?php echo $jq_dialogbox?>').html(data);
		    	    [?php include_partial('afterDialogEdit'); ?]
		        }
          });
          jQuery('.sf_admin_form form').submit();  
        },
	      Close: function() {
          jQuery('#<?php echo $jq_dialogbox?>').html('');
        	jQuery('#<?php echo $jq_dialogbox?>').dialog('close');
	      }  
	   }	    
	});
});	 
</script>
<?php endif; ?>