<?php 
// models/TimestampBehavior.php

class sfCreatorSaveBehavior extends Doctrine_Template
{
    public function setTableDefinition()
    {
      $this->hasColumn('created_by', 'integer', '8');
      $this->hasColumn('updated_by', 'integer', '8');

      $this->hasOne('sfGuardUser as Creator', array(
              'local' => 'created_by',
              'foreign' => 'id'
          )
      );    

      $this->hasOne('sfGuardUser as Modifier', array(
              'local' => 'updated_by',
              'foreign' => 'id'
          )
      );    
      
      $this->addListener(new sfCreatorSaveListener());
    }
}
