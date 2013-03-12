<?php
function change_input_hidden($form, $name)
{
  $widgetSchema = $form->getWidgetSchema();
  $widgetSchema[$name] = new sfWidgetFormInputHidden();
  return $widgetSchema[$name];   
}
?>