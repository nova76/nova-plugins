<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormPlain represents an HTML div tag. 
 * 
 * This is the plain widget to just show the value as part of admin.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormInput.class.php 30762 2010-08-25 12:33:33Z fabien $
 */
class sfWidgetFormPlain extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   * 
   * model: ha rejtett mezoben szeretnem beletenni az adatot, de az adat egy tablabol jon 
   * showed_value : ha rejtett mezoben szeretnem beletenni az adatot, de megjeleniteni mast szeretnek
   * has_hidden : ha rejtett mezoben szeretnem beletenni az adatot
   * 
   */
  protected function configure($options = array(), $attributes = array())
  {
    
    $this->addOption('model', false);
    $this->addOption('method', '__toString');
    $this->addOption('key_method', 'getPrimaryKey');
    $this->addOption('order_by', null);
    $this->addOption('query', null);
    $this->addOption('multiple', false);
    $this->addOption('table_method', null);

    $this->addOption('showed_value', false);
    $this->addOption('has_hidden', false);

    //parent::configure($options, $attributes);    
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   * 
   * showed_value, ha nem value kell hogy megjelenjen, de ilyenkor a value megy hiddenbe
   * sfWidgetFormDoctrineChoice nyoman lekrheto egy kapcsolt tabla adata is
   * 
   * 
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (false!==$this->getOption('model'))
    {
      $choices = $this->getChoices();
      $hiddenInput = new sfWidgetFormInputHidden();
      return $this->renderContentTag('div', $choices[$value], $attributes).$hiddenInput->render($name, $value, $attributes, $errors);
    }
    elseif (false!==$this->getOption('showed_value'))
    {
      $hiddenInput = new sfWidgetFormInputHidden();
      return $this->renderContentTag('div', $this->getOption('showed_value'), $attributes).$hiddenInput->render($name, $value, $attributes, $errors);
    }
    elseif (false!==$this->getOption('has_hidden'))
    {
      $hiddenInput = new sfWidgetFormInputHidden();
      return $this->renderContentTag('div', $value, $attributes).$hiddenInput->render($name, $value, $attributes, $errors);
    }
        
    return $this->renderContentTag('div', $value, $attributes);  
  }
  
  /**
   * sfWidgetFormDoctrineChoice nyoman...
   *
   * @return array
   */
  public function getChoices()
  {
   if (null === $this->getOption('table_method'))
    {
      $query = null === $this->getOption('query') ? Doctrine_Core::getTable($this->getOption('model'))->createQuery() : $this->getOption('query');
      if ($order = $this->getOption('order_by'))
      {
        $query->addOrderBy($order[0] . ' ' . $order[1]);
      }
      $objects = $query->execute();
    }
    else
    {
      $tableMethod = $this->getOption('table_method');
      $results = Doctrine_Core::getTable($this->getOption('model'))->$tableMethod();

      if ($results instanceof Doctrine_Query)
      {
        $objects = $results->execute();
      }
      else if ($results instanceof Doctrine_Collection)
      {
        $objects = $results;
      }
      else if ($results instanceof Doctrine_Record)
      {
        $objects = new Doctrine_Collection($this->getOption('model'));
        $objects[] = $results;
      }
      else
      {
        $objects = array();
      }
    }

    $method = $this->getOption('method');
    $keyMethod = $this->getOption('key_method');

    foreach ($objects as $object)
    {
      $choices[$object->$keyMethod()] = $object->$method();
    }      
    return $choices;
  }
  
}