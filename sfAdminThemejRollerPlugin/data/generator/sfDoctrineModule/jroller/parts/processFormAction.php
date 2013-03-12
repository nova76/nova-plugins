  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      
      <?php if ($this->configuration->getValue('list.layout') == 'nestedset'): ?>   
      if ( $form->getObject()->isNew()) 
      {
        $notice = 'The item was created successfully.'; 
        $afterSave = true;
      }
      else 
      {
        $afterSave = false;
        $notice = 'The item was updated successfully.';
      }      
      <?php else: ?>      
        $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
      <?php endif ?>      
      
      $<?php echo $this->getSingularName() ?> = $form->save();

      <?php if ($this->configuration->getValue('list.layout') == 'nestedset'): ?>   
      if ($afterSave)
      {
        $root = $this->makeRoot();
        $parent = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($<?php echo $this->getSingularName() ?>->getRootId());
        $root->refresh();
        $parent->refresh();
        $<?php echo $this->getSingularName() ?>->getNode()->insertAsFirstChildOf($parent);
      }        
      <?php endif ?>      
      
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $<?php echo $this->getSingularName() ?>)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@<?php echo $this->getUrlForAction('new') ?>');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirectFromProcessForm($request, $form, $notice);
		
        $this->redirect(array('sf_route' => '<?php echo $this->getUrlForAction('edit') ?>', 'sf_subject' => $<?php echo $this->getSingularName() ?>));
      }
    }
    else
    {
      $flash = '<ul>';
      foreach($form->getWidgetSchema()->getPositions() as $widgetName)
      {
        if($form[$widgetName]->hasError())
        {
          $flash .= '<li>';
          if($widgetName == 'Languages' || $widgetName == 'newLanguages') {
            $flash .= $form[$widgetName]->renderLabelName().': Minden mezőt helyesen tölts ki.';
          } else {
            $flash .= $form[$widgetName]->renderLabelName().': '.$form[$widgetName]->getError()->getMessageFormat();
          }
          $flash .= '</li>';
        }
      }
      $flash .= '</ul>';
      $this->getUser()->setFlash('error', 'Az elem mentése hiba miatt sikertelen volt.<br /><br />'.$flash, false);
    }
  }
  
  protected function redirectFromProcessForm(sfWebRequest $request, sfForm $form, $notice)
  {
    
  }
