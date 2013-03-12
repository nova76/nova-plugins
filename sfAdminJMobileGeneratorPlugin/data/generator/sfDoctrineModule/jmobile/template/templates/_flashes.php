<div class="sf_admin_flashes ui-widget">
  [?php if ($sf_user->hasFlash('notice')): ?]
    <ul data-role="listview" data-inset="true" data-divider-theme="e" data-count-theme="b">
      <li data-role="list-divider" role="heading"> 
        [?php echo __($sf_user->getFlash('notice', ESC_RAW), array(), 'sf_admin') ?]
      </li>  
    </ul>
    [?php $sf_user->setFlash('notice', null) ?]  
  [?php endif; ?]
  
  [?php if (isset($form) && $form->hasErrors()): ?]
    <ul data-role="listview" data-inset="true" data-theme="e" data-divider-theme="f" data-count-theme="b">
      [?php if ($sf_user->hasFlash('error')): ?]  
        <li data-role="list-divider" role="heading"> 
          [?php echo __($sf_user->getFlash('error', ESC_RAW), array(), 'sf_admin') ?]
        </li>  
        [?php $sf_user->setFlash('error', null) ?]
      [?php endif; ?]     
      [?php $sf_user->setFlash('error', null) ?]
      [?php foreach($form->getWidgetSchema()->getPositions() as $widgetName): ?]
        [?php  if($form[$widgetName]->hasError()): ?]
          [?php $error = $form[$widgetName]->getWidget() instanceof sfWidgetFormSchema ? $form[$widgetName]->getGlobalErrors($form[$widgetName]->getError()) : $form[$widgetName]->getError(); ?] 
          [?php if ($error instanceof sfValidatorErrorSchema) : ?] 
           [?php foreach ($error as $e): ?] 
             <li> 
               [?php echo $form[$widgetName]->renderLabelName().': '.__($e->getMessageFormat()); ?] 
             </li>  
           [?php endforeach; ?] 
          [?php else : ?] 
            <li> 
              [?php echo $form[$widgetName]->renderLabelName().': '.__($form[$widgetName]->getError()->getMessageFormat()) ?] 
            </li>
          [?php endif ?] 
        [?php endif; ?] 
      [?php endforeach ?]
    </ul>
  [?php elseif ($sf_user->hasFlash('error')): ?]
    <ul data-role="listview" data-inset="true" data-theme="e" data-divider-theme="f" data-count-theme="b">
      <li data-role="list-divider" role="heading"> 
        [?php echo __($sf_user->getFlash('error', ESC_RAW), array(), 'sf_admin') ?]
      </li>  
    </ul>
   [?php $sf_user->setFlash('error', null) ?]
  [?php endif; ?]
</div>