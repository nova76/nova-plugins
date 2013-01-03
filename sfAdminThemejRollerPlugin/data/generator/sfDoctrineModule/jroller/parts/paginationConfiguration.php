  public function getPager($model, $limit = false)
  {
    $class = $this->getPagerClass();

    $pager = new $class($model, $limit ? $limit : $this->getPagerMaxPerPage());
    
    $pager->availableLimitNumbers = $this->getAvailableLimitNumbers();
    
    return $pager;
  }

  public function getPagerClass()
  {
    return '<?php echo isset($this->config['list']['pager_class']) ? $this->config['list']['pager_class'] : 'sfDoctrinePager' ?>';
<?php unset($this->config['list']['pager_class']) ?>
  }

  public function getPagerMaxPerPage()
  {
    return <?php echo isset($this->config['list']['max_per_page']) ? (integer) $this->config['list']['max_per_page'] : 20 ?>;
<?php unset($this->config['list']['max_per_page']) ?>
  }
  
  /**
    available limits
  */
  public function getAvailableLimitNumbers()
  {
    return array('10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100', '200'=>'200');
  }