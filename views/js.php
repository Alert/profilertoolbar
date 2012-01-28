<script type="text/javascript">
  var PTB = {
    hCont:null,
    hToolbar:null,
    COOKIE_VISIBLE:'PTB_visible',
    COOKIE_VISIBLE_ITEM:'PTB_visible_item',
    COOKIE_VISIBLE_TAB:'PTB_visible_tab',
    VISIBLE:false,
    VISIBLE_ITEM:null,
    VISIBLE_TAB:null,
    init:function (){
      PTB.hCont = PTB.getEl('#ptb'); // handler of main content
      PTB.hToolbar = PTB.getEl('#ptb_toolbar'); // handler of toolbar element
      PTB.hToolbar.onclick = PTB.onClickToolbarEl; // onclick event listener of toolbar elements
      // onclick event listener of data TABs
      var tabs = PTB.getEl('.ptb_tabs');
      for(var i=0;i<tabs.length;i++) tabs[i].onclick = PTB.onClickDataTab;
      // onclick event listener of explain sql
      var els = PTB.getEl('.explain');
      for(i=0;i<els.length;i++) els[i].onclick = PTB.onClickExplainQuery;
      // show toolbar/item/tab if need
      if(PTB.getCookie(PTB.COOKIE_VISIBLE) == 'true') PTB.toggleToolbar();
      if((tmp = PTB.getCookie(PTB.COOKIE_VISIBLE_TAB)) != undefined) PTB.toggleTab(tmp);
      if((tmp = PTB.getCookie(PTB.COOKIE_VISIBLE_ITEM)) != undefined) PTB.toggleToolbarItem(tmp);
    },

    onClickToolbarEl:function(e){
      var el = e.srcElement || e.target;
      if(el.nodeName.toLowerCase() != 'li') el = el.parentNode;
      switch (el.className){
        case 'hide':
        case 'show':PTB.toggleToolbar();break;
        case 'info':break;
        default:PTB.toggleToolbarItem('ptb_data_cont_'+el.className);
      }
    },
    onClickDataTab:function(e){
      var el = e.target || e.srcElement || e.originalTarget;
      if(el.nodeName.toLowerCase() == 'span') PTB.toggleTab(el.parentNode.id);
      else PTB.toggleTab(el.id);
    },
    onClickExplainQuery:function(e){
      var el = e.target || e.srcElement || e.originalTarget;
      PTB.toggle(el.nextElementSibling);
      PTB.updateDataContPosition();
    },

    toggleToolbar:function(){
      var items  = PTB.getEl('#ptb_toolbar').childNodes;
      for(var i=0;i<items.length;i++) {
        if(items[i].nodeName.toLowerCase() == 'li') items[i].style.display = (PTB.VISIBLE)?'none':'block';
      }
      items[items.length-2].style.display = (PTB.VISIBLE)?'block':'none';
      PTB.getEl('#ptb_data').style.display = (PTB.VISIBLE)?'none':'block';
      // save
      PTB.VISIBLE = !PTB.VISIBLE;
      PTB.setCookie(PTB.COOKIE_VISIBLE,PTB.VISIBLE);
    },
    toggleToolbarItem:function(id){
      var el = PTB.getEl('#'+id);
      if(el === null) return;
      if(el.id == PTB.VISIBLE_ITEM){
        el.style.display = 'none';
        PTB.VISIBLE_ITEM = null;
        PTB.setCookie(PTB.COOKIE_VISIBLE_ITEM,null);
      }else{
        // hide all and show active item
        var items = PTB.getEl('.ptb_data_cont');
        for(var i=0;i<items.length;i++) items[i].style.display = 'none';
        el.style.display = 'block';
        // save
        PTB.VISIBLE_ITEM = id;
        PTB.setCookie(PTB.COOKIE_VISIBLE_ITEM,PTB.VISIBLE_ITEM);
        // if this item don't have opened tabs - open first tab
        var tabs = el.childNodes[1].childNodes;
        var open = false;
        for(i=0;i<tabs.length;i++){
          if(PTB.VISIBLE_TAB !== null && tabs[i].id == PTB.VISIBLE_TAB){
            open = true;
            break;
          }
        }
        if(!open) PTB.toggleTab(tabs[1].id);
        else PTB.updateDataContPosition();
      }
    },
    toggleTab:function(id){
      var tabName = id.substr('ptb_tab_'.length);
      // del use class from all tabs
      var tabs = PTB.getEl('.ptb_tabs');
      for(var i=0;i<tabs.length;i++){
        for(var j=0;j<tabs[i].childNodes.length;j++) {
          if(tabs[i].childNodes[j].nodeName.toLowerCase() == 'li') PTB.removeClass(tabs[i].childNodes[j],'use');
        }
      }

      // set use class to active tab
      PTB.addClass(PTB.getEl('#'+id),'use');
      // hide content for all tabs
      var cont = PTB.getEl('.ptb_tab_cont');
      for(i=0;i<cont.length;i++) cont[i].style.display = 'none';
      // show content for active tab
      cont = PTB.getEl('#ptb_tab_cont_'+tabName);
      if(cont != null){
        cont.style.display = 'block';
        PTB.VISIBLE_TAB = id;
        PTB.setCookie(PTB.COOKIE_VISIBLE_TAB,PTB.VISIBLE_TAB);
      }
      PTB.updateDataContPosition();
    },
    updateDataContPosition:function(){
      var cont = PTB.getEl('#ptb_data');
      if(cont.offsetHeight > PTB.getViewportHeight()){
        cont.style.position = 'absolute';
      }else{
        cont.style.position = 'fixed';
      }
    },
    /* ---------- help ---------- */
    toggle:function(el){el.style.display = (el.style.display == 'block' || el.style.display == '') ? 'none' : 'block'},
    getEl:function(name){
      if(name.substr(0,1) == '#') return document.getElementById(name.substr(1));
      else{
        if(PTB.hCont == null) return document.getElementsByClassName(name.substr(1));
        else return PTB.hCont.getElementsByClassName(name.substr(1));
      }
    },
    addClass:function(el, className){if(el == null) return false; if (!this.hasClass(el,className)) el.className += " "+className;},
    removeClass:function(el, className){if (PTB.hasClass(el,className)) el.className=el.className.replace(new RegExp('(\\s|^)'+className+'(\\s|$)'),' ');},
    hasClass:function(el,className){if(el == null) return false; return el.className.match(new RegExp('(\\s|^)'+className+'(\\s|$)'));},
    setCookie:function(name,val){
      var date = new Date();
      date.setDate(date.getDate() + 7);
      document.cookie = name+"="+val+"; expires="+date.toGMTString()+"; path=/;";
    },
    delCookie:function(name){
      var date = new Date();
      date.setTime(date.getTime()-1);
      document.cookie = name += "=; expires="+date.toGMTString();
    },
    getCookie:function(name){
      var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
      return matches ? decodeURIComponent(matches[1]) : undefined
    },
    getViewportHeight:function(){
      var e = window,a = 'inner';
      if (!('innerWidth' in window)){a = 'client';e = document.documentElement || document.body;}
      return e[ a+'Height' ];
    }
    /* ---------- /help ---------- */
  };
  window.onload = PTB.init;

</script>