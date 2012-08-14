<?php
/**
 * WidgetFormInputCheckbox with hidden false value
 *
 */
class tfWidgetFormInputCheckbox extends sfWidgetFormInputCheckbox  
{
 
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {

    $hidden = new sfWidgetFormInputHidden();
    $hidden = $hidden->render($name, 0, array('id'=>false));
    
    $value = ($value == 0) ? null : $value;
    
    $attributes['value'] = 1;
    
    return $hidden.parent::render($name, $value, $attributes, $errors); 
    
  }
}