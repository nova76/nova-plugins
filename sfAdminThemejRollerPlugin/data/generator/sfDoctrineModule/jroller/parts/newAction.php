  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this-><?php echo $this->getSingularName() ?> = $this->form->getObject();
    
    <?php if ($this->configuration->getValue('list.layout') == 'nestedset'): ?>
    $parent = $request->hasParameter('id') ? $this->getRoute()->getObject() :$this->makeRoot();
    $this->form->setDefault('root_id', $parent->getId()); 
    <?php endif ?>    

    $this->dispatcher->notify(new sfEvent($this, 'admin.new_object', array('object' => $this-><?php echo $this->getSingularName() ?>)));
  }
