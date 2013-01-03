<?php if ($actions = $this->configuration->getValue('list.actions')): ?>
  <div class="sf_admin_actions_block float<?php echo sfConfig::get('app_sf_admin_theme_jroller_plugin_list_actions_position') ?>">
    <a tabindex="0" href="#sf_admin_actions_menu" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all" id="sf_admin_actions_button">
      <span class="ui-icon ui-icon-triangle-1-s"></span>
      [?php echo __('Actions') ?]
    </a>
    <div id="sf_admin_actions_menu" class="ui-helper-hidden fg-menu fg-menu-has-icons">
      <ul class="sf_admin_actions" id="sf_admin_actions_menu_list">
      <?php $hotkeys = '' ?>
		  <?php foreach ($actions as $name => $params):
		    $params['params'] = UIHelper::addClasses($params, ''); ?>
        <?php if (isset($params['hotkey'])): ?>
        <?php 
           $hotkeys .= "jQuery(document).bind('keydown', '".$params['hotkey']."' ,function (evt){ 
              jQuery('li.sf_admin_action".$name." > a')[0].onclick();
              return false; 
            });";
         ?>
        <?php endif ?>
		
		
		    <?php if ('_new' == $name): ?>
		      <?php if ($params['jq_dialogbox'] = $this->configuration->getValue('list.actions._new.jq_dialogbox')):?>
		        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDialogNew('.$this->asPhp($params).') ?]', $params)."\n" ?>
		      <?php else: ?>
		        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToNew('.$this->asPhp($params).') ?]', $params)."\n" ?> 
		      <?php endif; ?>
		    <?php elseif ('_show' == $name): ?>
		      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToShow($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
		
		    <?php else: ?>
		    <li class="sf_admin_action_<?php echo $params['class_suffix'] ?> fg-menu-has-icons">
		      <?php $params['label'] .= UIHelper::addIcon($params); ?>
		      <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, false), $params)."\n" ?>
		    </li>
		    <?php endif; ?>
		  <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php if ($hotkeys): ?>
    [?php jq_add_plugin('jquery.hotkeys.min'); ?]
    <script type='text/javascript'>
    <?php echo $hotkeys; ?>
    </script>
  <?php endif ?>
<?php endif; ?>