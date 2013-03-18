  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->configuration->getValue('list.layout') == 'nestedset')
    {
      $this->getRoute()->getObject()->getNode()->delete();
    }
    else
    {
      $this->getRoute()->getObject()->delete();  
    }

    if ($request->isXmlHttpRequest())
    {
      return $this->renderText('success');  
    }
    else
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
      $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
    }    
    
  }
