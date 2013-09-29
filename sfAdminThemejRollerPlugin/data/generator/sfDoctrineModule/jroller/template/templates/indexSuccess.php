[?php use_helper('I18N', 'Date', 'jQuery') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container" class="list-<?php echo mb_strtolower($this->getModuleName()) ?>">
  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>
  
  <?php if ($this->configuration->hasFilterForm()): ?>
    <div id="sf_admin_bar ui-helper-hidden" <?php echo ($this->configuration->getFilterTemplate()=='table-caption') ? 'style="display:none"' : '';  ?>>
      [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
    </div>
  <?php endif; ?>

  <div id="sf_admin_content">
    <?php if ($this->configuration->getValue('list.batch_actions')): ?>
      <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post" id="sf_admin_content_form">
      [?php include_partial('<?php echo $this->getModuleName() ?>/include_form_extend_variables', array('configuration' => $configuration, 'helper' => $helper)) ?]
    <?php endif; ?>

      <?php if ($actions = $this->configuration->getValue('list.actions')): ?>
      <div class="sf_admin_actions_block float<?php echo sfConfig::get('app_sf_admin_theme_jroller_plugin_list_actions_position') ?>">
   			[?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
      </div>
      <?php endif ?>	
      
      [?php include_partial('<?php echo $this->getModuleName() ?>/before_list', array('pager' => $pager)) ?]  
      
      <div id='sf_admin_list_<?php echo $this->getModuleName() ?>'>
        [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('configuration' => $configuration, 'pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?]
      </div>
      
      [?php include_partial('<?php echo $this->getModuleName() ?>/after_list', array('pager' => $pager)) ?]  

      <?php if ($this->configuration->getValue('list.batch_actions')): ?>
      <ul class="sf_admin_actions">
        [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
      </ul>
      <?php endif; ?>
      
    <?php if ($this->configuration->getValue('list.batch_actions')): ?>
      </form>
    <?php endif; ?>
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>

  [?php include_partial('<?php echo $this->getModuleName() ?>/themeswitcher') ?]
</div>

<?php if ($this->configuration->getValue('list.object_actions._show.jq_dialogbox')): ?>
  [?php include_partial('<?php echo $this->getModuleName() ?>/dialogShow') ?]
<?php endif ?>

<?php if ($this->configuration->getValue('list.object_actions._edit.jq_dialogbox')): ?>
  [?php include_partial('<?php echo $this->getModuleName() ?>/dialogEdit') ?]
<?php endif ?>

<?php if ($this->configuration->getValue('list.actions._new.jq_dialogbox')): ?>
  [?php include_partial('<?php echo $this->getModuleName() ?>/dialogNew') ?]
<?php endif ?>

<?php if ($this->configuration->getValue('list.object_actions._delete.remote')): ?>
  [?php include_partial('<?php echo $this->getModuleName() ?>/afterRemoteDelete') ?]
<?php endif ?>