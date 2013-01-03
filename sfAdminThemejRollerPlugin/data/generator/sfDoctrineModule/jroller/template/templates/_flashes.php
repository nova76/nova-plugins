<div class="sf_admin_flashes ui-widget">
[?php if ($sf_user->hasFlash('notice')): ?]
  <div class="notice ui-state-highlight ui-corner-all">
    <span class="ui-icon ui-icon-info floatleft"></span>&nbsp;
    [?php echo __($sf_user->getFlash('notice', ESC_RAW), array(), 'sf_admin') ?]
    [?php $sf_user->setFlash('notice', null) ?]
  </div>
[?php endif; ?]

[?php if ($sf_user->hasFlash('error')): ?]
  <div class="error ui-state-error ui-corner-all">
    <span class="ui-icon ui-icon-alert floatleft"></span>&nbsp;
    [?php echo __($sf_user->getFlash('error', ESC_RAW), array(), 'sf_admin') ?]
    [?php $sf_user->setFlash('error', null) ?]
  </div>
[?php endif; ?]
</div>
