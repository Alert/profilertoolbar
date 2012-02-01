<div id="ptb_data_cont_custom" class="ptb_data_cont" style="display: none;">

  <?php if(empty(ProfilerToolbar::$DATA_CUSTOM)):?>
  <ul class="ptb_tabs">
    <li id="ptb_tab_custom_default">default</li>
  </ul>
  <div id="ptb_tab_cont_custom_default" class="ptb_tab_cont"></div>
  <?php else:?>

    <ul class="ptb_tabs">
    <?php foreach(ProfilerToolbar::$DATA_CUSTOM as $k=>$v):?>
      <li id="ptb_tab_custom_<?php echo $k;?>"><?php echo $k;?></li>
    <?php endforeach;?>
    </ul>
    <?php foreach(ProfilerToolbar::$DATA_CUSTOM as $k=>$v):?>
    <div id="ptb_tab_cont_custom_<?php echo $k;?>" class="ptb_tab_cont">
      <table>
        <thead>
          <tr>
            <th>№</th>
            <th>var</th>
          </tr>
        </thead>
      <?php $i=0; foreach($v as $item):?>
        <tr>
          <td class="num"><?php echo ++$i;?></td>
          <td><?php echo ProfilerToolbar::varDump($item);?></td>
        </tr>
      <?php endforeach;?>
      </table>

    </div>
    <?php endforeach;?>

  <?php endif;?>
</div>