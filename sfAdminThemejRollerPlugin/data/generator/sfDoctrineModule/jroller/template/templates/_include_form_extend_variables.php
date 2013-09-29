[?php  
  if (has_slot('sf_admin.extend_url'))
  {
    $url = get_slot('sf_admin.extend_url');
    foreach (explode('&', $url) as $variable)
    {
      $variable = explode('=', $variable);
      $form  = isset($form) ? $form : new BaseForm();
      echo $form->getWidgetSchema()->renderTag('input', array('type' => 'hidden', 'name' => $variable[0], 'value' => $variable[1], 'id' => false));
    }
  }
?]