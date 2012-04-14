<div id="ptb_data_cont_vars" class="ptb_data_cont" style="display: none;">
  <ul class="ptb_tabs">
    <li id="ptb_tab_varsPGF">$_POST<span>(<?php echo count(ProfilerToolbar::$DATA_POST);?>)</span> / $_GET<span>(<?php echo count(ProfilerToolbar::$DATA_GET);?>)</span> / $_FILES<span>(<?php echo count(ProfilerToolbar::$DATA_FILES);?>)</span></li>
    <li id="ptb_tab_varsCS">$_COOKIE<span>(<?php echo count(ProfilerToolbar::$DATA_COOKIE);?>)</span> / $_SESSION<span>(<?php echo count(ProfilerToolbar::$DATA_SESSION);?>)</span></li>
    <li id="ptb_tab_varsS">$_SERVER</li>
  </ul>
  <div class="ptb_tab_cont" id="ptb_tab_cont_varsPGF">
    <!-- POST/GET/FILES -->
    <?php $vars = array('POST'=>ProfilerToolbar::$DATA_POST,'GET'=>ProfilerToolbar::$DATA_GET);?>
    <?php foreach ($vars as $kvar=>$var):?>
    <table style="float: left; width: <?php echo ($kvar=='POST')?50:45;?>%;">
      <thead>
        <tr><th colspan="3"><?php echo $kvar;?></th></tr>
        <tr>
          <th>№</th>
          <th style="width: 1px;">key</th>
          <th>value</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($var)):?><tr><td colspan="3" class="empty">—</td></tr><?php else:?>
      <?php $i=0; foreach ($var as $k => $v):?>
        <tr>
          <td class="num"><?php echo ++$i;?></td>
          <td><?php echo $k;?></td>
          <td><?php echo ProfilerToolbar::varDump($v)?></td>
        </tr>
        <?php endforeach;?>
      <?php endif;?>
      </tbody>
    </table>
    <?php endforeach;?>
    <table class="centr" style="clear: both;">
      <thead>
        <tr><th colspan="7">FILES</th></tr>
        <tr>
          <th>№</th>
          <th style="width: 1px;">key</th>
          <th>name</th>
          <th>type</th>
          <th>tmp_name</th>
          <th>error</th>
          <th>size</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty(ProfilerToolbar::$DATA_FILES)):?><tr><td colspan="7" class="empty">—</td></tr><?php else:?>
        <?php $i=0; foreach (ProfilerToolbar::$DATA_FILES as $k => $v):?>
        <tr>
          <td class="num"><?php echo ++$i;?></td>
          <td class="nowrap"><?php echo $k;?></td>
          <td><?php echo $v['name'];?></td>
          <td><?php echo $v['type'];?></td>
          <td><?php echo $v['tmp_name'];?></td>
          <td><?php echo $v['error'];?></td>
          <td><?php echo ProfilerToolbar::formatMemory($v['size']);?></td>
        </tr>
        <?php endforeach;?>
      <?php endif;?>
      </tbody>
    </table>
  </div>
  <div class="ptb_tab_cont" id="ptb_tab_cont_varsCS">
    <!-- COOKIE/SESSION -->
    <?php $vars = array('COOKIE'=>ProfilerToolbar::$DATA_COOKIE,'SESSION'=>ProfilerToolbar::$DATA_SESSION);?>
    <?php foreach ($vars as $kvar=>$var):?>
    <table style="float: left; width: 45%;">
      <thead>
        <tr><th colspan="3"><?php echo $kvar;?></th></tr>
        <tr>
          <th>№</th>
          <th style="width: 1px;">key</th>
          <th>value</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($var)):?><tr><td colspan="3" class="empty">—</td></tr><?php else:?>
        <?php $i=0; foreach ($var as $k => $v):?>
        <tr>
          <td class="num"><?php echo ++$i;?></td>
          <td><?php echo $k;?></td>
          <td><?php echo ProfilerToolbar::varDump($v);?></td>
        </tr>
        <?php endforeach;?>
      <?php endif;?>
      </tbody>
    </table>
    <?php endforeach;?>
  </div>
  <div class="ptb_tab_cont" id="ptb_tab_cont_varsS">
    <!-- SERVER -->
    <table>
      <thead>
        <tr>
          <th>№</th>
          <th style="width: 1px;">key</th>
          <th>value</th>
        </tr>
      </thead>
      <tbody>
      <?php $i=0; foreach (ProfilerToolbar::$DATA_SERVER as $k => $v):?>
      <tr>
        <td class="num"><?php echo ++$i;?></td>
        <td><?php echo $k;?></td>
        <td><?php echo ProfilerToolbar::varDump($v);?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>