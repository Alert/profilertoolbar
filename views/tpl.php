<!-- ============================= PROFILER TOOLBAR ============================= -->
<?php echo View::factory('css')->render();?>
<?php echo View::factory('js')->render();?>
<div id="ptb">
  <ul id="ptb_toolbar" class="ptb_bg">
    <li class="info" title="ProfilerToolbar v<?php echo ProfilerToolbar::$version;?> for Kohana v3.2"><?php echo ProfilerToolbar::$version;?> / 3.2 <span class="icon"></span></li>
    <li class="time" title="application execution time">  <span class="icon"></span> <?php echo ProfilerToolbar::formatTime($_VARS_APP_TIME);?></li>
    <li class="ram" title="memory peak usage">            <span class="icon"></span> <?php echo ProfilerToolbar::formatMemory($_VARS_APP_MEMORY);?></li>
    <?php $_total = 0; foreach($_VARS_SQL as $v) $_total += $v['total']['count']; ?>
    <li class="sql">      <span class="icon"></span> sql <span class="total">(<?php echo $_total;?>)</span></li>
    <li class="cache">    <span class="icon"></span> cache <span class="total" title="get cache"><?php echo $_VARS_CACHE['total']['get'];?></span><span class="total" title="set cache">/<?php echo $_VARS_CACHE['total']['set'];?></span><span class="total" title="delete cache">/<?php echo $_VARS_CACHE['total']['del'];?></span></li>
    <li class="vars">     <span class="icon"></span> vars <span class="total" title="$_POST"><?php echo count($_VARS_POST);?></span><span class="total" title="$_GET">/<?php echo count($_VARS_GET);?></span><span class="total" title="$_FILES">/<?php echo count($_VARS_FILES);?></span><span class="total" title="$_COOKIE">/<?php echo count($_VARS_COOKIE);?></span><span class="total" title="$_SESSION">/<?php echo count($_VARS_SESSION);?></span></li>
    <li class="route">    <span class="icon"></span> route</li>
    <li class="files">    <span class="icon"></span> files <span class="total">(<?php echo $_VARS_INCFILES['total']['count'];?>)</span></li>
    <?php $_total = 0; foreach($_VARS_CUSTOM as $v) $_total += count($v); ?>
    <li class="custom">   <span class="icon"></span> YOUR <span class="total">(<?php echo $_total;?>)</span></li>
    <li class="hide"      title="Hide Profiler Toolbar"><span class="icon"></span></li>
    <li class="show"      title="Show Profiler Toolbar"><span class="icon"></span></li>
  </ul>
  <div id="ptb_data" class="ptb_bg" style="display: none;">
    <?php echo View::factory('items/sql')->render();?>
    <?php echo View::factory('items/cache')->render();?>
    <?php echo View::factory('items/vars')->render();?>
    <?php echo View::factory('items/route')->render();?>
    <?php echo View::factory('items/files')->render();?>
    <?php echo View::factory('items/custom')->render();?>
  </div>
</div>
<!-- ============================= /PROFILER TOOLBAR ============================= -->