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
    $this->addOption('inline', false);
    
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
    $cm = $this->getOption("change_month") ? "true" : "false";
    $cy = $this->getOption("change_year") ? "true" : "false";
    $nom = $this->getOption("number_of_months");
    $sbp = $this->getOption("show_button_panel") ? "true" : "false";
    $sw = $this->getOption("show_week") ? "true" : "false";
    $yearRange = $this->getOption("year_range");
    
    $jsClass = $this->getJsClass();
    
    $extraParamsArray = $this->getExtraParams();
    $extraParams = "";
    if (is_array($extraParamsArray))
    {
      foreach ($extraParamsArray as $key=> $p)
      {
        $extraParams .= "params.$key=$p;\r\n";
      }
    }
    
    if ($culture!='en')
    {
    $html .= <<<EOHTML
<script type="text/javascript">
	$(function() {
    var params = $.datepicker.regional['$culture'];
    params.changeMonth = $cm;
    params.changeYear = $cy;
    params.numberOfMonths = $nom;
    params.showButtonPanel = $sbp;
    params.showWeek = $sw;
    params.yearRange = '$yearRange' ; 
    selectWeek = true;
    closeOnSelect = false;    
    $image
    $extraParams
    $("#$id").$jsClass(params);
	});
</script>
EOHTML;
    }
    else
    {
    $html .= <<<EOHTML
<script type="text/javascript">
	$(function() {
    var params = {
    changeMonth : $cm,
    changeYear : $cy,
    numberOfMonths : $nom,
    showButtonPanel : $sbp };
    params.showWeek = $sw;
    params.yearRange = '$yearRange' ; 
    $image
    $extraParams
    $("#$id").$jsClass(params);
	});
</script>
EOHTML;
    }

    return $html;
  }

  protected function getJsClass()
  {
    return 'datepicker';
  }
  
  /**
   * @return array
   */
  protected function getExtraParams()
  {
    return array();
  }
  
  
 /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array();
    $theme = $this->getOption('theme');
    return array($theme => 'screen');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    return array();
    //check if jquery is loaded
    $js = array();
    /*
    if (sfConfig::has('sf_jquery_web_dir') && sfConfig::has('sf_jquery_core'))
      $js[] = sfConfig::get('sf_jquery_web_dir').'/js/'.sfConfig::get('sf_jquery_core');
    else
      $js[] = '/sfJQueryUIPlugin/js/jquery-1.3.1.min.js';
     
    
    $js[] = '/sfJQueryUIPlugin/js/jquery-ui.js';
   */
    
    $culture = $this->getOption('culture');
    if ($culture!='en')
      $js[] = '/sfFormExtraPlugin/js/i18n/jquery.ui.datepicker-'.$culture.".js";
    
    return $js;
  } 
}
