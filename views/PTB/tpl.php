<!-- ============================= PROFILER TOOLBAR ============================= -->
<?php echo View::factory('PTB/css')->render();?>
<?php echo View::factory('PTB/js')->render();?>
<div id="ptb">
  <ul id="ptb_toolbar" class="ptb_bg">
    <li class="info">
      <a href="http://alertdevelop.ru/projects/profilertoolbar" title="Go to module web site"><?php echo ProfilerToolbar::$version;?></a>
      /
      <a href="http://kohanaframework.org/" title="Go to kohana web site">3.2</a>
      <span class="icon" title="ProfilerToolbar v<?php echo ProfilerToolbar::$version;?> for Kohana v<?php echo ProfilerToolbar::$kohana_version;?>"></span>
    </li>
    <?php if(ProfilerToolbar::cfg('html.showTotalInfo')):?>
      <li class="time" title="application execution time">  <span class="icon"></span> <?php echo ProfilerToolbar::formatTime(ProfilerToolbar::$DATA_APP_TIME);?></li>
      <li class="ram" title="memory peak usage">            <span class="icon"></span> <?php echo ProfilerToolbar::formatMemory(ProfilerToolbar::$DATA_APP_MEMORY);?></li>
    <?php endif;?>
    <?php if(ProfilerToolbar::cfg('html.showSql')):?>
      <?php $_total = 0; foreach(ProfilerToolbar::$DATA_SQL as $v) $_total += $v['total']['count']; ?>
      <li class="sql">      <span class="icon"></span> sql <span class="total">(<?php echo $_total;?>)</span></li>
    <?php endif;?>
    <?php if(ProfilerToolbar::cfg('html.showCache')):?>
      <li class="cache">    <span class="icon"></span> cache <span class="total" title="get cache"><?php echo ProfilerToolbar::$DATA_CACHE['total']['get'];?></span><span class="total" title="set cache">/<?php echo ProfilerToolbar::$DATA_CACHE['total']['set'];?></span><span class="total" title="delete cache">/<?php echo ProfilerToolbar::$DATA_CACHE['total']['del'];?></span></li>
    <?php endif;?>
    <?php if(ProfilerToolbar::cfg('html.showVars')):?>
      <li class="vars">     <span class="icon"></span> vars <span class="total" title="$_POST"><?php echo count(ProfilerToolbar::$DATA_POST);?></span><span class="total" title="$_GET">/<?php echo count(ProfilerToolbar::$DATA_GET);?></span><span class="total" title="$_FILES">/<?php echo count(ProfilerToolbar::$DATA_FILES);?></span><span class="total" title="$_COOKIE">/<?php echo count(ProfilerToolbar::$DATA_COOKIE);?></span><span class="total" title="$_SESSION">/<?php echo count(ProfilerToolbar::$DATA_SESSION);?></span></li>
    <?php endif;?>
    <?php if(ProfilerToolbar::cfg('html.showRoutes')):?>
      <li class="route">    <span class="icon"></span> route</li>
    <?php endif;?>
    <?php if(ProfilerToolbar::cfg('html.showIncFiles')):?>
      <li class="files">    <span class="icon"></span> files <span class="total">(<?php echo ProfilerToolbar::$DATA_INC_FILES['total']['count'];?>)</span></li>
    <?php endif;?>
    <?php if(ProfilerToolbar::cfg('html.showCustom')):?>
      <?php $_total = 0; foreach(ProfilerToolbar::$DATA_CUSTOM as $v) $_total += count($v); ?>
      <li class="custom">   <span class="icon"></span> YOUR <span class="total">(<?php echo $_total;?>)</span></li>
    <?php endif;?>
    <li class="hide"      title="Hide Profiler Toolbar"><span class="icon"></span></li>
    <li class="show"      title="Show Profiler Toolbar"><span class="icon"></span></li>
  </ul>
  <div id="ptb_data" class="ptb_bg" style="display: none;">
    <?php if(ProfilerToolbar::cfg('html.showSql'))      echo View::factory('PTB/items/sql')->render();?>
    <?php if(ProfilerToolbar::cfg('html.showCache'))    echo View::factory('PTB/items/cache')->render();?>
    <?php if(ProfilerToolbar::cfg('html.showVars'))     echo View::factory('PTB/items/vars')->render();?>
    <?php if(ProfilerToolbar::cfg('html.showRoutes'))   echo View::factory('PTB/items/route')->render();?>
    <?php if(ProfilerToolbar::cfg('html.showIncFiles')) echo View::factory('PTB/items/files')->render();?>
    <?php if(ProfilerToolbar::cfg('html.showCustom'))   echo View::factory('PTB/items/custom')->render();?>
  </div>
</div>
<!-- ============================= /PROFILER TOOLBAR ============================= -->