<li class="level<?php echo $child->getLevel() ?>">
  <?php echo link_to($child->getTitle(), '@cms_slug?slug='.$child->getSlug(), array('title'=>$child->getTitle())); ?>
  <?php if ($children) : ?>
    <ul>
      <?php foreach ($children as $child) : ?>
       	<?php include_component('cms', $template, compact('child', 'template')) ; ?>
      <?php endforeach; ?>
    </ul>
  <?php endif ?>
</li>
