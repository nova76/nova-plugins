[?php use_helper('I18N', 'Date') ?]

<div id="sf_admin_container" class="sf_admin_edit ui-widget ui-widget-content ui-corner-all">

<?php if ($this->configuration->getValue('list.object_actions._edit.jq_dialogbox')): ?>

    [?php $actions = false ?]
    
<?php else: ?>

    [?php $actions = true ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]
    
    <div class="fg-toolbar ui-widget-header ui-corner-all">
      <h1>[?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('edit.title') ?> ?]</h1>
    </div>
  
<?php endif?>   
    
	  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes', array('form' => $form)) ?]

    <div id="sf_admin_header">
      [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
    </div>
  
    <div id="sf_admin_content">
      [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('actions' => $actions, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
    </div>

    <div id="sf_admin_footer">
      [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
    </div>
  
    [?php include_partial('<?php echo $this->getModuleName() ?>/themeswitcher') ?]

</div>
