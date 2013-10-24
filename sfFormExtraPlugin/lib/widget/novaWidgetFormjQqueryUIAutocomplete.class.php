<?php 
/**
* sfExtraWidgetFormInputAutocomplete render an ajax autocompleter
* 
* This class render a simple input widget, but when you type any
* characters a proposition list will appear below the input widget.
* 
* @author   Frey Istvaan <fi76account@gmail.com>
*/
abstract class novaWidgetFormjQqueryUIAutocomplete extends sfWidgetFormInput
{
    abstract protected function getValueFromId($id);
    
    public function configure($options = array(), $attributes = array())
    {
        $this->addRequiredOption('url');
        $this->addOption('appendTo', '');
        $this->addOption('param', 'autocomplete');
        parent::configure($options, $attributes);
    }
    
    protected function javascriptTag($js)
    {
      return '<script type="text/javascript">'.$js.'</script>';
    }
    
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $context = sfContext::getInstance();
        $response = $context->getResponse();
        
        $autocompleteDiv = content_tag('div' , '', array('id' => $this->generateId($name) . '_autocomplete', 'class' => 'autocomplete'));
        
        $autocompleteJs = $this->javascriptTag("
              
            $(function(){
               
              $('#".$this->generateId($name)."_ajaxtext').autocomplete({
                  source: '".url_for($this->getOption('url'))."',
                  delay:30,
                  minChars:0,
                  appendTo: '".$this->getOption('appendTo')."',
                  max:30,
                  width: 300,
                  matchSubset:1,
                  matchContains:1,
                  cacheLength:10,
                  autoFill:false,
                  autoFocus: true,
                  select: function( event, ui ) {
                    $('#" . $this->generateId($name) . "').val(ui.item.id);
                    $('#" .get_id_from_name($name)."_ajaxcheckbox').prop('checked', true)
                    $('#" .get_id_from_name($name)."_ajaxcheckboxText').html('".__('kiválasztva')."');
                    $('#".$this->generateId($name)."').trigger('change', [ui.item])
                  }  
                });
              
              
              $.fn.autocomplete.keypressEvent = function (evt, id){
                 car =  evt.keyCode || evt.charCode;
                 if (car != 27 && car!=9) //ESC + TAB
                 {
                    $('#'+id).val('');
                    $('#'+id+'_ajaxcheckbox').attr('checked',false);
                    $('#'+id+'_ajaxcheckboxText').html('".__('nincs kiválasztva')."');                   
                    $('#".$this->generateId($name)."').trigger('change')
                 } 
              }  
                
           });");
        
        $ihidden  = new sfWidgetFormInputHidden();              
        $ihiddenText = $ihidden->render($name, $value, $attributes);
        if ($value!='')
        {
          $checked = 'checked="checked"';
          $checkboxtext = "<span id='".get_id_from_name($name)."_ajaxcheckboxText'>".__('kiválasztva')."</span>";   
        }   
        else
        {
          $checked = '';
          $checkboxtext = "<span id='".get_id_from_name($name)."_ajaxcheckboxText'>".__('nincs kiválasztva')."</span>";
        } 
        
        $checkbox = '<input type="checkbox" id="'.get_id_from_name($name).'_ajaxcheckbox'.'" '.$checked.' disabled="disabled" />';
         
        $attributesText = array_merge($attributes, array('name'=>false, 'id'=>get_id_from_name($name).'_ajaxtext'));
        
        $attributesText['onkeydown']="$('#".$this->generateId($name)."_ajaxtext').autocomplete.keypressEvent(event, '".$this->generateId($name)."')";
        
        $itextText  = parent::render($name, $this->getValueFromId($value), $attributesText, $errors);
        
        $indicator = '<span id="indicator-' . $this->generateId($name) . '" style="display: none;">&nbsp;&nbsp;<img src="/sfFormExtraPlugin/images/indicator.gif" alt="loading" /></span>';
        return $ihiddenText.$itextText.$checkbox.$checkboxtext.$indicator.$autocompleteDiv.$autocompleteJs;
    }
    
    
}