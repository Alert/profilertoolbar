<?php $SHOW_EXPLAIN = ProfilerToolbar::cfg('html.showSqlExplain');?>

<div id="ptb_data_cont_sql" class="ptb_data_cont" style="display: none;">
  <?php if(empty(ProfilerToolbar::$DATA_SQL)):?>
    <ul class="ptb_tabs">
      <li id="ptb_tab_sql_default">default <span>(0)</span></li>
    </ul>
    <div id="ptb_tab_cont_sql_default" class="ptb_tab_cont">
      <table><tr><td colspan="5" class="empty">—</td></tr></table>
    </div>
  <?php else:?>
  <ul class="ptb_tabs">
  <?php foreach(ProfilerToolbar::$DATA_SQL as $k=>$v):?>
    <li id="ptb_tab_sql<?php echo $k;?>"><?php echo $k;?> <span>(<?php echo $v['total']['count'];?>)</span></li>
  <?php endforeach;?>
  </ul>
  <?php foreach(ProfilerToolbar::$DATA_SQL as $k=>$group):?>
  <div id="ptb_tab_cont_sql<?php echo $k;?>" class="ptb_tab_cont">
    <table>
      <thead>
        <tr>
          <th>№</th>
          <th>query</th>
          <th style="width:50px;">rows</th>
          <th style="width:80px;">time</th>
          <th style="width:70px;">memory</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($group['data'] as $i=>$v):?>
        <tr>
          <td class="num"><?php echo $i+1;?></td>
          <td>
            <?php if($SHOW_EXPLAIN && !empty($v['explain'])):?>
              <a href="#" class="explain" title="show EXPLAIN query">EXPLAIN</a>
            <?php endif;?>
            <?php echo $v['sql'];?>
            <?php if($SHOW_EXPLAIN && !empty($v['explain'])):?>
            <table style="display: none;">
              <thead>
              <tr>
                <th style="width: 10px;">id</th>
                <th style="width: 80px;">select_type</th>
                <th style="width: 80px;">table</th>
                <th style="width: 40px;">type</th>
                <th style="width: 80px;">possible_keys</th>
                <th style="width: 80px;">key</th>
                <th style="width: 40px;">key_len</th>
                <th style="width: 100px;">ref</th>
                <th style="width: 20px;">rows</th>
                <th>Extra</th>
              </tr>
              </thead>
              <?php foreach ($v['explain'] as $r):?>
              <tr>
                <td><?php echo $r['id'];?></td>
                <td><?php echo $r['select_type'];?></td>
                <td><?php echo $r['table'];?></td>
                <td><?php echo $r['type'];?></td>
                <td><?php echo $r['possible_keys'];?></td>
                <td><?php echo $r['key'];?></td>
                <td><?php echo $r['key_len'];?></td>
                <td><?php echo $r['ref'];?></td>
                <td><?php echo $r['rows'];?></td>
                <td><?php echo $r['Extra'];?></td>
              </tr>
              <?php endforeach;?>
            </table>
            <?php endif;?>
          </td>
          <td class="tCenter"><?php echo $v['rows'];?></td>
          <td class="tRight graph">
            <div class="val"><?php echo ProfilerToolbar::formatTime($v['time']);?></div>
            <div class="line" style="width:<?php echo round($v['time']/$group['total']['time']*100);?>%;"></div>
          </td>
          <td class="tRight graph">
            <div class="val"><?php echo ProfilerToolbar::formatMemory($v['memory']);?></div>
            <div class="line" style="width:<?php echo round($v['memory']/$group['total']['memory']*100);?>%;"></div>
          </td>
        </tr>
      <?php endforeach;?>
      <tr class="total">
        <td></td>
        <td>total <?php echo $group['total']['count'];?> queries</td>
        <td></td>
        <td class="tRight"><?php echo ProfilerToolbar::formatTime($group['total']['time']);?></td>
        <td class="tRight"><?php echo ProfilerToolbar::formatMemory($group['total']['memory']);?></td>
      </tr>
      </tbody>
    </table>
  </div>
  <?php endforeach;?>
  <?php endif;?>
</div>