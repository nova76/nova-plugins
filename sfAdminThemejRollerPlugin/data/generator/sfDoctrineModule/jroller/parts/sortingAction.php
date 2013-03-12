<?php if ($this->configuration->getValue('list.layout') == 'nestedset'): ?>
  protected function addSortQuery($query)
  {
    $query->addOrderBy('root_id asc');
    $query->addOrderBy('lft asc');
    // $query->addWhere('deleted_at is null');
    $query->addWhere('level <> 0');
  } 
<?php else: ?>
  protected function addSortQuery($query)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

    $config = $this->configuration->getValue('list.fields.'.$sort[0]);
    
    $config = $config ? $config->getConfig() : array();
    
    if (isset($config['is_real']) && TRUE == $config['is_real'])
    {
      $query->addOrderBy($sort[0] . ' ' . $sort[1]);
    }
    elseif(isset($config['is_sortable']) && TRUE == $config['is_sortable'])
    {
      $rootAlias = $query->getRootAlias();
      if (isset($config['function']) && $config['function']!==false)
      {
        call_user_func(array($this, $config['function']), $query);
      }
      /** ha van peer, akkor kapcsolni kell a tablat **/
      elseif (isset($config['peer']) && $config['peer']!==false)
      {
        /** ha van alias, akkor azzal az aliassal **/
        if (isset($config['alias']) && $config['alias']!==false)
        {
          $alias = $config['alias'];
        }
        /** vagy a peer lesz az alias is **/
        else
        {
          $alias= sfInflector::camelize($config['peer']);
        }
        $query->leftJoin($rootAlias.'.'.$config['peer'].' '.$alias);
      }
      /** ha nincs peer, de van alias akkor nem kell kapcsolni a tablat, de mar van kapcsolt tabla **/
      elseif (isset($config['alias']) && $config['alias']!==false)
      {
        $alias = $config['alias'];
      }
      /** ha nincs peer, és nincs alias sem, akkor csak egy szarmaztatott mezo a root tablaban. **/
      else
      {
        $alias = $rootAlias;
      }
    
      if (is_array($config['sort']))
      {
        foreach ($config['sort'] as $sortfield)
        {
          $query->addOrderBy($alias.'.'.$sortfield. ' ' . $sort[1]);
        }
      }
      else
      {
        if (isset($config['alias']) && $config['alias']===false)
        {
          $query->addOrderBy($config['sort'] . ' ' . $sort[1]);
        }  
        else
        {
          $query->addOrderBy($alias.'.'.$config['sort'] . ' ' . $sort[1]);
        }
      }
      
    }
    else
    {
      $query->addOrderBy($sort[0] . ' ' . $sort[1]);
    }
        
    
  }
<?php endif; ?>
  
  protected function getSort()
  {
    if (!is_null($sort = $this->getUser()->getAttribute('<?php echo $this->getModuleName() ?>.sort', null, 'admin_module')))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute('<?php echo $this->getModuleName() ?>.sort', null, 'admin_module');
  }


  protected function setSort(array $sort)
  {
    if (!is_null($sort[0]) && is_null($sort[1]))
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('<?php echo $this->getModuleName() ?>.sort', $sort, 'admin_module');
  }