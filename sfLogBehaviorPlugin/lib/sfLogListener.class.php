<?php 
// models/TimestampListener.php

class sfLogListener extends Doctrine_Record_Listener
{
    
    protected $_options = array('not_logged_fields'=>array());
  
    public function postInsert(Doctrine_Event $event)
    { 
      $log = new sfLog();
      $sfContext = sfContext::getInstance();
      $log->setAction($sfContext->getModuleName().'/'.$sfContext->getActionName());

      /*
      $log->setPost(serialize($_POST));
      $log->setGet(serialize($_GET));
      $log->setRequest(serialize($_REQUEST));
      $log->setServer(serialize($_SERVER));
      */
      
      $log->setPostZip(gzcompress(json_encode($_POST) , 9));      
      $log->setGetZip(gzcompress(json_encode($_GET) , 9));      
      $log->setRequestZip(gzcompress(json_encode($_REQUEST) , 9));      
      $log->setServerZip(gzcompress(json_encode($_SERVER) , 9));      
      $log->setObject(get_class($event->getInvoker()));
      $log->setObjectId($event->getInvoker()->getId());
      $log->setOperation('postInsert');
      $log->setLastModifiedFieldsName(implode(', ', array_keys($event->getInvoker()->toArray())));
      $log->setLastModifiedFieldsValue(serialize($event->getInvoker()->toArray()));
      $log->setOldModifiedFieldsValue('');
      $log->save();
    }
    
    public function __construct($options = array()) 
    {
      if (!empty($options))
      {
        $this->_options = $options;
      }
    }    
    
    public function postUpdate(Doctrine_Event $event)
    { 
      
      $return = true;
      foreach (array_keys($event->getInvoker()->getLastModified()) as $field)
      {
        if (!in_array($field, $this->_options['not_logged_fields']))
        {
          $return = false;
          break;
        }
      }
      if ($return) return;
      
      $log = new sfLog();
      $sfContext = sfContext::getInstance();
      $log->setAction($sfContext->getModuleName().'/'.$sfContext->getActionName());
      $log->setPostZip(gzcompress(json_encode($_POST) , 9));      
      $log->setGetZip(gzcompress(json_encode($_GET) , 9));      
      $log->setRequestZip(gzcompress(json_encode($_REQUEST) , 9));      
      $log->setServerZip(gzcompress(json_encode($_SERVER) , 9));      
      $log->setObject(get_class($event->getInvoker()));
      $log->setObjectId($event->getInvoker()->getId());
      $log->setOperation('postUpdate');
      $log->setLastModifiedFieldsName(implode(', ', array_keys($event->getInvoker()->getLastModified())));
      $log->setLastModifiedFieldsValue(serialize($event->getInvoker()->getLastModified()));
      $log->setOldModifiedFieldsValue(serialize($event->getInvoker()->getLastModified(true)));
      $log->save();
      
    }    
    
}
