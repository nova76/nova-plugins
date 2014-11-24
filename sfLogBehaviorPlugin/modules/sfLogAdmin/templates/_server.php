<?php if ($sf_log->getRawvalue()->getServerZip()): ?>
<pre> <?php print_r(json_decode(gzuncompress($sf_log->getRawvalue()->getServerZip()), true)); ?> </pre>
<?php endif; ?>