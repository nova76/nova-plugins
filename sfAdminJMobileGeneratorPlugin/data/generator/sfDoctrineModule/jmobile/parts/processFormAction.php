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
        $root = $this->makeRootIfNecessary();
        $parent = CmsTable::getInstance()->findOneById($cms->getRootId());
        $root->refresh();
        $parent->refresh();
        $cms->getNode()->insertAsFirstChildOf($parent);
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
      $this->getUser()->setFlash('error', 'Az elem mentése sikertelen volt.', false);
    }
  }
  
  protected function redirectFromProcessForm(sfWebRequest $request, sfForm $form, $notice)
  {
    
  }
