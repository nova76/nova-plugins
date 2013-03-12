<?php

    /**
		 * Checks if a partial exists
		 *
		 * @param string $templateName		the partial's name, with or without the module ('module/partial')
		 *
		 * @return bool
		 */

		function has_partial($templateName)
		{
			$context = sfContext::getInstance();

			// is the partial in another module?
			if (false !== $sep = strpos($templateName, '/'))
			{
				$moduleName   = substr($templateName, 0, $sep);
				$templateName = substr($templateName, $sep + 1);
			}
			else
			{
				$moduleName = $context->getActionStack()->getLastEntry()->getModuleName();
			}
			
			//We need to fetch the module's configuration to know which View class to use,
			// then we'll have access to information such as the extension
			$config = sfConfig::get('mod_'.strtolower($moduleName).'_partial_view_class');
			if( empty($config) )
			{
				require($context->getConfigCache()->checkConfig('modules/'.$moduleName.'/config/module.yml', true));
				$config = sfConfig::get('mod_'.strtolower($moduleName).'_partial_view_class','sf');
			}
			$class =  $config.'PartialView';
			$view = new $class($context, $moduleName, $templateName, '');

			$templateName = '_'.$templateName.$view->getExtension();
			
			//We now check if the file exists and is readable
      if ('global' == $moduleName)
      {
        $directory = $context->getConfiguration()->getDecoratorDir($templateName);
      }
      else
      {
        $directory = $context->getConfiguration()->getTemplateDir($moduleName, $templateName);
      }			
			
			if($directory)
			{
				return true;
			}
			
			return false;
		}
?>