<?php

class tfWidgetFormChoiceFromOtherList extends sfWidgetFormChoice
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('other_id');
    $this->addOption('choices', array());
    parent::configure($options, $attributes);
  }     
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $res = parent::render($name, $value, $attributes, $errors);
    $res .="
    <script type=\"text/javascript\">
    $(function() {	
      $('#".$this->getOption('other_id')."').bind('change', function(){
        $('#".$this->generateId($name)."').otherlist({
          'other': '".$this->getOption('other_id')."',
          'default': '".$value."'
        })
      })
      $('#".$this->getOption('other_id')."').trigger('change');  
    })
    </script>" ;
    return $res;
  }
  
  public function getJavaScripts()
  {
    return array('../sfFormExtraPlugin/js/otherlist.js');
  }
   
}