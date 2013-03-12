
  protected function compile()
  {
    parent::compile();
    
    $config = $this->getConfig();
    
    // add configuration for the show view 
    $this->configuration['show'] = array( 'fields'         => array(),
                                          'title'          => $this->getShowTitle(),
                                          'actions'        => $this->getShowActions(),
                                          'display'        => $this->getShowDisplay()
                                        ) ;

    foreach (array('show') as $context)
    {
      foreach ($this->configuration[$context]['actions'] as $action => $parameters)
      {
        $this->configuration[$context]['actions'][$action] = $this->fixActionParameters($action, $parameters);
      }
    }
    
    
    $this->configuration['list']['route'] = $this->getListRoute();
    // '@<?php echo $this->getModuleName() ?>'
    
  }
  
  protected function getConfig()
  {
    $configuration = parent::getConfig();
    $configuration['show'] = $this->getFieldsShow();
    return $configuration;
  }  
  
  protected function fixActionParameters($action, $parameters)
  {
    $parameters  = parent::fixActionParameters($action, $parameters);
    if ($action == '_save' and !isset($parameters['show']))
    {
      $parameters['show'] = array('top', 'bottom');
    }
    if ($action == '_delete' and !isset($parameters['show']))
    {
      $parameters['show'] = array('bottom');
    }
    if ($action == '_save_and_add' and !isset($parameters['show']))
    {
      $parameters['show'] = array('bottom');
    }
    if ($action == '_list' and !isset($parameters['show']))
    {
      $parameters['show'] = array('header');
    }
    if ($action == '_show' and !isset($parameters['show']))
    {
      $parameters['show'] = array('top', 'bottom');
    }
    if ($action == '_edit' and !isset($parameters['show']))
    {
      $parameters['show'] = array('top', 'bottom');
    }
    
    
    return $parameters;
  }  