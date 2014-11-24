<?php if ($sf_log->getRawvalue()->getRequestZip()): ?>
<pre> <?php print_r(json_decode(gzuncompress($sf_log->getRawvalue()->getRequestZip()), true)); ?> </pre>
<?php endif; ?>