  /**
   * Visszaadja a nestedset rootot
   * Root csak egy lehet es azt kotelezo letrehozni
   *
   * @return <?php echo $this->getModelClass() ?>(root)
   */
  protected function makeRoot()
  {
    $treeObject = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->getTree();
    $root = $treeObject->fetchRoot();
    if (!$root)
    {
      $root = new <?php echo $this->getModelClass() ?>();
      $root->save();
      $treeObject = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->getTree();
      $treeObject->createRoot($root);  
    }  
    
    return $root;
  }