[?php if ($field->isPartial()): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('field' => $field, 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($field->isComponent()): ?]
  [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($field->getConfig('shown')): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/showed', array('class' => $class, 'help' => $help, 'label' => $label, 'name' => $name, 'field' => $field, 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
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
      <div class="errors">
        <span class="ui-icon ui-icon-alert floatleft"></span>
        [?php echo $form[$name]->renderError() ?]
      </div>
    [?php endif; ?]
    
    [?php $attributes = $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes; ?]
    [?php if ($form[$name]->hasError()): ?]
      [?php $attributes['class'] = isset($attributes['class']) ? $attributes['class'].' ui-body-f' : 'ui-body-f'; ?]
    [?php endif; ?]
    
    [?php echo $form[$name]->render($attributes) ?]

  </div>
[?php endif; ?]
