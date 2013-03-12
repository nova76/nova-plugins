[?php $shownConfig = $field->getConfig('shown'); ?]
[?php if(!in_array($shownConfig, array('shown', 'hidden', 'shown_and_hidden'))) throw new Exception('Field shown configuration error!') ?]
[?php $attributes = $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes; ?]
[?php use_helper('HiddenInput'); ?]

[?php if ($shownConfig == 'hidden'): ?]
  [?php change_input_hidden($form, $name) ?]
  [?php echo $form[$name]->render($attributes) ?]
[?php else: ?]
  <div class="[?php echo $class ?][?php $form[$name]->hasError() and print ' ui-state-error ui-corner-all' ?]">
    <div class="label ui-helper-clearfix">
      [?php echo $form[$name]->renderLabel($label) ?]
  
      [?php if ($help || $help = $form[$name]->renderHelp()): ?]
        <div class="help">
          <span class="ui-icon ui-icon-help floatleft"></span>
          [?php echo __(strip_tags($help), array(), '<?php echo $this->getI18nCatalogue() ?>') ?]
        </div>
      [?php endif; ?]
    </div>
  
    [?php if ($form[$name]->hasError()): ?]
      [?php $attributes['class'] = isset($attributes['class']) ? $attributes['class'].' ui-body-f' : 'ui-body-f'; ?]
    [?php endif; ?]
    
    
    [?php if ($shownConfig == 'shown_and_hidden'): ?]
      [?php change_input_hidden($form, $name) ?]
      [?php echo $form[$name]->render($attributes) ?]
      [?php echo $form->getObject()->offsetGet($name);?]
    [?php elseif($shownConfig == 'shown'): ?]
      [?php echo $form->getObject()->offsetGet($name);?]
    [?php endif; ?]
    
    
    [?php /* if ($form[$name]->hasError()): ?]
      <div class="errors">
        <span class="ui-icon ui-icon-alert floatleft"></span>
        [?php echo $form[$name]->renderError() ?]
      </div>
    [?php endif; */ ?]
  </div>
[?php endif; ?]