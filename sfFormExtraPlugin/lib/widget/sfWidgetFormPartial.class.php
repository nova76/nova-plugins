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
class sfWidgetFormPartial extends sfWidgetForm
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
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('partial');
    $this->addOption('params', false);
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
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Partial'));
    $fields = $this->getParent()->getFields();
    $options = is_array($this->getOption('params')) ? $this->getOption('params') : array($this->getOption('params'));
    return get_partial($this->getOption('partial'), array_merge(compact('value', 'name', 'attributes', 'errors'), $options));
  }
}