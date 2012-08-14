<?php 
class tfCsvForm extends sfForm
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    if (!$options['fields'])
    {
      throw new sfException('The fields options required!');
    }
    parent::__construct($defaults, $options, $CSRFSecret);
    
  }  
  
  public function setup()
  {
    $this->setWidgets(array(
      'fields' => new sfWidgetFormChoice(array('multiple'=>true, 'expanded'=>true, 'choices' => $this->options['fields'])),
    ));

    $this->setValidators(array(
      'fields'        => new sfValidatorChoice(array('multiple'=>true, 'choices' => array_keys($this->options['fields']), 'required' => true)),
    ));

    $this->widgetSchema->setNameFormat('csv[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  protected Function getField($model, $field)
  {
    $deeps = explode('.', $field);
    $res = $model;
    foreach ($deeps as $deep)
    {
      $res = $res[$deep]  ;
    }
    return $res;
  }
  
  public function getCsvContent($records, $fields)
  {
    $formatter = $this->getWidgetSchema()->getFormFormatter();

    $rowBefore = '';
    $rowAfter  = "\r\n";
    $cellBefore = '';
    $cellAfter = ';';
    $cellHeadBefore = '';
    $cellHeadAfter =';';
    $res = $rowBefore;
    
    foreach ($this->values['fields'] as $fieldkey)
    {
      $res .= $cellHeadBefore.iconv('UTF-8', 'WINDOWS-1250', $formatter->translate($this->options['fields'][$fieldkey])).$cellHeadAfter;
    }
    $res .= $rowAfter;
    foreach($records as $record)
    {
     $res .= $rowBefore;
       foreach ($this->values['fields'] as $fieldkey)
       {
         $res .= $cellBefore.iconv('UTF-8', 'WINDOWS-1250', $this->getField($record, $this->options['fields'][$fieldkey])).$cellAfter;
       }
     $res .= $rowAfter;
    } 
    return $res;   
  }
  
}
?>