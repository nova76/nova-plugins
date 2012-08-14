<?php
class tfValidatorAddress extends sfValidatorString 
{
  /**
  * @see sfValidator
  */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->addMessage('invalid', 'A cím nem megfelelő, vagy hiányos');
  }
  
  protected function doClean($value)
  {
    $clean = $value;

    if ($this->getOption('required') && (!$value['postcode'] || !$value['city'] || !$value['address']))
    {
      throw new sfValidatorError($this, 'A teljes cím megadása kötelező', array('value' => $value));
    }
    
    
    $clean = $value['postcode'].'|'.$value['city'].'|'.$value['address'];

    parent::doClean($clean);
  
    return $clean;
  }
}
