<?php

class jRollerDoctrineGenerator extends sfDoctrineGenerator
{
  /**
   * Gets extra parameters for jRoller plugin.
   *
   * @return mixed
   */
  public function getExtra($value = false)
  {
    if (isset($this->params['extra']))
    {
      if ($value)
      {
        foreach ($this->params['extra'] as $val)
        {
          if ($val == $value) return true;
        }
        return false;
      }
      else
      {
        return $this->params['extra'];
      }
    }
    else
    {
      return array();
    }
  }

  /**
   * Returns HTML code for a field.
   * !!!IMPORTANT!!! generator.yml -> generator: / class: sfDoctrineGenerator => jRollerDoctrineGenerator
   * 
   * @param sfModelGeneratorConfigurationField $field The field
   *
   * @return string HTML code
   */
  public function renderField($field)
  {
    $html = $this->getColumnGetter($field->getName(), true);

    if ($renderer = $field->getRenderer())
    {
      $html = sprintf("$html ? call_user_func_array(%s, array_merge(array(%s), %s)) : '&nbsp;'", $this->asPhp($renderer), $html, $this->asPhp($field->getRendererArguments()));
    }
    else if ($field->isComponent())
    {
      return sprintf("get_component('%s', '%s', array('type' => 'list', '%s' => \$%s))", $this->getModuleName(), $field->getName(), $this->getSingularName(), $this->getSingularName());
    }
    else if ($field->isPartial())
    {
      return sprintf("get_partial('%s', array('configuration'=> \$configuration,  'type' => 'list', '%s' => \$%s))", $field->getName(), $this->getSingularName(), $this->getSingularName());
    }
    else if ('Date' == $field->getType())
    {
      $html = sprintf("false !== strtotime($html) ? format_date(%s, \"%s\") : '&nbsp;'", $html, $field->getConfig('date_format', 'f'));
    }
    else if ('Boolean' == $field->getType())
    {
      $html = sprintf("get_partial('%s/list_field_boolean', array('value' => %s))", $this->getModuleName(), $html);
    }

    if ($field->isLink())
    {
      $html = sprintf("link_to(%s, '%s', \$%s)", $html, $this->getUrlForAction(($this->getExtra('show') == true)?'show':'edit'), $this->getSingularName());
    }

    return $html;
  }
  
  public function getLinkToAction($actionName, $params, $pk_link = false)
  {
    $action = isset($params['action']) ? $params['action'] : 'List'.sfInflector::camelize($actionName);

    $url_params = $pk_link ? '?'.$this->getPrimaryKeyUrlParams() : '\'';

    if (isset($params['extend_url']))
    {
      $url_params .= '.(has_slot(\'sf_admin.extend_url\') ? \''.$params['extend_url'].'\'.get_slot(\'sf_admin.extend_url\') : \'\')';
    }

    return '[?php echo link_to(__(\''.$params['label'].'\', array(), \''.$this->getI18nCatalogue().'\'), \''
    .(isset($params['module']) ? $params['module'] : $this->getModuleName()).
    '/'.$action.$url_params.', '.$this->asPhp($params['params']).') ?]';
  }  
  
}
