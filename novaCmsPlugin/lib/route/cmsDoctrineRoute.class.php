<?php 
class cmsDoctrineRoute extends sfDoctrineRoute
{
  public function matchesUrl($url, $context = array())
  {
    if (false === $parameters = parent::matchesUrl($url, $context))
    {
      return false;
    }

    if (!$parameters['slug'])
    {
      return false;
    }
    
    if ($res = parent::matchesUrl($url, $context))
    {
      $page = Doctrine_Core::getTable('Cms')->retrieveBySlug($parameters);
    }

    
    if (!$page)
    {
      return false;
    }
    else
    {
      $this->object = $page;
    }

    return $res;
  }
}