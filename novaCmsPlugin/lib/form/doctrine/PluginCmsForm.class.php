<?php

/**
 * PluginCms form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginCmsForm extends BaseCmsForm
{
  public function setup()
  {
    parent::setup();
    unset($this['deleted_at']);
    $this->widgetSchema['root_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['rgt'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['lft'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['level'] = new sfWidgetFormInputHidden();
    
    unset($this['created_at'], $this['updated_at']);
    
    $this->embedI18n(sfConfig::get('app_nova_cms_languages'));    //array('en', 'hu', 'de')
  }
  
}
