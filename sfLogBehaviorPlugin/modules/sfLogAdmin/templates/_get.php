<?php if ($sf_log->getRawvalue()->getGetZip()): ?>
<pre> <?php print_r(json_decode(gzuncompress($sf_log->getRawvalue()->getGetZip()), true)); ?> </pre>
<?php endif; ?>