<?php

class alladminTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'generate';
    $this->name             = 'all-admin';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [all-admin|INFO] task does things.
Call it with:
  
  [php symfony all-admin|INFO]
EOF;
  }

  /**
   * Loads all Doctrine builders.
   */
  protected function loadModels()
  {
    Doctrine_Core::loadModels($this->configuration->getModelDirs());
    $models = Doctrine_Core::getLoadedModels();
    $models =  Doctrine_Core::initializeModels($models);
    $models = Doctrine_Core::filterInvalidModels($models);
    //$this->models = $this->filterModels($models);

    return $models; //$this->models;
  }  
  
  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $modules = $this->loadModels();
    
    
    foreach ($modules as $module)
    {
      $question = $this->ask('geenrate modul for '.$module.' table?');
      if ($question == 'e')
      {
        break;
      }
      if ($question == 'y')
      {
        $this->runTask('doctrine:generate-admin', array('application' => $options['application'], 'module' => $module ), array('theme'=>'jmobile'));
        $this->runTask('doctrine:generate-admin', array('application' => $options['application'], 'module' => $module ));
        $this->logSection ('modules', $module. 'generálása megtörtént'); //$module
      }
    }
    
    // add your code here
  }
}
