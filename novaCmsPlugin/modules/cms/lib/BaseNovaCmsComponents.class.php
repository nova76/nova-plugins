<?php

class BaseNovaCmsComponents extends sfComponents
{
  public function executeShowContent()
  {
    if (!isset($this->slug) || (!$this->page = CmsTable::getInstance()->retrieveBySlug(array('slug' => $this->slug))))
    {
      throw new sfException('hianyzo slug');
    }
  }

  
  /**
   * html:
   *    - directory-layout: ebben a formaban jelenit meg egy konyvtarat
   *      pl: <div class="moduletable"><h3>%title%</h3>%content%</div>
   * 
   *    - template : megadja hogy a menu milyen szerkeszetben jelenjen meg. 
   *      Alapesetben "list" (ul-li) vagy "table" szerkeszet lehet, de keszitheto egyedi szerkeszet is.
   *      Ehhez uj fajl letrehozasa szukseges _showDirectoryEgyedi neven
   */
  public function executeShowMap()
  {
    if (!isset($this->html) || !isset($this->html['direcory-layout']))
    {
      $this->html['direcory-layout'] = '<div class="cms-direcory"><h3>%title%</h3>%content%</div>';
    }
    if (!isset($this->html) || !isset($this->html['template']))
    {
      $this->html['direcory-layout'] = 'list';
    }
    
    $treeObject = Doctrine_Core::getTable('Cms')->getTree();
    
    $event = $this->dispatcher->filter(new sfEvent($this, 'novaCms.component.getTree'), $treeObject);
    $treeObject = $event->getReturnValue();
    
    $this->root = $treeObject->fetchRoot();
  }


  /**
   * @see executeShowMap
   *
   * @param Cms $directory ($this->directory)
   */
  public function executeShowDirectory()
  {
    
  }
  
  /**
  *  template : megadja hogy komponens jeleniti meg a menut.
  *  layout   : hogyan jeleniti meg a visszakapott templatet.
  */
  public function executeMenu()
  {
    $this->template = isset($this->template) ? $this->template  : 'menuItem';
    $this->layout   = isset($this->layout)   ? $this->decorator : '<ul id="fomenu">%s</ul>';

    if (isset($this->slug))
    {
       $this->root = Doctrine_Core::getTable('Cms')->retrieveBySlug(array('slug'=>$this->slug));
    }
    else 
    {
      $treeObject = Doctrine_Core::getTable('Cms')->getTree();  
      $this->root = $treeObject->fetchRoot();
    }
    
    $event = $this->dispatcher->filter(new sfEvent($this, 'novaCms.component.getMenu'), $this->root);
    $treeObject = $event->getReturnValue();
    
    
  }

  /**
   * Enter description here...
   *
   */
  public function executeMenuItem()
  {
    $this->children = $this->child->getNode()->getChildren();
    $this->template = isset($this->template) ? $this->template : 'list';
  }   
}