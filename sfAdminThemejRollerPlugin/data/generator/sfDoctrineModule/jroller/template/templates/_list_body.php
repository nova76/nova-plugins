    <tbody>
      [?php foreach ($pager->getResults() as $i => $<?php echo $this->getSingularName() ?>): $odd = fmod(++$i, 2) ? ' odd' : '' ?]
        <tr class="sf_admin_row ui-widget-content [?php echo $odd ?]">
          <?php if ($this->configuration->getValue('list.batch_actions')): ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_batch_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
          <?php endif; ?>

          [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_<?php echo $this->configuration->getValue('list.layout') ?>', array('configuration' => $configuration, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]

          <?php if ($this->configuration->getValue('list.object_actions')): ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
          <?php endif; ?>
        </tr>
      [?php endforeach; ?]
    </tbody>
 