<?php if ($jq_dialogbox = $this->configuration->getValue('list.object_actions._show.jq_dialogbox')): ?>
<div id='<?php echo $jq_dialogbox?>'>&nbsp;</div>
	 <script type="text/javascript"> 
	 jQuery(document).ready(function() {
     jQuery('#<?php echo $jq_dialogbox?>').dialog({ 
          autoOpen:false,
          title: '[?php echo <?php echo $this->getI18NString('show.title') ?> ?]', 
          minWidth: 600,  
          modal: true,
          buttons: {
            Close: function() {
              jQuery('#<?php echo $jq_dialogbox?>').dialog('close')
            }
          }
       }); 
		});
    </script>      
<?php endif; ?>