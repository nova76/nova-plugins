<?php 
class sfEmailTemplateMessager extends Swift_Message
{
  protected $vars = array();
  
  public static function newInstance($subject = null, $body = null, $contentType = null, $charset = null)
  {
    return new self($subject, $body, $contentType, $charset);
  }  
  
  public function getVars()
  {
    return $this->vars ;
  }
  
  public function setVars($vars)
  {
    $this->vars = $vars;
    
    return $this;
  }
  
  public function setBody($body, $contentType = null, $charset = null)
  {
    foreach ($this->vars as $key => $var)
    {
      $this->$key = $var;
    }

    $body = $this->parseContent($body);
    
    return parent::setBody($body, $contentType, $charset);  
  }
  
  
  protected function parseContent($body)
  {
    $pattern = '/{(\s*[a-zA-Z0-9\.\_]*\s*)}/';
    preg_match_all($pattern, $body, $matches);
    foreach ($matches[0] as $match)    
    {
      /* a kapott egyezoseget feldaraboljuk "." elvalaszto altal */
      $variables = explode('.', str_replace(array(' ', '{', '}'), array('', '', '') , $match));
      /* a kaott tomb elso eleme tartalmazza a valtozo nevet  */
      $value = $this->$variables[0];
      array_shift($variables);
      /* minden tovabbi elem pedig annak egyik propertyje */
      
      foreach ($variables as $variable)
      {
        $value = $value->$variable;
      }
      /* az utolso elem lehet egy doctrine collection is */
      if ($value instanceof Doctrine_Collection)
      {
        $string = '<ul>'; 
        foreach ($value as $element)
        {
          $string .= '<li>'.(string)$element.'</li>';
        }
        $string .= '</ul>';
        $value = $string;
      }
      /* a tartalombnan ki kell cserelni az egyezoseget a kapott ertekre */
      $body = str_replace ($match, $value, $body);
    }
    return $body;
  }  
}  