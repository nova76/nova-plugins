<?php

/**
 * cms actions.
 *
 * @package    verdij
 * @subpackage cms
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cmsActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->page = $this->getRoute()->getObject();
    if ($this->page->get('is_module'))
    {
      $this->redirect($this->page->get('route'));
    } 
    
    $this->getResponse()->setTitle($this->page->getTitle());
    $this->getResponse()->addMeta('keywords', $this->page->getKeywords());
    $this->getResponse()->addMeta('description',  $this->page->getDescription());
    
  }
}