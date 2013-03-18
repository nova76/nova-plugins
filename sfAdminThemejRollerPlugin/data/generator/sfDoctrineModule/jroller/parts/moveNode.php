
  /**
  * node mozgatasa
  * jsont var visza
  *
  */
  public function executeMoveNode(sfWebRequest $request)
  {
    $node   = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($request->getParameter('id'));
    
    if ($request->getParameter('prev') == 'false' && $request->getParameter('next') == 'false')
    {
      $parent = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($request->getParameter('parent'));
      $node->getNode()->moveAsFirstChildOf($parent);  
    }  
    elseif ($request->getParameter('prev') == 'false')
    {
      $next = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($request->getParameter('next'));
      $node->getNode()->moveAsPrevSiblingOf($next);
      
    }
    else
    {
      $prev = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($request->getParameter('prev'));
      $node->getNode()->moveAsNextSiblingOf($prev);
    }
    
    return $this->renderText('{}'); 
  }