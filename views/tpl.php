<!-- ============================= PROFILER TOOLBAR ============================= -->
<?php echo View::factory('css')->render();?>
<?php echo View::factory('js')->render();?>
<div id="ptb">
  <ul id="ptb_toolbar" class="ptb_bg">
    <li class="info" title="ProfilerToolbar v<?=ProfilerToolbar::$version;?> for Kohana v3.2"><?=ProfilerToolbar::$version;?> / 3.2 <span class="icon"></span></li>
    <li class="time" title="application execution time">  <span class="icon"></span> <?=ProfilerToolbar::formatTime($_VARS_APP_TIME);?></li>
    <li class="ram" title="memory peak usage">            <span class="icon"></span> <?=ProfilerToolbar::formatMemory($_VARS_APP_MEMORY);?></li>
    <?php $_total = 0; foreach($_VARS_SQL as $v) $_total += $v['total']['count']; ?>
    <li class="sql">      <span class="icon"></span> sql <span class="total">(<?=$_total;?>)</span></li>
    <li class="cache">    <span class="icon"></span> cache <span class="total" title="get cache"><?=$_VARS_CACHE['total']['get'];?></span><span class="total" title="set cache">/<?=$_VARS_CACHE['total']['set'];?></span><span class="total" title="delete cache">/<?=$_VARS_CACHE['total']['del'];?></span></li>
    <li class="vars">     <span class="icon"></span> vars <span class="total" title="$_POST"><?=count($_POST);?></span><span class="total" title="$_GET">/<?=count($_GET);?></span><span class="total" title="$_FILES">/<?=count($_FILES);?></span><span class="total" title="$_COOKIE">/<?=count($_COOKIE);?></span><span class="total" title="$_SESSION">/<?=count($_SESSION);?></span></li>
    <li class="route">    <span class="icon"></span> route</li>
    <li class="files">    <span class="icon"></span> files <span class="total">(<?=$_VARS_FILES['total']['count'];?>)</span></li>
    <?php $_total = 0; foreach($_VARS_CUSTOM as $v) $_total += count($v); ?>
    <li class="custom">   <span class="icon"></span> YOUR <span class="total">(<?=$_total;?>)</span></li>
    <li class="hide"      title="Hide Profiler Toolbar"><span class="icon"></span></li>
    <li class="show"      title="Show Profiler Toolbar"><span class="icon"></span></li>
  </ul>
  <div id="ptb_data" class="ptb_bg" style="display: none;">
    <?=View::factory('items/sql')->render();?>
    <?=View::factory('items/cache')->render();?>
    <?=View::factory('items/vars')->render();?>
    <?=View::factory('items/route')->render();?>
    <?=View::factory('items/files')->render();?>
    <?=View::factory('items/custom')->render();?>
  </div>
</div>
<!-- ============================= /PROFILER TOOLBAR ============================= -->