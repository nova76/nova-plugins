<?php 
class tfValidatorPhone extends sfValidatorBase
{
  protected function doClean($value)
  {
    $clean = trim((string) $value);
 
    $phone_number_pattern = '(^[+]?[0-9][0-9- ]{7,}[0-9- ]*$)';
 
    if (!$clean && $this->options['required'])
    {
      throw new sfValidatorError($this, 'required');
    }
    // If the value isn't a phone number, throw an error.
    if (!preg_match($phone_number_pattern, $clean))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }
 
    return $clean;
  }
}