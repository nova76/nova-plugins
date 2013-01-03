  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this-><?php echo $this->getSingularName() ?> = $this->form->getObject();

    $this->dispatcher->notify(new sfEvent($this, 'admin.create_object', array('object' => $this-><?php echo $this->getSingularName() ?>)));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
