[?php if ($value): ?]
  [?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/tick.png', array('alt' => __('Checked', array(), 'sf_admin'), 'title' => __('Checked', array(), 'sf_admin'))) ?]
[?php elseif(isset($false)): ?]
  [?php echo image_tag('/sfAdminJMobileGeneratorPlugin/images/'.$false, array('alt' => __('UnChecked', array(), 'sf_admin'), 'title' => __('UnChecked', array(), 'sf_admin'))) ?]
[?php else: ?]
  &nbsp;
[?php endif; ?]
