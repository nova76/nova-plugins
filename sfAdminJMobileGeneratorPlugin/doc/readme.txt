sfAdminThemejRoller pluginból lett elkészítve, ezért annak sok funkciója nem lett kiírtva!

telepítése: 
enable plugins: sfAdminJMobileGeneratorPlugin
./symfony plugin:publish-assets

./symfony doctrine:build-forms --generator-class="sfDoctrineFormGeneratorMobile"
./symfony  doctrine:generate-admin --module=MobileProduct frontend Product  --theme='jmobile'
./symfony  doctrine:generate-admin --module=MobileProduct frontend Product

vagy:
./symfony generate:all-admin --application="mobile"
./symfony plugin:publish-assets


paraméterek:
nagyjából megegyezik a sfAdminThemejRoller pluginnal
list.route : megadható a listához a route is, ha nem a szerkesztés a nekünk megfelelő

extra menüpont:
edit:
  actions: 
    _print:
      show: [top, bottom, header] #header a felső fekete szakasz, a top felül, a bottom alul
      action: print 
      label: 'Nyomtatás'