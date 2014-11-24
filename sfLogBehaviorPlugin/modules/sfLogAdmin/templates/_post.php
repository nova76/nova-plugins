<?php if ($sf_log->getRawvalue()->getPostZip()): ?>
  <pre> <?php print_r(json_decode(gzuncompress($sf_log->getRawvalue()->getPostZip()), true)); ?> </pre>
<?php endif; ?>