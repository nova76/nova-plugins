<?php 
// models/TimestampListener.php

class sfCreatorSaveListener extends Doctrine_Record_Listener
{
    public function preInsert(Doctrine_Event $event)
    {
      if ($user = sfContext::getInstance()->getUser())
      {
        $event->getInvoker()->created_by = $user->getGuardUser() ? $user->getGuardUser()->getId() : null;  
        $event->getInvoker()->updated_by = $user->getGuardUser() ? $user->getGuardUser()->getId() : null;
      }
    }

    public function preUpdate(Doctrine_Event $event)
    {
     	$modified = $event->getInvoker()->getModified();
   		$modified_old = $event->getInvoker()->getModified(true);
   		if (key_exists('created_by', $modified))
   		{
  			$event->getInvoker()->created_by = $modified_old['created_by'];
   		}
    	
      if ($user = sfContext::getInstance()->getUser())
      {
        $event->getInvoker()->updated_by = $user->getGuardUser() ? $user->getGuardUser()->getId() : null;  
      }
      else
      {
      	if (key_exists('updated_by', $modified))
      	{
      		$event->getInvoker()->updated_by = $modified_old['updated_by'];
      	}
      }	

    }
}
