<ul>
  <?php foreach ($children as $child) : ?>
  	<li><?php echo link_to($child->getTitle(), '@cms_slug?slug='.$child->getSlug(), array('title'=>$child->getTitle())); ?></li>
  <?php endforeach; ?>
</ul>