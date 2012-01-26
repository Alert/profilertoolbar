<div id="ptb_data_cont_sql" class="ptb_data_cont" style="display: none;">
  <?php if(empty($_VARS_SQL)):?>
    <ul class="ptb_tabs">
      <li id="ptb_tab_sql_default">default <span>(0)</span></li>
    </ul>
    <div id="ptb_tab_cont_sql_default" class="ptb_tab_cont"></div>
  <?php else:?>
  <ul class="ptb_tabs">
  <?php foreach($_VARS_SQL as $k=>$v):?>
    <li id="ptb_tab_sql<?=$k;?>"><?=$k;?> <span>(<?=$v['total']['count'];?>)</span></li>
  <?php endforeach;?>
  </ul>
  <?php foreach($_VARS_SQL as $k=>$group):?>
  <div id="ptb_tab_cont_sql<?=$k;?>" class="ptb_tab_cont">
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
          <td class="num"><?=$i+1;?></td>
          <td>
            <?php if(!empty($v['explain'])):?>
              <a href="#" class="explain" title="show EXPLAIN query">EXPLAIN</a>
            <?php endif;?>
            <?=$v['sql'];?>
            <?php if(!empty($v['explain'])):?>
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
                <td><?=$r['id'];?></td>
                <td><?=$r['select_type'];?></td>
                <td><?=$r['table'];?></td>
                <td><?=$r['type'];?></td>
                <td><?=$r['possible_keys'];?></td>
                <td><?=$r['key'];?></td>
                <td><?=$r['key_len'];?></td>
                <td><?=$r['ref'];?></td>
                <td><?=$r['rows'];?></td>
                <td><?=$r['Extra'];?></td>
              </tr>
              <?php endforeach;?>
            </table>
            <?php endif;?>
          </td>
          <td class="tCenter"><?=$v['rows'];?></td>
          <td class="tRight graph">
            <div class="val"><?=ProfilerToolbar::formatTime($v['time']);?></div>
            <div class="line" style="width:<?=round($v['time']/$group['total']['time']*100);?>%;"></div>
          </td>
          <td class="tRight graph">
            <div class="val"><?=ProfilerToolbar::formatMemory($v['memory']);?></div>
            <div class="line" style="width:<?=round($v['memory']/$group['total']['memory']*100);?>%;"></div>
          </td>
        </tr>
      <?php endforeach;?>
      <tr class="total">
        <td></td>
        <td>total <?=$group['total']['count'];?> queries</td>
        <td></td>
        <td class="tRight"><?=ProfilerToolbar::formatTime($group['total']['time']);?></td>
        <td class="tRight"><?=ProfilerToolbar::formatMemory($group['total']['memory']);?></td>
      </tr>
      </tbody>
    </table>
  </div>
  <?php endforeach;?>
  <?php endif;?>
</div>