<?php foreach (array('new', 'edit') as $action): ?>
<?php if ('new' == $action): ?>
[?php if ($form->isNew()): ?]
<?php else: ?>
[?php else: ?]
<?php endif; ?>
<?php foreach ($this->configuration->getValue($action.'.actions') as $name => $params): ?>

  <?php if (isset($params['show'])): ?>
  [?php if (in_array($show, <?php echo $this->asPhp($params['show']); ?>)): /* show */ ?] 
  <?php endif; ?>

    <?php if (!key_exists('ui-icon', $params)) $params['ui-icon'] = ''; ?>
		<?php $params['params'] = UIHelper::addClasses($params); ?>

  <?php if ( isset( $params['condition'] ) ): ?>
      [?php if ( <?php echo ( isset( $params['condition']['invert'] ) && $params['condition']['invert'] ? '!' : '') . '$' . $this->getSingularName( ) . '->' . $params['condition']['function'] ?>( <?php echo ( isset( $params['condition']['params'] ) ? $params['condition']['params'] : '' ) ?> ) ): ?] 
  <?php endif; ?>

    <?php if ('_list' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToList('.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_show' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToShow($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_delete' == $name): ?>
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_save_and_add' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSaveAndAdd($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_save' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSave($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php else: ?>
    	<?php $params['label'] .= UIHelper::addIcon($params); ?>
        [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
          <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo'.$method.'($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
        [?php else: ?]
          <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
        [?php endif; ?]
    <?php endif; ?>

  <?php if ( isset( $params['condition'] ) ): ?>
    [?php endif; ?]
  <?php endif; ?>
  
  <?php if (isset($params['show'])): ?>
  [?php endif; /* show */ ?]
  <?php endif; ?>
  

<?php endforeach; ?>
<?php endforeach; ?>
[?php endif; ?]
