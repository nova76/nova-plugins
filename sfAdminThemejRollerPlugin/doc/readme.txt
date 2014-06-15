sfAdminThemeRoller változtatások eddig:
 
1., az object actionnél megadhato az ui-icon:false. Akkor nincs icon

2., a lista sf_admin_container nevű divje kapott egy list-{modulneve} class jelölöt. Így külön lehet designolni a táblázatokat, de a meglévő nem sérül. 

3., 
  filter:  
        template: top
        extra_css_class: "ui-corner-all"
  A filter felül lesz a tábla felett és nem lesz rejtett és kap egy "ui-corner-all" classt a div, amiben van a filter
  
4., accordionos csoportosítás
  pl:
      form:    
          template: { name: accordion, open: [1]}
          display:
            "Céges adatok":            [..]
            "Kapcsolattartói adatok":  [..]
            "Pénzügyi információk":    [..]
  
  open: ez egy tömb, megadható több index, ami nyitva van. 0-tól indul az index.
  Hiba esetén nyitva marad. 
  Illetve ha partial van, akkor letre kell hozni egy "partial_neve_error" partialt is, 
  ami vissza kell adjon egy 0 vagy 1 értéket, attól függően lesz nyitva. Ez elég gáz de jobb ötltem nem volt.

5., A rekord akció gombjai feltételtől függően jelenhetnek meg.
  http://snippets.symfony-project.org/snippet/467

  például van egy objektum, aminek van egy client boolean tulajdonsága:
  Ha az 0, akkor lesz gomb, ha 1, akkor nem lesz gomb.
      list:   
        object_actions:  
          client:     
            action:         client
            condition:
              function:     getClient 
              # params:       "$model->getDbField(), $sf_user, 'test'"
              invert:       true     
  
6.,  _show_footer.php 
  kellhet, ha valamit a show alá szeretnénk tenni, akár egy javascriptet.
  
7., rendezés többféle rendezési mód:

  A legegyszerűbb:
    fieldname:   { is_sortable: true, function: rendezesfuggveny}
    Ekkor létre kell hozni egy rendezesfuggveny nevu függvenyt az actionben, 
    ami paramaéterben megkapja a queryt. Amivel már azt csinálunk amit akarunk :-)
    !!!Ez még nincs tesztelve!!!
    
  A kicsit összetetttebb:  
    fieldname:   { is_sortable: true, peer: KapcsolodoObjektumNeve, sort: KapcoslodoObjektumMezoje alias: KapcsolodoObjektumAliasa}
    1., ha van peer, akkor kapcsolni kell a tablat 
      a, ha van alias, akkor azzal az aliassal 
      b, vagy a peer lesz az alias is 
    2., ha nincs vagy false a peer, de van alias akkor nem kell kapcsolni a tablat, mar van kapcsolt tabla, amiről gondoskodni kell
    3., ha nincs vagy false a peer, és nincs vagy false alias is, akkor csak egy szarmaztatott mezo a root tablaban. 
        Ha a származtatott mezo egy subselect, akkor az alias false értéket kell kapjon
        
8., 
generator:
  class: jRollerDoctrineGenerator
  beállitás esetén a  jRollerDoctrineGenerator osztalyt használja 
  az sfDoctrineGeenrator(dfModelGenerator) osztály helyett
  
9.
sf_admin.title néven létrehozott slot felülírja a címet, akár a formoknál, akár a listánál

10., 
sf_admin.extend_url végigvezetve a templatek linkjein
// pl: 
slot('sf_admin.extend_url')
echo 'company='.sfContext::getInstance()->getRequest()->getParameter('company') 
end_slot();
// így belekerül a linkekbe a company paraméter is.
vagy actionben:
$this->getResponse()->setSlot('admin.extend_url', 'company='.$this->context->getRequest()->getParameter('company'));

11., Nyissuk meg automatikusan a szürőt:
    _list_footer.php - ba tegyük be egy jQuery blokba:  
    jQuery('#sf_admin_filter_button').trigger('click')

    
12., hogyan rejtsük el a lenyiló menüt:
$(function () {
    // ez elrejti a muveletek lenyilo menut, ha nincs benne semmi
    if($('#sf_admin_actions_menu_list').length != 0 && $('#sf_admin_actions_menu_list').children().length == 0) $('.sf_admin_actions_block').hide();
    
    // ez egy gombot csinal a muveletek lenyilo menubol, ha csak 1 eleme van a lenyilo menunek
    if($('#sf_admin_actions_menu_list').length != 0 && $('#sf_admin_actions_menu_list').children().length == 1) {
      $('.sf_admin_actions_block').html($('#sf_admin_actions_menu_list').html()).addClass('sf_admin_td_actions fg-buttonset fg-buttonset-single').attr('style', 'width: 500px;');
    }
});    
   
    
13, hogyan oldjuk meg a hogy a lista menuje szet legyen szedve:
    _list_footer.php - ba tegyük be egy jQuery blokba:
    jQuery('.sf_admin_actions_block').html($('#sf_admin_actions_menu_list').html()).addClass('sf_admin_td_actions fg-buttonset fg-buttonset-single').attr('style', 'width: 100%');
    /* a menüpontok jobbra */
    jQuery('.sf_admin_actions_block li').attr('style', 'float:right; margin-left:5px');
    /* az első menüpont (_new) balra */
    jQuery('.sf_admin_actions_block li:first').attr('style', 'float:left');
    /* ha szinezni akarnánk */
    jQuery('.sf_admin_action_new a').css("background", "yellow");