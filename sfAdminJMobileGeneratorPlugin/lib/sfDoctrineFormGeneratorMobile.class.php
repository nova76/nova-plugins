<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) Jonathan H. Wage <jonwage@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Doctrine form generator.
 *
 * This class generates a Doctrine forms.
 *
 * @package    symfony
 * @subpackage generator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormGenerator.class.php 32892 2011-08-05 07:53:57Z fabien $
 */
class sfDoctrineFormGeneratorMobile extends sfDoctrineFormGenerator
{
  
  protected $notGeneratedFields = array();
  protected $notGeneratedPrefix = '_';
  protected $recheckFields = array();
  protected $passwordField = 'password';
  protected $passwordSaveMethod = 'md5';
  

  public function setDefaults()
  {
    $this->recheckFields = array('password');
    $this->notGeneratedFields = array('created', 'modified', 'created_at', 'updated_at');
    $this->notGeneratedPrefix = '_';
    $this->passwordField = 'password';
    $this->passwordSaveMethod = 'md5';
  }
  
  public function initialize(sfGeneratorManager $generatorManager)
  {
    parent::initialize($generatorManager);
    $this->setDefaults();
  }  
  
  
/**
   * Generates classes and templates in cache.
   *
   * @param array The parameters
   *
   * @return string The data to put in configuration cache
   */
  public function generate($params = array())
  {
    $this->params = $params;

    if (!isset($this->params['model_dir_name']))
    {
      $this->params['model_dir_name'] = 'model';
    }

    if (!isset($this->params['form_dir_name']))
    {
      $this->params['form_dir_name'] = 'form';
    }

    $models = $this->loadModels();

    // create the project base class for all forms
    $file = sfConfig::get('sf_lib_dir').'/form/doctrine/BaseFormDoctrine.class.php';
    if (!file_exists($file))
    {
      if (!is_dir($directory = dirname($file)))
      {
        mkdir($directory, 0777, true);
      }
      
      file_put_contents($file, $this->evalTemplate('sfDoctrineFormBaseTemplate.php'));
    }
    
    $pluginPaths = $this->generatorManager->getConfiguration()->getAllPluginPaths();

    // create a form class for every Doctrine class
    foreach ($models as $model)
    {
      $this->table = Doctrine_Core::getTable($model);
      $this->modelName = $model;

      $baseDir = sfConfig::get('sf_lib_dir') . '/form/doctrine';

      $isPluginModel = $this->isPluginModel($model);
      if ($isPluginModel)
      {
        $pluginName = $this->getPluginNameForModel($model);
        $baseDir .= '/' . $pluginName;
      }

      if (!is_dir($baseDir.'/base'))
      {
        mkdir($baseDir.'/base', 0777, true);
      }

      file_put_contents($baseDir.'/base/Base'.$model.'MobileForm.class.php', $this->evalTemplate(null === $this->getParentModel() ? 'sfDoctrineFormGeneratedMobileTemplate.php' : 'sfDoctrineFormGeneratedInheritanceMobileTemplate.php'));
      
      if ($isPluginModel)
      {
        $pluginBaseDir = $pluginPaths[$pluginName].'/lib/form/doctrine';
        if (!file_exists($classFile = $pluginBaseDir.'/Plugin'.$model.'MobileForm.class.php'))
        {
            if (!is_dir($pluginBaseDir))
            {
              mkdir($pluginBaseDir, 0777, true);
            }
            file_put_contents($classFile, $this->evalTemplate('sfDoctrineFormPluginMobileTemplate.php'));
        }
      }
      if (!file_exists($classFile = $baseDir.'/'.$model.'MobileForm.class.php'))
      {
        if ($isPluginModel)
        {
           file_put_contents($classFile, $this->evalTemplate('sfDoctrinePluginFormMobileTemplate.php'));
        } else {
           file_put_contents($classFile, $this->evalTemplate('sfDoctrineFormMobileTemplate.php'));
        }
      }
    }
  }  

   /**
   * Get the name of the form class to extend based on the inheritance of the model
   *
   * @return string
   */
  public function getFormClassToExtend()
  {
    return null === ($model = $this->getParentModel()) ? 'BaseFormDoctrine' : sprintf('%sForm', $model);
  }
  
  /**
   * Returns a sfWidgetForm class name for a given column.
   *
   * @param  sfDoctrineColumn $column
   * @return string    The name of a subclass of sfWidgetForm
   */
  public function getWidgetClassForColumn($column)
  {
    switch ($column->getDoctrineType())
    {
      case 'string':
        $widgetSubclass = null === $column->getLength() || $column->getLength() > 255 ? 'Textarea' : 'InputText';
        break;
      case 'boolean':
        $widgetSubclass = 'InputCheckbox';
        break;
      case 'blob':
      case 'clob':
        $widgetSubclass = 'Textarea';
        break;
      case 'date':
        $widgetSubclass = 'Date';
        break;
      case 'time':
        $widgetSubclass = 'Time';
        break;
      case 'timestamp':
        $widgetSubclass = 'DateTime';
        break;
      case 'integer':
        $widgetSubclass = $column->getLength() == 1 ? 'Choice' : 'InputText';
        break;
      case 'enum':        
        $widgetSubclass = 'Choice';
        break;
      default:
        $widgetSubclass = 'InputText';
    }

    if ($column->isPrimaryKey())
    {
      $widgetSubclass = 'InputHidden';
    }
    else if ($column->isForeignKey())
    {
      $widgetSubclass = 'DoctrineChoice';
    }

    return sprintf('sfWidgetForm%s', $widgetSubclass);
  }

  
  public function getWidgetAttributtesForColumn($column)
  {
    $options = array();
    
    if ('integer' == $column->getDoctrineType() && is_subclass_of($this->getWidgetClassForColumn($column), 'sfWidgetFormChoiceBase'))
    {
      $options[] = '\'data-role\' => \'slider\'';
    }
    return count($options) ? sprintf('array(%s)', implode(', ', $options)) : 'array()';
  }  
  
  /**
   * Returns a PHP string representing options to pass to a widget for a given column.
   *
   * @param sfDoctrineColumn $column
   * 
   * @return string The options to pass to the widget as a PHP string
   */
  public function getWidgetOptionsForColumn($column)
  {
    $options = array();

    if ($column->isForeignKey())
    {
      $options[] = sprintf('\'model\' => $this->getRelatedModelName(\'%s\'), \'add_empty\' => %s', $column->getRelationKey('alias'), $column->isNotNull() ? 'false' : 'true');
    }
    else if ('integer' == $column->getDoctrineType() && is_subclass_of($this->getWidgetClassForColumn($column), 'sfWidgetFormChoiceBase'))
    {
      $array  = array("1" => "Yes", "0" => "No");
      $array2 = array("data-role" => "slider");
      $options[] = '\'choices\' => '.$this->arrayExport($array);
    }
    else if ('enum' == $column->getDoctrineType() && is_subclass_of($this->getWidgetClassForColumn($column), 'sfWidgetFormChoiceBase'))
    {
      $options[] = '\'choices\' => '.$this->arrayExport(array_combine($column['values'], $column['values']));
    }

    return count($options) ? sprintf('array(%s)', implode(', ', $options)) : 'array()';
  }

}
