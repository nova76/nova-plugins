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
    
    // csak Doctrine_Query table_method eseten. 
    // Nem keri le a teljes tablat, csak a valueval egyezot
    $this->addOption('cached_value', true); 
    
    $this->addOption('showed_value', false);
    
    // amig nincs kivalasztva semmi, ez jelenik meg
    $this->addOption('empty', 'Not granted');

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
    $this->cached_value = false;
    if ($this->getOption('cached_value') === true)
    {
      $this->cached_value = $value;  
    }

    $attributesDiv = array_merge($attributes, array('id'=>$this->generateId($name).'_div'));
    
    if (false!==$this->getOption('model'))
    {
      $choices = $this->getChoices();
      $hiddenInput = new sfWidgetFormInputHidden();
      return $this->renderContentTag('div', isset($choices[$value])?$choices[$value]:$this->getOption('empty'), $attributesDiv).$hiddenInput->render($name, $value, $attributes, $errors);
    }
    
    if (false!==$this->getOption('showed_value'))
    {
      $hiddenInput = new sfWidgetFormInputHidden();
      return $this->renderContentTag('div', nl2br($this->getOption('showed_value')), $attributesDiv).$hiddenInput->render($name, $value, $attributes, $errors);
    }
    elseif (false!==$this->getOption('has_hidden'))
    {
      $hiddenInput = new sfWidgetFormInputHidden();
      return $this->renderContentTag('div', nl2br($value), $attributesDiv).$hiddenInput->render($name, $value, $attributes, $errors);
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
      if ($this->cached_value !== false)
      {
        $table = Doctrine_Core::getTable($this->getOption('model'));
        foreach ($table->getColumns() as $name => $definition) 
        {
          if (isset($definition['primary']) && $definition['primary']) {
              $primary[] = $name;
          }            
        }
        $query->addWhere($query->getRootAlias().'.'.$primary[0].' = ?', $this->cached_value);        
      }
      
      $objects = $query->execute();
    }
    else
    {
      $tableMethod = $this->getOption('table_method');
      $results = Doctrine_Core::getTable($this->getOption('model'))->$tableMethod();

      if ($results instanceof Doctrine_Query)
      {
        if ($this->cached_value !== false)
        {
          $table = Doctrine_Core::getTable($this->getOption('model'));
          foreach ($table->getColumns() as $name => $definition) 
          {
            if (isset($definition['primary']) && $definition['primary']) {
                $primary[] = $name;
            }            
          }
          $results->addWhere($results->getRootAlias().'.'.$primary[0].' = ?', $this->cached_value);
        }
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

    
    $choices = array();
    
    foreach ($objects as $object)
    {
      $choices[$object->$keyMethod()] = $object->$method();
    }      
    return $choices;
  }
  
}