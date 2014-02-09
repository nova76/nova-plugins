<?php 
  $actions = $this->configuration->getValue('show.actions') ;
  if (!empty($actions)): ?>
  
  <?php foreach ($this->configuration->getValue('show.actions') as $name => $params): ?>
  
  <?php if (isset($params['show'])): ?>
  [?php if (in_array($show, <?php echo $this->asPhp($params['show']); ?>)): /* show */ ?] 
  <?php endif; ?>
  
  <?php
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
          <?php 
            $params['params'] = @$params['params'] ? $params['params'] : '';
            $params['params'] .= 'data-theme="' . (@$params['data-theme'] ? $params['data-theme'] : 'e') .'"' ; 
          ?> 
         [?php slot('link') ?>
          <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
         [?php end_slot('link') ?> 
         [?php
          echo str_replace('<a ', '<a data-inline="false" data-theme="<?php echo  @$params['data-theme'] ?$params['data-theme'] : 'e' ?>" ui-icon="<?php echo @$params['ui-icon'] ? $params['ui-icon'] : 'check'?>" data-role="button" data-inline="true" data-icon="arrow-l" data-ajax="false" ', get_slot('link')); 
         ?]
  [?php endif; ?]
    
  <?php endif; ?>
  
  <?php if ( isset( $params['condition'] ) ): ?>
    [?php endif; ?]
  <?php endif; ?>    

  <?php if (isset($params['show'])): ?>
  [?php endif; /* show */ ?]
  <?php endif; ?>
  
  <?php endforeach; ?>
<?php endif ?>