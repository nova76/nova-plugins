<?php slot('title') ;
  fb($sf_user->getCulture());
  fb($page->Translation[$sf_user->getCulture()]->toArray());
?>
  <?php echo $page->getTitle() ?>
<?php end_slot(); ?>
<div class="cms-content">
  <?php echo html_entity_decode($page->Translation[$sf_user->getCulture()]->content) ?>
</div>