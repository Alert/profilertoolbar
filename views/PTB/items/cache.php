<div id="ptb_data_cont_cache" class="ptb_data_cont" style="display: none;">
  <ul class="ptb_tabs">
  <?php foreach(ProfilerToolbar::$DATA_CACHE['data'] as $k=>$v):?>
    <li id="ptb_tab_cache_<?php echo $k;?>"><?php echo $k;?> <span>(<?php echo $v['total']['get']+$v['total']['set']+$v['total']['del'];?>)</span></li>
  <?php endforeach;?>
  </ul>
  <?php $i=0; foreach(ProfilerToolbar::$DATA_CACHE['data'] as $instName=>$inst):?>
  <div id="ptb_tab_cont_cache_<?php echo $instName;?>" class="ptb_tab_cont">
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
        <?php if(empty($inst['data'])):?><tr><td colspan="4" class="empty">—</td></tr><?php else:?>
          <?php foreach($inst['data'] as $item):?>
            <tr>
              <td class="num"><?php echo ++$i;?></td>
              <td class="tCenter"><?php echo $item['action'];?></td>
              <td><?php echo $item['id'];?></td>
              <td class="tRight"><?php echo (!empty($item['lifetime']))?$item['lifetime'].' s':'—';?></td>
            </tr>
          <?php endforeach;?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <?php endforeach;?>
</div>
