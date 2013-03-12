<?php 
class sfFirePHPPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    require_once dirname(__FILE__).'/../lib/FirePHPCore/fb.php';
  }
}
