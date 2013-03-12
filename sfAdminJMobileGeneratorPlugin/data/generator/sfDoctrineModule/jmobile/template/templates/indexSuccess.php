[?php use_helper('I18N', 'Date', 'jQuery', 'PartialExists') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div data-role="page" id="page" data-cache="never" data-ajax="false">
    
    <div data-theme="a" data-role="header">
        <h3>[?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('list.title') ?> ?]</h3>

      <?php if ($actions = $this->configuration->getValue('list.actions')): ?>        
        <?php foreach ($actions as $name => $params): ?>
          <?php echo $this->addCredentialCondition('[?php echo $helper->linkToNew('.$this->asPhp($params).') ?]', $params)."\n" ?> 
        <?php endforeach; ?>  
      <?php endif  ?>        
      
    </div>
    
    <div id="sf_jmobile" data-role="content" class="list-<?php echo mb_strtolower($this->getModuleName()) ?>">

        <div class="content-primary">
          [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/filter', array('form' => $filters, 'configuration' => $configuration)) ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('configuration' => $configuration, 'pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?]
        </div >
        
        [?php if (has_partial('global/content-secondary')) : ?]
        [?php include_partial('global/content-secondary') ; ?]
        [?php endif ?]
  
    </div>
   
</div>  

