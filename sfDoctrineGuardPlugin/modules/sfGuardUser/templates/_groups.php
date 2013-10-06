<?php $groups = array(); ?>
<?php foreach ($sf_guard_user->Groups as $group): ?>
  <?php $groups[] = (string) $group; ?>
<?php endforeach; ?>
<?php echo implode(', ', $groups); ?>
