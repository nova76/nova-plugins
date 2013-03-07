<?php

class CreateRebuildScriptsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', '', sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'generate';
    $this->name             = 'rebuild-scripts';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF

    Generate cc/build/load/save scripts
    
Call it with:
  
  [php symfony generate:rebuild-scripts|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    
    $databaseManager = new sfDatabaseManager($this->configuration);
    $database = $databaseManager->getDatabase($options['connection']);
    $connection = $database->getConnection();    
    
    $username = $database->getParameter( 'username' );
    $password = $database->getParameter( 'password' );
    preg_match('/dbname=(\w+)/', $database->getParameter( 'dsn' ), $dbname);
    $dbname = $dbname[1];
    

    $file = sfConfig::get('sf_root_dir').'/cc';
    file_put_contents($file, './symfony cc');
    chmod($file, 0777);

    $file = sfConfig::get('sf_root_dir').'/load';
    file_put_contents($file, "mysql -u$username -p$password $dbname < dump.sql");
    chmod($file, 0777);
    
    $file = sfConfig::get('sf_root_dir').'/save';
    file_put_contents($file, "mysqldump -t -c -u$username -p$password $dbname > dump.sql");
    chmod($file, 0777);

    $file = sfConfig::get('sf_root_dir').'/save_date';
    file_put_contents($file, "mysqldump -t -u$username -p$password $dbname > \"dump`date +%Y%m%d%H%M%S`.sql\"");
    chmod($file, 0777);
    
    $file = sfConfig::get('sf_root_dir').'/rebuild';
    file_put_contents($file, "./save \r\n./save_date \r\n./build  \r\n./load \r\n./cc"); 
    chmod($file, 0777);

    $file = sfConfig::get('sf_root_dir').'/build';
    file_put_contents($file, "./symfony doctrine:build --all"); 
    chmod($file, 0777);
    
    
    
  }
}
