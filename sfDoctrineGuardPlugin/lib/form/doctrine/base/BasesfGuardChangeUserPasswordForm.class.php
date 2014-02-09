<?php

/**
 * BasesfGuardChangeUserPasswordForm for changing a users password
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardChangeUserPasswordForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class BasesfGuardChangeUserPasswordForm extends BasesfGuardUserForm
{
  public function setup()
  {
    parent::setup();

    $this->useFields(array('password'));

    
    $this->validatorSchema['password'] = new sfValidatorRegex(array('pattern'=>'/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/'));

    $this->validatorSchema['password']->setMessage('invalid', 'A jelszó minimum 8 karakteres, és legalább 1 számot és egy nagy betűt tartalmaz!');
    
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->validatorSchema['password_again']->setOption('required', true);

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
  }
}