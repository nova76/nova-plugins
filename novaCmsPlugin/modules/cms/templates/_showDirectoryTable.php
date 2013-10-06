<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <?php foreach ($children as $child) : ?>
	<tr align="left">
	 <td>
	   <?php echo link_to($child->getTitle(), '@cms_slug?slug='.$child->getSlug(), array('title'=>$child->getTitle())); ?>
	 </td>
	</tr>
  <?php endforeach; ?>
</table>