<div id="ptb_data_cont_custom" class="ptb_data_cont" style="display: none;">

  <?php if(empty($_VARS_CUSTOM)):?>
  <ul class="ptb_tabs">
    <li id="ptb_tab_custom_default">default</li>
  </ul>
  <div id="ptb_tab_cont_custom_default" class="ptb_tab_cont"></div>
  <?php else:?>

    <ul class="ptb_tabs">
    <?php foreach($_VARS_CUSTOM as $k=>$v):?>
      <li id="ptb_tab_custom_<?=$k;?>"><?=$k;?></li>
    <?php endforeach;?>
    </ul>
    <?php foreach($_VARS_CUSTOM as $k=>$v):?>
    <div id="ptb_tab_cont_custom_<?=$k;?>" class="ptb_tab_cont">
      <table>
        <thead>
          <tr>
            <th>№</th>
            <th>var</th>
          </tr>
        </thead>
      <?php $i=0; foreach($v as $item):?>
        <tr>
          <td class="num"><?=++$i;?></td>
          <td>
            <?php if(is_bool($item)):?>
              <?=($item)?'true':'false';?>
            <?php elseif(is_scalar($item)):?>
              <?=$item;?>
            <?php else:?>
              <pre><?php
                  ob_start();
                  var_dump($item);
                  $data = ob_get_clean();
                  echo preg_replace('/=>\n\s+/', ' => ',$data);
                ?>
              </pre>
            <?php endif;?>
          </td>
        </tr>
      <?php endforeach;?>
      </table>

    </div>
    <?php endforeach;?>

  <?php endif;?>
</div>