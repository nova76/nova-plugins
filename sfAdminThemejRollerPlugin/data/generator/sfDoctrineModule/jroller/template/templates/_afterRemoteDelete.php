<script type='text/javascript'>
  var <?php echo $this->getModuleName() ?>RemoteDelete = { 
	  tr : null, //// table row, which has been deleted.
	  success : function (data, textStatus, XMLHttpRequest)
	  {
	    if (data == '"success"')
	    {
	    	<?php if (!$this->configuration->getValue('list.object_actions._delete.afterRemote')): ?>
	    	  <?php echo $this->getModuleName() ?>RemoteDelete.refreshList();
	    	<?php else: ?>   		    
	    	  <?php echo $this->getModuleName() ?>RemoteDelete.<?php echo $this->configuration->getValue('list.object_actions._delete.afterRemote') ?>();    
		    <?php endif ?> 
	    }
		},
    removeRow : function ()
    {
      tr = <?php echo $this->getModuleName() ?>RemoteDelete.tr;
	    jQuery(tr).remove();
		},
		refreshList : function ()
		{
			jQuery('#sf_admin_list_<?php echo $this->getModuleName() ?>').load('[?php echo url_for('<?php echo $this->getModuleName()?>/refreshList'); ?]');
	  }
  }
</script>

	 