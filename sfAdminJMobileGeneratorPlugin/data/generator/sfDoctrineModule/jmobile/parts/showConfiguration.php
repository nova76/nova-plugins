  public function getShowActions()
  {
    return <?php echo $this->asPhp(isset($this->config['show']['actions']) ? $this->config['show']['actions'] : array(  '_list' => NULL,  '_edit' => NULL, '_delete' => NULL)) ?>;
    <?php unset($this->config['show']['actions']) ?>  
  }

  
  public function getShowTitle()
  {
    return '<?php echo isset($this->config['show']['title']) ? $this->config['show']['title'] : 'View '.sfInflector::humanize($this->getModuleName()) ?>';
<?php unset($this->config['show']['title']) ?>
  }

  public function getShowDisplay()
  {
  <?php if (isset($this->config['show']['display'])): ?>
    return <?php echo $this->asPhp($this->config['show']['display']) ?>;
<?php elseif (isset($this->config['show']['hide'])): ?>
    return <?php echo $this->asPhp(array_diff($this->getAllFieldNames(false), $this->config['show']['hide'])) ?>;
<?php else: ?>
    return <?php echo $this->asPhp($this->getAllFieldNames(false)) ?>;
<?php endif; ?>
<?php unset($this->config['show']['display'], $this->config['show']['hide']) ?>
  }

  
  
