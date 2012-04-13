<?php
$MAIN_FONT = 'Tahoma,sans-serif';
$MAIN_FONT_SIZE = '8pt';

$C_1 = 'gray';
$C_2 = '#919191';
$C_3 = '#ababab';
$C_4 = '#424242';
$C_4_HOVER = 'rgba(0, 0, 0, 0.16)';

$C_TABS = '#cfcfcf';
$C_TABS_COUNT = 'gray';
$C_TABS_BORDER = 'gray';
$C_TABS_BORDER_USE = '#1a1a1a';
?>
<style type="text/css">
  .ptb_bg{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAAAAACMmsGiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAABdJREFUCB1jUlGRkWH6CQRMf//y8oJZAFUaCmUwcfODAAAAAElFTkSuQmCC) !important;}
  #ptb{}
  #ptb *{padding:0; margin:0; font: <?php echo $MAIN_FONT_SIZE;?> <?php echo $MAIN_FONT;?>; background: none; text-decoration: none; border:none;}
  #ptb .nowrap{white-space: nowrap;}
  #ptb table{font-family: <?php echo $MAIN_FONT;?>; font-size: <?php echo $MAIN_FONT_SIZE;?>; color:<?php echo $C_1;?>; font-weight: normal; border: 0; padding: 0; border-collapse:collapse; margin: 10px; width:98%;}
  #ptb table thead tr{border: 1px solid transparent; border-bottom: none;}
  #ptb table thead th{text-align: center;}
  #ptb table tbody tr:hover{}
  #ptb table tbody tr.total{border-top: 1px solid gray;border-bottom: 1px solid gray;}
  #ptb table tbody tr:hover{background-color: <?php echo $C_4_HOVER;?>;}
  #ptb table td{padding:1px 5px; text-align: left; vertical-align: top; border: 1px dotted <?php echo $C_4;?>;}
  #ptb table td.num{text-align: center; padding: 1px 2px; border: none; width: 20px;}
  #ptb table td.empty{text-align: center; padding: 10px;}
  #ptb table td.tRight,#ptb table th.tRight{text-align: right;}
  #ptb table td.tCenter,#ptb table th.tCenter{text-align: center;}
  #ptb table td.graph{padding: 0;}
  #ptb table td.graph div.line{background-color: <?php echo $C_2;?>; width: 0; height: 2px; float: right;}
  #ptb table td.graph div.val{padding: 1px 5px;}
  #ptb table.centr td{text-align: center;}
  #ptb_toolbar{position: fixed; height: 20px; top:0; right:0; z-index: 100501; border: 1px solid <?php echo $C_1;?>; border-top: none; border-radius: 0 0 0 5px; color: <?php echo $C_3;?>; padding: 2px 0; list-style: none;}
  #ptb_toolbar a{color: <?php echo $C_3;?>;}
  #ptb_toolbar li{display: none;}
  #ptb_toolbar li span.icon{width: 16px; height:16px; display: inline-block;vertical-align: top; background: url(data:image/png;base64,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) no-repeat left top;}
  #ptb_toolbar li span.total{color:<?php echo $C_1;?>;}
  #ptb_toolbar li.cache    span.icon{background-position: -0px 0;}
  #ptb_toolbar li.files    span.icon{background-position: -16px 0;}
  #ptb_toolbar li.ram{cursor: auto;}
  #ptb_toolbar li.ram      span.icon{background-position: -32px 0;}
  #ptb_toolbar li.modules  span.icon{background-position: -48px 0;}
  #ptb_toolbar li.route    span.icon{background-position: -64px 0;}
  #ptb_toolbar li.sql      span.icon{background-position: -80px 0;}
  #ptb_toolbar li.time{cursor: auto;}
  #ptb_toolbar li.time     span.icon{background-position: -96px 0;}
  #ptb_toolbar li.vars     span.icon{background-position: -112px 0;}
  #ptb_toolbar li.custom   span.icon{background-position: -128px 0;}
  #ptb_toolbar li.info     span.icon{background-position: -144px 0; cursor: help;}
  #ptb_toolbar li.info a{text-decoration: none;}
  #ptb_toolbar li.hide     span.icon{background-position: -160px 0;}
  #ptb_toolbar li.show {border: none; display: block;}
  #ptb_toolbar li.show     span.icon{background-position: -176px 0;}
  #ptb_toolbar li{float: left; border-left: 1px solid <?php echo $C_1;?>; padding: 2px 4px; margin: 0; cursor: pointer;}
  #ptb_toolbar li img{margin-right: 2px;}
  #ptb_toolbar li:first-child{border:none;}
  #ptb_data{position: absolute; top:0; left: 0; width: 100%; border-bottom: 1px solid gray; padding:0; margin-top: -1px; z-index: 100499; color:<?php echo $C_1;?>;}
  #ptb_data .ptb_data_cont{display: none; margin-top: 6px;}
  #ptb_data ul.ptb_tabs{list-style: none; margin: 0 0 -1px 15px; padding:0; overflow: hidden; font-size: 8pt; color: <?php echo $C_TABS;?>;}
  #ptb_data ul.ptb_tabs span{color:<?php echo $C_TABS_COUNT;?>;}
  #ptb_data ul.ptb_tabs li{height: 14px; border: 1px solid <?php echo $C_TABS_BORDER;?>; float: left; margin:0 3px; padding: 2px 3px; cursor: pointer; border-radius: 5px 5px 0 0;}
  #ptb_data ul.ptb_tabs li.use{border-bottom: 1px solid <?php echo $C_TABS_BORDER_USE;?>; color:white;}
  #ptb_data .ptb_tab_cont {border-top: 1px solid <?php echo $C_TABS_BORDER;?>; display: none; margin-bottom: 10px;}
  #ptb_data a.explain{border-bottom:1px solid <?php echo $C_4;?>; font-size: 8pt; color:<?php echo $C_4;?>; text-decoration: none;}
  #ptb_data pre{background-color: transparent; color:<?=$C_1;?>; }
  #ptb_data pre.source{overflow: auto; white-space: pre-wrap; font-size: 9pt; line-height: 12pt; margin: 4px 0; border-radius: 3px; padding: 4px 5px 4px 8px; background-color: transparent; color: white;}
  #ptb_data pre.source span.line { display: block; }
  #ptb_data pre.source span.highlight { background: #414040; }
  #ptb_data pre.source span.line span.num { color: #666; }
  <!-- highlight -->
  #ptb_data pre.sql .imp {font-weight: bold; color: red;}
  #ptb_data pre.sql .kw1 {color: #388fff;}
  #ptb_data pre.sql .co1 {color: #808080;}
  #ptb_data pre.sql .co2 {color: #808080;}
  #ptb_data pre.sql .coMULTI {color: #808080;}
  #ptb_data pre.sql .es0 {color: #000099; font-weight: bold;}
  #ptb_data pre.sql .br0 {}
  #ptb_data pre.sql .st0 {color: #ff9933;}
  #ptb_data pre.sql .nu0 {color: #66ff00;}
  <!-- /highlight -->
  
</style>