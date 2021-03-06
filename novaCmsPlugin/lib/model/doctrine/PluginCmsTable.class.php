<?php

/**
 * PluginCmsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginCmsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginCmsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginCms');
    }
    
    public function retrieveBySlug($options = array())
    {
      
      if (!isset($options['slug']))
      {
        throw new InvalidArgumentException('The slug is required in the options');
      }
      
      return $this->createQuery('c')
            ->leftJoin('c.Translation t')
            ->where('c.deleted_at is null')
            ->addWhere('t.slug = ?', $options['slug'])->fetchOne();
      
      //return $this->findOneBy('Translate.slug', $options['slug']) ;
    }
}