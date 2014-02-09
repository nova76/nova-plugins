<?php $content = ''; ?>
<?php if ($root && $root->getNode()->getChildren()) : /*!$root->getCredential() || $sf_user->hasCredential($root->getCredential()))*/  ?>
  <?php foreach ($root->getNode()->getChildren() as $child) : ?>
    <?php if (!$child->deleted_at) : ?>
  	<?php $content .= get_component('cms', $template, compact('child', 'template')) ; ?>
    <?php endif ?>
  <?php endforeach; ?>
  <?php echo html_entity_decode(sprintf($decorator, $content)) ; ?>
<?php endif ?>
