<?php 
// models/TimestampBehavior.php

class sfLogBehavior extends Doctrine_Template
{
    public function setTableDefinition()
    {
      $this->addListener(new sfLogListener($this->_options));
    }
    
    
}
