<?php

/**
 * PluginCmsTranslation form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginCmsTranslationForm extends BaseCmsTranslationForm
{
  public function setup()
  {
    parent::setup();
    $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE();
    // unset($this['content']);
    $this->widgetSchema['title']->setAttribute('class', 'title');
    //$this->widgetSchema['slug']->setAttribute('class', 'slug');
  }  
  
}
