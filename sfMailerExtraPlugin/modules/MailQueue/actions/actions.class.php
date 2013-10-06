<?php

require_once dirname(__FILE__).'/../lib/MailQueueGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/MailQueueGeneratorHelper.class.php';

/**
 * MailQueue actions.
 *
 * @package    verdij
 * @subpackage MailQueue
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MailQueueActions extends autoMailQueueActions
{
  public function executeBatchSend(sfWebRequest $request)
  {
    $limit = $request->getParameter('limit', 3);
    
    $queues = MailQueueTable::getQueuesForSend($limit, false)->execute();

    $keys = $queues->getPrimaryKeys();
    if (!empty($keys))
    {
      MailQueueTable::getInstance()->CreateQuery('q')
        ->update('MailQueue')
        ->set('inprogress', '1')
        ->where('id in ('.implode(',',$keys).')')
        ->execute();    
    }
      
    $i = 0;
    
    foreach ($queues as $queue)
    {
      $mailer = $this->getMailer();
      $message = $mailer->compose(
        array($queue->from_mail => $queue->from_name),
        array($queue->to_email  => $queue->to_name),
        $queue->subject,
        $queue->content
      );
      $message->setBody($queue->content, 'text/html');
      
      if ($mailer->send($message))
      {
        $queue->setSended(true);  
        $queue->save();
        $i++;
      }
    }
    echo $i.' level lett kiküldve';
    
    return sfView::NONE;    
    
  }
  
}
