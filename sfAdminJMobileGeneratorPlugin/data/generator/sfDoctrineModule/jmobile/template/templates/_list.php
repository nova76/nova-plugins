
<div class="sf_admin_list ui-grid-table ui-widget ui-corner-all ui-helper-reset ui-helper-clearfix">

  [?php if (!$pager->getNbResults()): ?]

      <?php $configuration = $this->configuration  ?>
      
      <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
        [?php include_partial('<?php echo $this->getModuleName() ?>/filter', compact('hasFilters')) ?]
      </div>	  
      
      <p align="center">[?php echo __('No result', array(), 'sf_admin') ?]</p>

  [?php else: ?]

      <?php $configuration = $this->configuration  ?>
      
      <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
        [?php include_partial('<?php echo $this->getModuleName() ?>/filter', compact('hasFilters')) ?]
      </div>
      

      <ul data-role="listview" data-divider-theme="b" data-inset="true" data-filter="true" data-filter-placeholder="[?php echo __('Filter items...') ?]">
      <li data-role="list-divider" role="heading">
         [?php echo __('Name'); ?]
      </li>
      
      [?php foreach ($pager->getResults() as $i => $<?php echo $this->getSingularName() ?>): $odd = fmod(++$i, 2) ? ' odd' : '' ?]
      <li data-theme="c">
        
        [?php $display = array(); ?]
        <?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
          [?php $display['<?php echo $name ?>'] = $<?php echo $this->getModuleName()?>->get('<?php echo $name ?>'); ?]
        <?php endforeach; ?>        
      
        <?php $route = $this->configuration->getValue('list.route') ?  $this->configuration->getValue('list.route') : '$helper->getUrlForAction(\'edit\')'; ?>
        
        <?php echo $this->addCredentialCondition('[?php echo link_to(implode(" - ", $display), '.$route.', $'.$this->getModuleName().', array()); ?]'); ?>
      </li>
    [?php endforeach; ?]
    </ul>
  [?php endif; ?]
</div>
