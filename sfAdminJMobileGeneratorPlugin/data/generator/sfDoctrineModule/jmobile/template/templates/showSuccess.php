[?php use_helper('I18N', 'Date', 'PartialExists') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div data-role="page" id="page" data-cache="never" data-ajax="false">
    
    <div data-theme="a" data-role="header">
        <h3>[?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('show.title') ?> ?]</h3>
        [?php include_partial('<?php echo $this->getModuleName() ?>/show_actions', array('show' =>'header', 'form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration, 'helper' => $helper)) ?]
    </div>
    
    <div id="sf_jmobile" data-role="content" class="list-<?php echo mb_strtolower($this->getModuleName()) ?>">
       <div class="content-primary">
          [?php include_partial('<?php echo $this->getModuleName() ?>/show_actions', array('show' =>'top', 'form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration, 'helper' => $helper)) ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/flashes', array( 'form' => $form )) ?]
          [?php include_partial('show', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration)) ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/show_actions', array('show' =>'bottom', 'form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration, 'helper' => $helper)) ?]
        </div >
        
        [?php if (has_partial('global/content-secondary')) : ?]
          [?php include_partial('global/content-secondary') ; ?]
        [?php endif ?]    
    </div>
     
</div>  