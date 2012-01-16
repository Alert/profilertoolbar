<div id="ptb_data_cont_cache" class="ptb_data_cont">
  <ul class="ptb_tabs">
  <?php foreach($_VARS_CACHE['data'] as $k=>$v):?>
    <li id="ptb_tab_cache_<?=$k;?>"><?=$k;?> <span>(<?=$v['total']['get']+$v['total']['set']+$v['total']['del'];?>)</span></li>
  <?php endforeach;?>
  </ul>
  <?php $i=0; foreach($_VARS_CACHE['data'] as $instName=>$inst):?>
  <div id="ptb_tab_cont_cache_<?=$instName;?>" class="ptb_tab_cont">
    <table>
      <thead>
        <tr>
          <th>№</th>
          <th style="width:50px;">action</th>
          <th>id</th>
          <th style="width:80px;">lifetime</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($inst['data'] as $item):?>
          <tr>
            <td class="num"><?=++$i;?></td>
            <td class="tCenter"><?=$item['action'];?></td>
            <td><?=$item['id'];?></td>
            <td class="tRight"><?=$item['lifetime'];?> s</td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <?php endforeach;?>
</div>
