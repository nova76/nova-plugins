[?php use_helper('I18N', 'Date', 'PartialExists') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div data-role="page" id="page" data-cache="never" data-ajax="false">

  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>', array('data-ajax'=>'false')) ?]

    
    <div data-theme="a" data-role="header">
        <h3>[?php echo has_slot('sf_admin.title') ? get_slot('sf_admin.title') : <?php echo $this->getI18NString('edit.title') ?> ?]</h3>
        [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('show' =>'header', '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
    </div>
    
    <div id="sf_jmobile" data-role="content" class="list-<?php echo mb_strtolower($this->getModuleName()) ?>">
       <div class="content-primary">
       
          [?php include_partial('<?php echo $this->getModuleName() ?>/flashes', array( 'form' => $form )) ?]
          
          [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('show' =>'top', '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
          
          <div id="admin-fields-block">
          
            [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
          
          </div>
          
          <div class="ui-helper-clearfix"></div>
          
          [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('show' =>'bottom', '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
        </div >
        
        [?php if (has_partial('global/content-secondary')) : ?]
        [?php include_partial('global/content-secondary') ; ?]
        [?php endif ?]    
    </div>

  </form>
       
</div>  