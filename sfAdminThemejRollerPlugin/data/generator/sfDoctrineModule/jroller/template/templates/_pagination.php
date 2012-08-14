[?php
$first = ($pager->getPage() * $pager->getMaxPerPage() - $pager->getMaxPerPage() + 1);
$last = $first + $pager->getMaxPerPage() - 1;
$availableLimitNumbers = isset($pager->availableLimitNumbers) ? $pager->availableLimitNumbers : array('10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100', '200'=>'200');
?]

<table id="sf_admin_pager">
  <tbody>
    <tr>
      <td class="left">
        [?php 
          $select = new sfWidgetFormChoice(array('choices'=>$availableLimitNumbers));
      	  echo __('%1% hits per page', array('%1%' => $select->render('paginator_hitperpage', $pager->getMaxPerPage())))
        ?] 
        <script type="text/javascript">
          document.getElementById('paginator_hitperpage').onchange = function (){
            document.location.href = '[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]+?limit='+this.value;
          }
        </script>     
      </td>
      <td class="center">
        <table align="center" class="sf_admin_pagination">
          <tbody>
            <tr>
              [?php if ($pager->haveToPaginate()): ?]
              <td class="button">
                <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>?page=1') ?]"[?php if ($pager->getPage() == 1) echo ' class="ui-state-disabled"' ?]>
                  <?php echo UIHelper::addIconByConf('first') ?>
                </a>
              </td>

              <td class="button">
                <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>?page='.$pager->getPreviousPage()) ?]"[?php if ($pager->getPage() == 1) echo ' class="ui-state-disabled"' ?]>
                  <?php echo UIHelper::addIconByConf('previous') ?>
                </a>
              </td>

              [?php for ($i = 5; $i >= 1 ; $i--) : ?]
              [?php $number = $pager->getPage()-$i; ?]  
              [?php if ($number > 0): ?]  
              <td class="numbers">
                <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>?page='.$number) ?]">
                  [?php echo $number ?]  
                </a>
              </td>
              [?php endif; ?]
              [?php endfor; ?]              
              
              <td align="center">
                [?php echo __('Page') ?]
                <input id="paginator_pagenumber" type="text" name="page" value="[?php echo $pager->getPage() ?]" maxlength="7" size="2" />
                [?php echo __('of %1%', array('%1%' => $pager->getLastPage())) ?]
                <script type="text/javascript">
                  document.getElementById('paginator_pagenumber').onkeypress = function (evt){
                    var evt = (evt) ? evt : ((event) ? event : null); 
                    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
                    if ((evt.keyCode == 13) && (node.type=="text"))  {
                       evt.stopPropagation();
                       document.location.href = '[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]+?page='+this.value;
                       return false;   
                    } 
                  }
                </script>                   
            	</td>

            	[?php for ($i = 1; $i <= 5 ; $i++) : ?]
              [?php $number = $pager->getPage()+$i; ?]  
              [?php if ($number <= $pager->getLastPage()): ?]              	
            	<td class="numbers">
                <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>?page='.$number) ?]">
                  [?php echo $number ?]
                </a>
              </td>
            	[?php endif; ?]
            	[?php endfor; ?]            	
            	
              <td class="button">
                <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>?page='.$pager->getNextPage()) ?]"[?php if ($pager->getPage() == $pager->getLastPage()) echo ' class="ui-state-disabled"' ?]>
                  <?php echo UIHelper::addIconByConf('next') ?>
                </a>
              </td>

              <td class="button">
                <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>?page='.$pager->getLastPage()) ?]"[?php if ($pager->getPage() == $pager->getLastPage()) echo ' class="ui-state-disabled"' ?]>
                  <?php echo UIHelper::addIconByConf('last') ?>
                </a>
              </td>
              [?php endif; ?]
            </tr>
          </tbody>
        </table>
      </td>
      <td class="right">
        [?php
      	echo __('View %1% - %2% of %3%',
          array(
            '%1%' => $first,
            '%2%' => ($last > $pager->getNbResults()) ? $pager->getNbResults() : $last,
            '%3%' => $pager->getNbResults()
          )
      	)
      	?]
      </td>
    </tr>
  </tbody>
</table>
