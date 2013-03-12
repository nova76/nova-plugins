[?php include_stylesheets_for_form($form) ?]
[?php include_javascripts_for_form($form) ?]

<div class="sf_admin_form [?php echo sfInflector::underscore($configuration->getFormClass()) ?]">

    [?php include_partial('<?php echo $this->getModuleName() ?>/include_form_extend_variables', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  
    <div class="ui-helper-clearfix"></div>
	
    [?php echo $form->renderHiddenFields() ?]

    [?php if ($form->hasGlobalErrors()): ?]
      [?php echo $form->renderGlobalErrors() ?]
    [?php endif; ?]

		
   	[?php 
		$count = 0;
		foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): 
			$count++;
    endforeach; 
		?]
  
		[?php $template = ($configuration->getFormTemplate()); ?]
    

		[?php if($template['name']=='tab'): ?]
        <div id="sf_admin_form_tab_menu">
			[?php if ($count > 1): ?]
			<ul>
	    [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
				[?php $count++ ?]
				
				<li><a href="#sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</a></li>
	    [?php endforeach; ?]
			</ul>
			[?php endif ?]
			
	    [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
	      [?php include_partial('<?php echo $this->getModuleName() ?>/form_fieldset', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?]
	    [?php endforeach; ?]
		</div>
    [?php endif ?]
  
</div>
