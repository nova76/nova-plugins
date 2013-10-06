<?php foreach ($root->getNode()->getChildren() as $child) : ?>
	<?php include_component('cms', 'showDirectory', array('html'=>$html, 'directory'=>$child));?>
<?php endforeach; ?>
