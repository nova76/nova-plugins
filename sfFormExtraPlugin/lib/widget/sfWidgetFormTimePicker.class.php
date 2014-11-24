<?php

/**
 * @author     Frey Istvan
 * @version    1.0.0
 */
class sfWidgetFormTimePicker extends sfWidgetFormDateJQueryUI
{
  /**
   * Configures the current widget.
   * 
   * @see sfWidgetFormDateJQueryUI
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addOption('from', null);
    $this->addOption('to', null);
    $this->addOption('minuteGrid', 15);
    $this->addOption('stepMinute', 1);
    $this->addOption('image', false);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return parent::render($name, $value, $attributes, $errors);
  }

  protected function getJsClass()
  {
    return 'timepicker';
  }
  
  
  protected function getExtraParams()
  {
    
    $res = array();
    if ($this->getOption('from'))
    {
      $res['hourMin'] = $this->getOption('from');
    }
    if ($this->getOption('to'))
    {
      $res['hourMax'] = $this->getOption('to');
    }
    $res['minuteGrid'] = $this->getOption('minuteGrid');  
    $res['stepMinute'] = $this->getOption('stepMinute');
    return $res;
  }    
  
 /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    $css = parent::getStylesheets();
    $css['/sfFormExtraPlugin/css/jquery-ui-timepicker-addon.css'] = 'all';    
    return $css;
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    $js = parent::getJavaScripts();
    $js[] = '/sfFormExtraPlugin/js/jquery-ui-timepicker-addon.js'; 
    $culture = $this->getOption('culture');
    if ($culture=='hu')
    {
      $js[] = '/sfFormExtraPlugin/js/i18n-timepicker/jquery-ui-timepicker-hu.js'; 
    }  
    return $js;
  } 
  
}
