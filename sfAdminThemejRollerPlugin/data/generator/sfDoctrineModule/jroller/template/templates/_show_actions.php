<?php 
  $actions = $this->configuration->getValue('show.actions') ;
  if (!empty($actions)): ?>
  <ul class="sf_admin_actions_form">
  <?php foreach ($this->configuration->getValue('show.actions') as $name => $params): 
  	//$params['params'] = UIHelper::addClasses($params,'ui-state-default');
      if (!key_exists('ui-icon', $params)) $params['ui-icon'] = '';
      $params['params'] = UIHelper::addClasses($params);
  ?>
  
  <?php if ( isset( $params['condition'] ) ): ?>
      [?php if ( <?php echo ( isset( $params['condition']['invert'] ) && $params['condition']['invert'] ? '!' : '') . '$' . $this->getSingularName( ) . '->' . $params['condition']['function'] ?>( <?php echo ( isset( $params['condition']['params'] ) ? $params['condition']['params'] : '' ) ?> ) ): ?] 
  <?php endif; ?>  
  
  <?php if ('_list' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToList('.$this->asPhp($params).') ?]', $params) ?>
  
  <?php elseif ('_edit' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
  
  <?php elseif ('_delete' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
  
  <?php else: ?>
    <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
  [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo'.$method.'($this->getSingularName(), '.$this->asPhp($params).') ?]', $params) ?>
  
  [?php else: ?]
    <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
  
  [?php endif; ?]
    </li>
  <?php endif; ?>
  
  <?php if ( isset( $params['condition'] ) ): ?>
    [?php endif; ?]
  <?php endif; ?>      
  
  <?php endforeach; ?>
    <li style="height:20px"></li>  
  </ul>
<?php endif ?>