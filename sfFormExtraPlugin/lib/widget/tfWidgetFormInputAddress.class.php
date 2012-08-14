<?php
class tfWidgetFormInputAddress extends sfWidgetFormInput
{

  public function configure($options = array(), $attributes = array())
  {
    $this->addOption('iformat', "%postcode%&nbsp;%city%&nbsp;%address%");
    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    
    if (is_array($value))
    {
      $values = array($value['postcode'], $value['city'], $value['address']);
    }
    elseif ($value)
    {
      $values = explode('|', $value);  
    }
    elseif(!$value)
    {
      $values = array('', '', '');
    }
    
    $sfWidget = new sfWidgetFormInputText();
    $postcode = $sfWidget->render($name.'[postcode]', $values[0], array('maxlength'=>5, 'style'=>'width:50px'));
    $city     = $sfWidget->render($name.'[city]', $values[1], array('style'=>'width:100px'));
    $address  = $sfWidget->render($name.'[address]', $values[2], array('style'=>'width:200px'));
    $res = str_replace(array('%postcode%', '%city%', '%address%'), array($postcode, $city, $address), $this->getOption('iformat'));
    return $res; // parent::render($name, $value, $attributes, $errors);
  }
}