[?php use_helper('I18N', 'Date') ?]

<?php if ($this->configuration->getValue('list.object_actions._show.jq_dialogbox')): ?>
  
  <div id="sf_admin_container" class="sf_admin_edit ui-widget ui-widget-content ui-corner-all">
    [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
    [?php include_partial('show', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration)) ?]
  </div>
  
<?php else: ?>

  [?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]
  
  <div id="sf_admin_container" class="sf_admin_edit ui-widget ui-widget-content ui-corner-all">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
      <h1>[?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('show.title') ?> ?]</h1>
    </div>
  
    [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
    
    <div class="sf_admin_actions_block ui-widget">
        [?php include_partial('<?php echo $this->getModuleName() ?>/show_actions', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration, 'helper' => $helper)) ?]
    </div>
  
    <div class="ui-helper-clearfix"></div>
  
    [?php include_partial('show', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration)) ?]
  
    [?php include_partial('<?php echo $this->getModuleName() ?>/show_footer', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]
    
    [?php include_partial('<?php echo $this->getModuleName() ?>/themeswitcher') ?]
  </div>
  
<?php endif?>