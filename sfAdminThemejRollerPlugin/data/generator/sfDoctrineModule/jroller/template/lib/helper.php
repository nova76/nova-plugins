[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: helper.php 12482 2008-10-31 11:13:22Z fabien $
 */
class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  static protected $icons = null;


  public function linkToDialogShow($object, $params)
  {
    $params['ui-icon'] = $this->getIcon('show', $params);
    return '<li class="sf_admin_action_show">'.
      jq_link_to_remote(
        UIHelper::addIcon($params) . __($params['label'], array(),  '<?php $this->getI18nCatalogue()?>'), 
        array(
          'update' => $params['jq_dialogbox'], 
          'url'    => url_for( array_merge(array('sf_route' => $this->getUrlForAction('show')), array('sf_subject' => $object))),
          'method' => 'GET',
          'before' => 'jQuery("#'.$params['jq_dialogbox'].'").html();',
          'after'  => 'jQuery("#'.$params['jq_dialogbox'].'").dialog(\'open\');' 
        ), 
        $params['params']
        ).'</li>';
  }  

  public function linkToDialogNew($params)
  {
    if (!key_exists('ui-icon', $params)) $params['ui-icon'] = '';
    $params['params'] = UIHelper::addClasses($params, '');
    $params['ui-icon'] = $this->getIcon('new', $params);
    return '<li class="sf_admin_action_new">'.
      jq_link_to_remote(
        UIHelper::addIcon($params) . __($params['label'], array(),  '<?php $this->getI18nCatalogue()?>'), 
        array(
          'update' => $params['jq_dialogbox'], 
          'url'    => url_for( array_merge(array('sf_route' => $this->getUrlForAction('new')))),
          'method' => 'GET',
          'before' => 'jQuery("#'.$params['jq_dialogbox'].'").html();',
          'after'  => 
             'jQuery("#'.$params['jq_dialogbox'].'").dialog( "option", "title", "'.<?php echo $this->getI18NString('new.title') ?>.'"); 
              jQuery("#'.$params['jq_dialogbox'].'").dialog("open");'
             
        ), 
        $params['params']
      ).'</li>';
  }
  
  public function linkToDialogEdit($object, $params)
  {
    $params['ui-icon'] = $this->getIcon('edit', $params);
    return '<li class="sf_admin_action_edit">'.
      jq_link_to_remote(
        UIHelper::addIcon($params) . __($params['label'], array(),  '<?php $this->getI18nCatalogue()?>'), 
        array(
          'update' => $params['jq_dialogbox'], 
          'url'    => url_for( array_merge(array('sf_route' => $this->getUrlForAction('edit')), array('sf_subject' => $object))),
          'method' => 'GET',
          'before' => 'jQuery("#'.$params['jq_dialogbox'].'").html();',
          'after'  => '
            jQuery("#'.$params['jq_dialogbox'].'").dialog(\'open\');
            jQuery("#'.$params['jq_dialogbox'].'").dialog( "option", "title", "'.<?php echo $this->getI18NString('edit.title') ?>.'");' 
        ), 
        $params['params']
      ).'</li>';
  }

  public function getCSRFValue()
  {
    if (!isset($this->csrfValue))
    {
      $this->getBaseCsrfToken();
    }
    return $this->csrfValue;
  }

  public function getCSRFFieldName()
  {
    if (!isset($this->csrfFieldName))
    {
      $this->getBaseCsrfToken();
    }
    return $this->csrfFieldName;
  }

  public function getBaseCsrfToken()
  {
    if (!isset($this->csrfToken))
    {
      $form = new BaseForm();
      if ($form->isCSRFProtected())
      {
        $this->csrfFieldName = $form->getCSRFFieldName();
        $this->csrfValue     = $form->getCSRFToken();
        $this->csrfToken = "'".$form->getCSRFFieldName()."':'".$form->getCSRFToken()."'";
      }
      else
      {
        $this->csrfFieldName = '';
        $this->csrfValue     = '';
        $this->csrfToken     = '';
      }
    }
    
    return $this->csrfToken;
  }

  public function linkToRemoteDelete($object, $params)
  {
    $params['params'] = UIHelper::arrayToString(array('class' => UIHelper::getClasses($params['params']).' ui-priority-secondary'));
    $params['ui-icon'] = $this->getIcon('delete', $params);
    
    if ($object->isNew())
    {
      return '';
    }
    
    $this->getBaseCsrfToken();
    
    return '<li class="sf_admin_action_delete">'.
      jq_link_to_remote(
        UIHelper::addIcon($params) . __($params['label'], array(), '<?php $this->getI18nCatalogue()?>'), 
        array(
          'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), '<?php $this->getI18nCatalogue()?>') : $params['confirm'],
          'url'     => url_for( array_merge(array('sf_route' => $this->getUrlForAction('delete')), array('sf_subject' => $object))),
          'method'  => 'POST',
          'with'    => "{'sf_method':'delete'".($this->csrfToken ? ','.$this->csrfToken :'')."}",
          'before'  => "<?php echo $this->getModuleName() ?>RemoteDelete.tr = jQuery(this).parents('tr')[0]", 
          'success' => "<?php echo $this->getModuleName() ?>RemoteDelete.success(data, textStatus, XMLHttpRequest);" 
        ), 
        $params['params']
      ).'</li>';
  }  

  public function linkToShow($object, $params)
  {
    $params['ui-icon'] = $this->getIcon('show', $params);
    $params = $this->getAdminExtendUrl($params);    
    return '<li class="sf_admin_action_show">'.link_to(UIHelper::addIcon($params) . __($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object, $params['params']).'</li>';
  }

  public function linkToNew($params)
  {
    if (!key_exists('ui-icon', $params)) $params['ui-icon'] = '';
    $params['params'] = UIHelper::addClasses($params, '');
    $params['ui-icon'] = $this->getIcon('new', $params);
	$params = $this->getAdminExtendUrl($params);    
	return '<li class="sf_admin_action_new">'.link_to(UIHelper::addIcon($params) . __($params['label'] , array(), 'sf_admin'), '@'.$this->getUrlForAction('new'), $params['params']).'</li>';
  }

  public function linkToEdit($object, $params)
  {
    $params['ui-icon'] = $this->getIcon('edit', $params);
	$params = $this->getAdminExtendUrl($params); 
    return '<li class="sf_admin_action_edit">'.link_to(UIHelper::addIcon($params) . __($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object, $params['params']).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    $params['params'] = UIHelper::arrayToString(array('class' => UIHelper::getClasses($params['params']).' ui-priority-secondary'));
    $params = $this->getAdminExtendUrl($params);    

    if ($object->isNew())
    {
      return '';
    }

    $params['ui-icon'] = $this->getIcon('delete', $params);
    return '<li class="sf_admin_action_delete">'.link_to(UIHelper::addIcon($params) . __($params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, array('class' => UIHelper::getClasses($params['params']),'method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  }

  public function linkToList($params)
  {
    $params['ui-icon'] = $this->getIcon('list', $params);
	$params = $this->getAdminExtendUrl($params); 
    return '<li class="sf_admin_action_list">'.link_to(UIHelper::addIcon($params) . __($params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('list'),$params['params']).'</li>';
  }

  public function linkToSave($object, $params)
  {
    $params['ui-icon'] = $this->getIcon('save', $params);
	$params = $this->getAdminExtendUrl($params); 
    return '<li class="sf_admin_action_save"><button type="submit" class="fg-button ui-state-default fg-button-icon-left">'. UIHelper::addIcon($params) . __($params['label'], array(), 'sf_admin').'</button></li>';
  }

  public function linkToSaveAndAdd($object, $params)
  {
    $params['ui-icon'] = $this->getIcon('saveAndAdd', $params);
	$params = $this->getAdminExtendUrl($params); 

    if (!$object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_save_and_add"><button type="submit" name="_save_and_add" class="fg-button ui-state-default fg-button-icon-left">'. UIHelper::addIcon($params) . __($params['label'], array(), 'sf_admin').'</button></li>';
  }

  public function getAdminExtendUrl($params)
  {
    if (strpos($params['params'], 'query_string')===false)
    {
      $params['params'] .=  'query_string='._encodeText(get_slot('sf_admin.extend_url')) ;
    }
    else
    {
      $params['params'] = str_replace('query_string=', 'query_string='._encodeText(get_slot('sf_admin.extend_url').'&'), $params['params']);
    }
  
    return $params; 
  }
  
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }

  protected function getIcon($type, $params)
  {
    return (empty($params['ui-icon']) && $params['ui-icon']!==false) ? UIHelper::getIcon($type) : $params['ui-icon'];
  }
}
