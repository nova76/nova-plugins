<?php

require_once dirname(__FILE__).'/../lib/sfLogAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sfLogAdminGeneratorHelper.class.php';

/**
 * sfLogAdmin actions.
 *
 * @package    verdij
 * @subpackage sfLogAdmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfLogAdminActions extends autoSfLogAdminActions
{
  
  public function executeGzcTest()
  {
    //$log = sfLogTable::getInstance()->find;
    $logs = sfLogTable::getInstance()->CreateQuery()
            ->addWhere('server_zip is null')
            ->limit(2500)
            ->execute();

    $i_sum = 0;           
    foreach ($logs as $log)            
    {
      $i = 0;
      if (is_null($log->getPostZip()))
      {
        $log->setPostZip(
          gzcompress(
            json_encode(unserialize($log->getPost())) , 9
        ));
        $i = 1;
      }
      if (is_null($log->getRequestZip()))
      {
        $log->setRequestZip(
          gzcompress(
            json_encode(unserialize($log->getRequest())) , 9
        ));
        $i = 1;
      }
      if (is_null($log->getGetZip()))
      {
        $log->setGetZip(
          gzcompress(
            json_encode(unserialize($log->getGet())) , 9
        ));
        $i = 1;
      }
      if (is_null($log->getServerZip()))
      {
        $log->setServerZip(
          gzcompress(
            json_encode(unserialize($log->getServer())) , 9
        ));
        $i = 1;
      }
      $i_sum += $i; 
      $log->save();
    }
            
    fb($i_sum);
           
/*
ALTER TABLE `sf_log`
  DROP `post`,
  DROP `get`,
  DROP `request`,
  DROP `server`;
  
vs.  

update sf_log set server = NULL, request = null, post=NULL, get = NULL;
  
  
    */
       
    die('1');
            
    
    //$log->setPostZip($log->getPost());
    echo '<pre>';
    fb(json_decode(gzuncompress($log->getPostZip()), true));
    
    $log->setPostZip(
      gzcompress(
        json_encode(unserialize($log->getPost())) , 9
    ));
    $log->save();
    
    die('Ok');
    /*
ALTER TABLE sf_log ROW_FORMAT = COMPRESSED ,
KEY_BLOCK_SIZE =4    


SELECT table_schema                                        "DB Name", 
   Round(Sum(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" 
FROM   information_schema.tables 
GROUP  BY table_schema; 
    */
  }
  
}
