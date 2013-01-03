<?php if ($this->configuration->getValue('list.layout') == 'nestedset'): ?>
  <div style='clear:both;'></div>
<?php endif ?>  

<div class="sf_admin_list ui-grid-table ui-widget ui-corner-all ui-helper-reset ui-helper-clearfix">

  <?php if ($this->configuration->getValue('list.layout') == 'nestedset'): ?>
  <div class="fg-toolbar ui-corner-top ui-widget-header">
      <?php if ($this->configuration->hasFilterForm()): ?>
      <?php $configuration = $this->configuration  ?>
      <?php $template = ($configuration->getFilterTemplate()); ?>
      <?php $filterButtons = $template=='table-caption' ?>
      <?php if ($filterButtons): ?>
      <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
        <a href="#sf_admin_filter" id="sf_admin_filter_button" class="fg-button ui-state-default fg-button-icon-left ui-corner-left">[?php echo UIHelper::addIconByConf('filters') . __('Filters') ?]</a>
        [?php $isDisabledResetButton = ($hasFilters->getRawValue()) ? '' : ' ui-state-disabled' ?]
        [?php echo link_to(UIHelper::addIconByConf('reset') . __('Reset'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'fg-button ui-state-default fg-button-icon-left ui-corner-right'.$isDisabledResetButton)) ?]</span>
      </div>
      <?php endif; ?>
      <?php endif; ?>    
     <h1 class='ui-widget-header'> [?php echo <?php echo $this->getI18NString('list.title') ?> ?] </h1>
  </div>  
  
	[?php // use_helper('jQuery'); ?]
	[?php jq_add_plugin('jquery.cookie'); ?]
	[?php jq_add_plugin('jquery.hotkeys'); ?]
	[?php jq_add_plugin('jquery.form'); ?]
	[?php jq_add_plugin('jquery.jstree.min'); ?]
	[?php jq_add_plugin('jquery.nestedset'); ?]
	
	
  [?php $treeObject = Doctrine_Core::getTable('<?php echo $this->params['model_class']; ?>')->getTree(); ?]  
	[?php $idprefix = "tree_item_"; ?]
	[?php if ($treeObject->fetchRoot()): ?]
	  <div id="tree"> 
	    <?php $display = $this->configuration->getValue('list.display'); 
	          $display = array_keys($display); ?> 
	    <?php if (count($display)==1): ?>
      <?php $display = $display[0] ?> 
	     [?php echo NestedSetHelper::listDump($treeObject, $idprefix<?php echo ', \''.$display.'\''; ?>); ?]
	    <?php else:?> 
	     [?php echo NestedSetHelper::listDump($treeObject, $idprefix); ?]
	    <?php endif?> 
	  </div>
	  
	  <script type="text/javascript">
	   
	   jQuery(function () {
	      jQuery("#tree").nestedset({
	        'indexUrl'         : '[?php echo url_for('@<?php echo $this->params['route_prefix'] ?>'); ?]',
	        'csrfValue'        : '[?php echo $helper->getCSRFValue(); ?]',
	        'csrfFieldName'    :  '[?php echo $helper->getCSRFFieldName(); ?]',
	        'idprefix'         : '[?php echo $idprefix; ?]',
		      'dialogNewBoxId'   : '<?php echo $this->configuration->getValue('list.actions._new.jq_dialogbox') ?>',
		      'dialogEditBoxId'  : '<?php echo $this->configuration->getValue('list.object_actions._edit.jq_dialogbox') ?>',
		      'dialogShowBoxId'  : '<?php echo $this->configuration->getValue('list.object_actions._show.jq_dialogbox') ?>',
	        'treeId'           : 'tree',
	        'prefix'           : 'tree'   
	      });  
	   });
	   
	   </script>
	[?php endif?]
  <?php else:?>  

  [?php if (!$pager->getNbResults()): ?]

  <table>
    <caption class="fg-toolbar ui-widget-header ui-corner-top">
      <?php if ($this->configuration->hasFilterForm()): ?>
      <?php $configuration = $this->configuration  ?>
      <?php $template = ($configuration->getFilterTemplate()); ?>
      <?php $filterButtons = $template=='table-caption' ?>
      <?php if ($filterButtons): ?>	
      <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
        [?php include_partial('<?php echo $this->getModuleName() ?>/filters_buttons', compact('hasFilters')) ?]
      </div>	  
      <?php endif; ?>
      <?php endif; ?>
      <h1><span class="ui-icon ui-icon-triangle-1-s"></span> [?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('list.title') ?> ?]</h1>
    </caption>
    <tbody>
      <tr class="sf_admin_row ui-widget-content">
        <td align="center" height="30">
          <p align="center">[?php echo __('No result', array(), 'sf_admin') ?]</p>
        </td>
      </tr>
    </tbody>
  </table>

  [?php else: ?]

  <table>
    <caption class="fg-toolbar ui-widget-header ui-corner-top">
      <?php if ($this->configuration->hasFilterForm()): ?>
      <?php $configuration = $this->configuration  ?>
      <?php $template = ($configuration->getFilterTemplate()); ?>
      <?php $filterButtons = $template=='table-caption' ?>
      <?php if ($filterButtons): ?>
      <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
        [?php include_partial('<?php echo $this->getModuleName() ?>/filters_buttons', compact('hasFilters')) ?]
      </div>
      <?php endif; ?>
      <?php endif; ?>
      <h1><span class="ui-icon ui-icon-triangle-1-s"></span> [?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('list.title') ?> ?]</h1>
    </caption>

    <thead class="ui-widget-header">
      <tr>
        <?php if ($this->configuration->getValue('list.batch_actions')): ?>
          <th id="sf_admin_list_batch_actions"  class="ui-state-default ui-th-column"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
        <?php endif; ?>

        [?php include_partial('<?php echo $this->getModuleName() ?>/list_th_<?php echo $this->configuration->getValue('list.layout') ?>', array('sort' => $sort)) ?]

        <?php if ($this->configuration->getValue('list.object_actions')): ?>
          <th id="sf_admin_list_th_actions" class="ui-state-default ui-th-column">[?php echo __('Actions', array(), 'sf_admin') ?]</th>
        <?php endif; ?>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <th colspan="<?php echo count($this->configuration->getValue('list.display')) + ($this->configuration->getValue('list.object_actions') ? 1 : 0) + ($this->configuration->getValue('list.batch_actions') ? 1 : 0) ?>">
          <div class="ui-state-default ui-th-column ui-corner-bottom">
            [?php include_partial('<?php echo $this->getModuleName() ?>/pagination', array('pager' => $pager)) ?]
          </div>
        </th>
      </tr>
    </tfoot>

	[?php include_partial('<?php echo $this->getModuleName() ?>/list_body', array('configuration' => isset($configuration) ? $configuration : null, 'pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?]
	
  </table>
    
  [?php endif; ?]
  <?php endif?>
</div>

<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>
