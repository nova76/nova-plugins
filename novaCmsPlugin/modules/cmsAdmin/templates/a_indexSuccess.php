<?php use_helper('I18N', 'Date', 'jQuery') ?>
<?php include_partial('cmsAdmin/assets') ?>

<div id="sf_admin_container" class="list-cmsadmin">
  <?php include_partial('cmsAdmin/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('cmsAdmin/list_header', array('pager' => $pager)) ?>
  </div>

  
      <div id="sf_admin_bar ui-helper-hidden" style="display:none">
      <?php include_partial('cmsAdmin/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
  
  <div id="sf_admin_content">
    
      <?php include_partial('cmsAdmin/list_actions', array('helper' => $helper)) ?>
      
      <?php include_partial('cmsAdmin/before_list', array('pager' => $pager)) ?>  
      
      <div id='sf_admin_list_cmsAdmin'>
        <?php include_partial('cmsAdmin/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?>
      </div>
      
      <?php include_partial('cmsAdmin/after_list', array('pager' => $pager)) ?>  

            
      </div>

  <div id="sf_admin_footer">
    <?php include_partial('cmsAdmin/list_footer', array('pager' => $pager)) ?>
  </div>

  <?php include_partial('cmsAdmin/themeswitcher') ?>
</div>

  <?php include_partial('cmsAdmin/dialogShow') ?>

  <?php include_partial('cmsAdmin/dialogEdit') ?>

  <?php include_partial('cmsAdmin/dialogNew') ?>

  <?php include_partial('cmsAdmin/afterRemoteDelete') ?>