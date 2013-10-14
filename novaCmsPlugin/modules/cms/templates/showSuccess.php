<?php slot('title') ; ?>
  <?php echo $page->getTitle() ?>
<?php end_slot(); ?>

<?php echo html_entity_decode($page->Translation[$sf_user->getCulture()]->content) ?>
