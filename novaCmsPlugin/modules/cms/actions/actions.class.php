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
  }
}