<?php

/**
 * PluginMailTemplate form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginMailTemplateFormFilter extends BaseMailTemplateFormFilter
{
  public function setup()
  {
    parent::setup();
    unset($this['created_at'], $this['updated_at'], $this['deleted_at']);
  }  
}
