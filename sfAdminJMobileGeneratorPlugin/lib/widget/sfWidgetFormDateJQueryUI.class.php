<?php

/**
 * @author     Artur Rozek
 * @version    1.0.0
 */
class sfWidgetFormDateJQueryUI extends sfWidgetForm
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   * @param string   culture           Sets culture for the widget
   * @param boolean  change_month      If date chooser attached to widget has month select dropdown, defaults to false
   * @param boolean  change_year       If date chooser attached to widget has year select dropdown, defaults to false
   * @param integer  number_of_months  Number of months visible in date chooser, defaults to 1
   * @param boolean  show_button_panel If date chooser shows panel with 'today' and 'done' buttons, defaults to false
   * @param string   theme             css theme for jquery ui interface, defaults to '/sfFormExtraPlugin/css/ui-lightness/jquery-ui.css'
   * 
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {

    if(sfContext::hasInstance())
     $this->addOption('culture', sfContext::getInstance()->getUser()->getCulture());
    else
     $this->addOption('culture', "hu");
    $this->addOption('change_month',  true);
    $this->addOption('change_year',  true);
    $this->addOption('number_of_months', 1);
    $this->addOption('show_button_panel',  false);
    $this->addOption('image',  '/sfFormExtraPlugin/images/calendar.gif');
    $this->addOption('theme', '/sfFormExtraPlugin/css/ui-lightness/jquery-ui.css');
    
    $this->addOption('year_range', '-20:+20');
    $this->addOption('show_week',  false);
    $this->addOption('inline', true);
    
    parent::configure($options, $attributes);
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
  
    //return '<input type="text" class="datepicker">';
    
    $image = '';
    
    $attributes = array_merge($attributes, $this->getAttributes());

    
    
    if (!$this->getOption('inline'))
    {
      $input = new sfWidgetFormInput(array(), $attributes);
      $html = $input->render($name, $value);
      if (false !== $this->getOption('image'))
      {
        $image = sprintf('params.buttonImage = "%s"; params.buttonImageOnly = true; params.showOn = "button";', $this->getOption('image'));
      }
    }
    else 
    {
        $id = $this->generateId($name);
        $html = '<div id="'.$id.'"></div>';
    }

    $id = $this->generateId($name);
    $culture = $this->getOption('culture');
    
    $html .= <<<EOHTML
<script type="text/javascript">
	$(function() {
    // datepicker inicializálás
    $('#$id').datepicker({
      dateFormat: 'yy-mm-dd',
      altField: '#dateStart',
      inline: true,
      showOtherMonths: true
//      minDate: new Date(),
//      defaultDate: $('#dateStart').val(),
      
    });    
  });      
</script>
EOHTML;

    
    
    return $html;
  }

 /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    //return array();
    //parent::getStylesheets()
    $css['/sfJqueryReloadedPlugin/css/jquery.ui.datepicker.mobile.css'] = 'all';
    return $css;
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    
    //return array();
    
    $js[] = "/sfJqueryReloadedPlugin/js/plugins/jquery.ui.datepicker.js";
    $js[] = "/sfJqueryReloadedPlugin/js/plugins/jquery.ui.datepicker-hu.js";
    $js[] = "/sfJqueryReloadedPlugin/js/plugins/jquery.ui.datepicker.mobile.js";
    return $js;
  } 
}
