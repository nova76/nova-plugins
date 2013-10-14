<?php 

$children = $directory->getNode()->getChildren() ;

$content = get_partial('cms/showDirectory'.ucfirst(strtolower($html['template'])), compact('children')); 
$layout = html_entity_decode($html['layout']);
$layout = str_replace('%content%', $content, $layout);
$layout = str_replace('%title%', $directory->getTitle(), $layout);
echo $layout;


