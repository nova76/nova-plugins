<?php

/**
 * Base actions for the sfGuardForgotPasswordPlugin sfGuardForgotPassword module.
 * 
 * @package     sfGuardForgotPasswordPlugin
 * @subpackage  sfGuardForgotPassword
 * @author      Your name here
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasesfGuardForgotPasswordActions extends sfActions
{
  public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->redirect('@homepage');
    }
  }

  public function getI18n()
  {
    return $this->getContext()->getI18n();
  }
  
  public function executeIndex($request)
  {
    $this->form = new sfGuardRequestForgotPasswordForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $this->user = $this->form->user;
        $this->_deleteOldUserForgotPasswordRecords();

        $forgotPassword = new sfGuardForgotPassword();
        $forgotPassword->user_id = $this->form->user->id;
        $forgotPassword->unique_key = md5(rand() + time());
        $forgotPassword->expires_at = new Doctrine_Expression('NOW()');
        $forgotPassword->save();
        $subject = $this->getI18n()->__('Forgot Password Request for %1%', array('%1%'=>$this->user->username), 'sf_guard');
        
        $message = Swift_Message::newInstance()
          ->setFrom(sfConfig::get('app_sf_guard_plugin_default_from_email', 'from@noreply.com'))
          ->setTo($this->form->user->email_address)
          ->setSubject($subject)
          ->setBody($this->getPartial('sfGuardForgotPassword/send_request', array('user' => $this->form->user, 'forgot_password' => $forgotPassword)))
          ->setContentType('text/html')
        ;

        $this->getMailer()->send($message);
        
        $this->getUser()->setFlash('notice', $this->getI18n()->__('Check your e-mail! You should receive something shortly!', array(), 'sf_guard'));
        $this->redirect('@homepage');
      } 
      else 
      {
        $this->getUser()->setFlash('error', $this->getI18n()->__('Invalid e-mail address!', array(), 'sf_guard'));
      }
    }
  }

  public function executeChange($request)
  {
    try 
    {
      $this->forgotPassword = $this->getRoute()->getObject();  
    }
    catch (sfError404Exception $e)
    {
      $this->redirect404();
    }
    $this->user = $this->forgotPassword->User;

    $this->form = new sfGuardChangeUserPasswordForm($this->user);

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $this->form->save();
        $this->_deleteOldUserForgotPasswordRecords();

        $subject = sfContext::getInstance()->getI18n()->__('New Password for %1%', array('%1%'=>$this->user->username), 'sf_guard');
        
        $message = Swift_Message::newInstance()
          ->setFrom(sfConfig::get('app_sf_guard_plugin_default_from_email', 'from@noreply.com'))
          ->setTo($this->user->email_address)
          ->setSubject($subject)
          ->setBody($this->getPartial('sfGuardForgotPassword/new_password', array('user' => $this->user, 'password' => $request['sf_guard_user']['password'])))
        ;

        $this->getMailer()->send($message);

        $this->getUser()->setFlash('notice', $this->getI18n()->__('Password updated successfully!', array(), 'sf_guard'));
        $this->redirect('@homepage');
      }
    }
  }

  private function _deleteOldUserForgotPasswordRecords()
  {
    Doctrine_Core::getTable('sfGuardForgotPassword')
      ->createQuery('p')
      ->delete()
      ->where('p.user_id = ?', $this->user->id)
      ->execute();
  }
}