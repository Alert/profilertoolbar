<script type="text/javascript">
  var PTB = {
    hCont:null,
    hToolbar:null,
    COOKIE_VISIBLE:'PTB_visible',
    COOKIE_VISIBLE_ITEM:'PTB_visible_item',
    COOKIE_VISIBLE_TAB:'PTB_visible_tab',
    init:function (){
      // handler of content element
      PTB.hCont = PTB.getEl('#ptb');
      // handler of toolbar element
      PTB.hToolbar = PTB.getEl('#ptb_toolbar');
      // onclick event listener of toolbar elements
      PTB.hToolbar.onclick = PTB.onClickTbEl;
      // onclick event listener of TABs
      var tabs = PTB.getEl('.ptb_tabs');
      for(var i=0;i<tabs.length;i++) tabs[i].onclick = function(e){
        var el = e.target || e.srcElement || e.originalTarget;
        if(el.nodeName.toLowerCase() == 'span') PTB.toggleTab(el.parentNode.id);
        else PTB.toggleTab(el.id);
      };
      // onclick event listener of explain sql
      var els = PTB.getEl('.explain');
      for(i=0;i<els.length;i++) els[i].onclick = function(e){
        var el = e.target || e.srcElement || e.originalTarget;
        PTB.toggle(el.nextElementSibling);
      };
      // show toolbar/item/tab if need
      if(PTB.getCookie(PTB.COOKIE_VISIBLE) === undefined) PTB.toggleToolbar();
      if((tmp = PTB.getCookie(PTB.COOKIE_VISIBLE_TAB))  !== undefined) PTB.toggleTab(tmp);
      if((tmp = PTB.getCookie(PTB.COOKIE_VISIBLE_ITEM)) !== undefined) PTB.toggleToolbarItem(tmp);
    },

    onClickTbEl:function(e){
      var el = e.srcElement || e.target;
      if(el.nodeName.toLowerCase() != 'li') el = el.parentNode;
      switch (el.className){
        case 'hide':
        case 'show':PTB.toggleToolbar();break;
        case 'info':break;
        default:PTB.toggleToolbarItem(el.className);
      }
    },

    toggleToolbar:function(){
      var items  = PTB.getEl('#ptb_toolbar').childNodes;
      for(var i=0;i<items.length;i++) {
        if(items[i].nodeName.toLowerCase() == 'li') PTB.toggle(items[i]);
      }
      PTB.toggle(PTB.getEl('#ptb_data'));
      // save
      if(PTB.getEl('#ptb_data').style.display == 'none') PTB.delCookie(PTB.COOKIE_VISIBLE);
      else PTB.setCookie(PTB.COOKIE_VISIBLE,"1");
    },
    toggleToolbarItem:function(name){
      var el = PTB.getEl('#ptb_data_cont_'+name);
      if(el === null) return;
      // hide only this tab if that was visible
      if(el.style.display == 'block') PTB.toggle(el);
      else{ // hide all and show active tab
        var items = PTB.getEl('.ptb_data_cont');
        for(var i=0;i<items.length;i++) items[i].style.display = 'none';
        PTB.toggle(el);
        // if not open at least one tab, then open the first
        var opened = false;
        var els = el.childNodes[1].childNodes;
        for(i=0;i<els.length;i++){
          if(els[i].nodeName.toLowerCase() == 'li' && PTB.hasClass(els[i],'use'))
            opened = true;
        }
        if(!opened) PTB.toggleTab(els[1].id);
      }
      // save
      if(el.style.display == 'none') PTB.delCookie(PTB.COOKIE_VISIBLE_ITEM);
      else PTB.setCookie(PTB.COOKIE_VISIBLE_ITEM,name);
    },
    toggleTab:function(id){
      var tabName = id.substr('ptb_tab_'.length);
      var tabEl = PTB.getEl('#'+id);
      // 1. set use class to active tab
      var tabs = PTB.getEl('.ptb_tabs');
      for(var i=0;i<tabs.length;i++){
        var items = tabs[i].childNodes;
        for(var j=0;j<items.length;j++) {
          if(items[j].nodeName.toLowerCase() == 'li') PTB.removeClass(items[j],'use');
        }
      }
      PTB.addClass(tabEl,'use');
      // 2. show tab_content for this tab
      items = PTB.getEl('.ptb_tab_cont');
      for(i=0;i<items.length;i++) items[i].style.display = 'none';
      PTB.getEl('#ptb_tab_cont_'+tabName).style.display = 'block';
      // 3. save
      PTB.setCookie(PTB.COOKIE_VISIBLE_TAB,id);
    },
    /* ---------- help ---------- */
    toggle:function(el){el.style.display = (el.style.display == 'none') ? 'block' : 'none'},
    getEl:function(name){
      if(name.substr(0,1) == '#') return document.getElementById(name.substr(1));
      else{
        if(PTB.hCont == null) return document.getElementsByClassName(name.substr(1));
        else return PTB.hCont.getElementsByClassName(name.substr(1));
      }
    },
    addClass:function(el, className){if (!this.hasClass(el,className)) el.className += " "+className;},
    removeClass:function(el, className){if (PTB.hasClass(el,className)) el.className=el.className.replace(new RegExp('(\\s|^)'+className+'(\\s|$)'),' ');},
    hasClass:function(el,className){return el.className.match(new RegExp('(\\s|^)'+className+'(\\s|$)'));},
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
    }
    /* ---------- /help ---------- */
  };
  window.onload = PTB.init;

</script>