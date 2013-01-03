<?php 
class NestedSetHelper
{
  protected static function create_html_list($nodes, $idprefix='', $key_method='__toString')
  {
    $res = '<ul>';
    foreach ($nodes as $node) 
    {
        $res .= "<li id=\"".$idprefix.$node['id']."\"><a href=\"#\">".$node->$key_method()."</a>";
        if ($node->getNode()->hasChildren()) {
            $res .= self::create_html_list($node->getNode()->getChildren(), $idprefix, $key_method);
        }
        $res .= "</li>";
    }
    $res .= '</ul>';
    return $res; 
  }

  
  
  
	static function listDump(Doctrine_Tree_NestedSet $treeObject, $idprefix='', $key_method='__toString') 
	{
	  $treeNode = $treeObject->fetchRoot()->getNode();
	  if ($treeNode->hasChildren())
	  {
	    return self::create_html_list($treeNode->getChildren(), $idprefix, $key_method);
	  }
	  
	  return '';	  
	}
}
