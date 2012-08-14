[?php include_stylesheets_for_form($form) ?]
[?php include_javascripts_for_form($form) ?]

<div class="sf_admin_form">
  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]

    [?php if ($actions === true):  ?]
    <div class="sf_admin_actions_block ui-widget">
      [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
    </div>
    [?php endif ?]
    
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
    
		[?php if ($template['name']=='accordion'): ?]
		
		<script type="text/javascript">
		    $(function() {
		      $( ".jroller-accordion" ).accordion({collapsible: true, active: false, autoHeight: false});
		      $( ".jroller-accordion-open" ).accordion({collapsible: true, active: 0, autoHeight: false});
	     });
	   </script>
		  [?php $opens = isset($template['open']) ?  $template['open']->getRawValue() : array(0) ?]
	    [?php $accordions = 0;  ?]
	    [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
          [?php $hasError  = false ?]
          [?php if ($form->hasErrors()): ?]
	          [?php foreach ($fields as $name => $field): ?]
	            [?php 
	               if ($field->isPartial())  
	               {
	                 $hasError = get_partial('<?php echo $this->getModuleName() ?>/error_'.$name, array('form' => $form)) ;
	               }
	               elseif($form[$name]->hasError())
	               {
	                 $hasError = true;
	               }
	               if ($hasError) 
	               {
	                 break;
	               }
	            ?] 
    	      [?php endforeach; ?]
    	    [?php endif ?] 
	        [?php if ($hasError || (!$form->hasErrors() && in_array($accordions, $opens)!==false)): ?] 	    
          <div class="jroller-accordion-open">
  	      [?php else: ?] 
          <div class="jroller-accordion">
          [?php endif ?] 
          [?php $accordions++;  ?]
	        <h3><a href="#sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</a></h3>
  				<div>
  				  [?php include_partial('<?php echo $this->getModuleName() ?>/form_fieldset', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?]
  				</div>
  			</div>	
	    [?php endforeach; ?]
    
    
    [?php elseif($template['name']=='tab'): ?]
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

    [?php if ($actions === true):  ?]
    <div class="sf_admin_actions_block ui-widget ui-helper-clearfix">
      [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
    </div>
    [?php endif ?]

  </form>
</div>
