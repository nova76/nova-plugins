  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $obj = $this->getRoute()->getObject();
    
    if ($obj->getTable()->hasTemplate('Doctrine_Template_SoftDelete') && !is_null($obj->deleted_at))
    {
      $this->redirect404();
    }
    
    if ($this->configuration->getValue('list.layout') == 'nestedset')
    {
      $obj->getNode()->delete();
    }
    $this->getRoute()->getObject()->delete();  

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
