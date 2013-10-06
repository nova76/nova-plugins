<?php

class BaseSfMailSenderComponents extends sfComponents
{

  public function executeSend()
  {
    if (is_null($this->template_id))
    {
      throw new sfException('Template Id megadása kötelező!');
    }
    
    $template = MailTemplateTable::getInstance()->findOneById($this->template_id);
    
    if (empty($this->from))
    {
      $this->from = array($template->from_mail => $template->from_name);
    }

    $mailer = $this->getMailer();
    
    if (!isset($this->sendOrSave))
    {
      $this->sendOrSave = 'Save';
    }

    $body = $this->parseContent($template);
    
    $i = 0;
    
    foreach ($this->recipients as $email => $name)
    {
      
     if ($layout = isset($this->layout) ? $this->layout : false) 
     {
       $this->getMailer()->setLayout($layout);
     }
     
     if ($this->sendOrSave == 'Save')
     {
        $id = $this->getMailer()->ComposeAndSave(
          $this->from,
          is_array($name) ? $name : array($email => $name),
          isset($this->subject) ? $this->subject : $template->subject,
          array($body, 'text/html')
        );
      }      
      elseif($this->sendOrSave == 'Send')
      {
        $id = $this->getMailer()->ComposeAndSend(
          $this->from,
          is_array($name) ? $name : array($email => $name),
          isset($this->subject) ? $this->subject : $template->subject,
          array($body, 'text/html')
        );
      }  
      $i++;
    }  

    return sfView::NONE;  
    
  }
  
  protected function parseContent($template)
  {
    $body = $template->content;
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