<div id="ptb_data_cont_route" class="ptb_data_cont">
  <ul class="ptb_tabs">
    <li id="ptb_tab_route">route <span>(<?=$_VARS_ROUTES['total']['count'];?>)</span></li>
  </ul>

  <div id="ptb_tab_cont_route" class="ptb_tab_cont">
    <table>
      <thead>
        <tr>
          <th>№</th>
          <th style="width: 150px;">name</th>
          <th style="width: 120px;">controller</th>
          <th style="width: 120px;">action</th>
          <th>params</th>
        </tr>
      </thead>
      <tbody>
      <?php $i=0; foreach($_VARS_ROUTES['data'] as $name=>$route):?>
      <?php $current = Request::$current->route() == $route;?>
        <tr <?php if($current):?>class="total"<?php endif;?>>
          <td class="num"><?=++$i;?></td>
          <td>
            <?=$name;?>
          </td>
          <td class="tCenter"><?=($current)?Request::$current->controller():'';?></td>
          <td class="tCenter"><?=($current)?Request::$current->action():'';?></td>
          <td class="tCenter">
            <?php if($current):?>
              <?php foreach(Request::$current->param() as $k=>$v):?>
                <?=$k;?>: <?=$v;?><br />
              <?php endforeach;?>
            <?php endif;?>
          </td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>