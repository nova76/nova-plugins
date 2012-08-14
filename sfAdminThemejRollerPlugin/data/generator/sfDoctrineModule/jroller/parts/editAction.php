  public function executeEdit(sfWebRequest $request)
  {
    $this-><?php echo $this->getSingularName() ?> = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this-><?php echo $this->getSingularName() ?>);
    $this->dispatcher->notify(new sfEvent($this, 'admin.edit_object', array('object' => $this->getRoute()->getObject())));
  }
