  public function executeMoveNode(sfWebRequest $request)
  {
    $parent = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($request->getParameter('parent'));
    $node   = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->findOneById($request->getParameter('id'));
    $position = $request->getParameter('position');
    if ($position == 1)
    {
      $node->getNode()->moveAsFirstChildOf($parent);
    }
    elseif($position == $parent->getNode()->getNumberChildren())
    {
      $node->getNode()->moveAsLastChildOf($parent);
    }
    else
    {
      $q = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->CreateQuery()
          ->addWhere('lft > '.$parent->getLft())
          ->addWhere('rgt < '.$parent->getRgt())
          ->orderby('lft')
          ->limit(2)
          ->offset($position);
      $node->getNode()->moveAsPrevSiblingOf($q->fetchOne());
    }
    
    return sfView::NONE;
  }