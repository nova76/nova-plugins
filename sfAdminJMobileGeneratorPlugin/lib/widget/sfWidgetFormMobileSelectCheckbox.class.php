<?php 

/**
 *
 *  sfWidgetFormMobileDoctrineChoice renderer class
 *
 */
class sfWidgetFormMobileSelectCheckbox extends sfWidgetFormSelectCheckbox
{
  public function formatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] = $input['input'].$input['label'];
    }
    
    return !$rows ? '' : $this->renderContentTag('div', implode($this->getOption('separator'), $rows), array("data-role" => "controlgroup", 'class' => $this->getOption('class') ));
  }  
  
}


?>