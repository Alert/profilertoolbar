<div id="ptb_data_cont_vars" class="ptb_data_cont">
  <ul class="ptb_tabs">
    <li id="ptb_tab_varsPGF">$_POST<span>(<?=count($_POST);?>)</span> / $_GET<span>(<?=count($_GET);?>)</span> / $_FILES<span>(<?=count($_FILES);?>)</span></li>
    <li id="ptb_tab_varsCS">$_COOKIE<span>(<?=count($_COOKIE);?>)</span> / $_SESSION<span>(<?=count($_SESSION);?>)</span></li>
    <li id="ptb_tab_varsS">$_SERVER</li>
  </ul>
  <div class="ptb_tab_cont" id="ptb_tab_cont_varsPGF">
    <!-- POST/GET/FILES -->
    <?php $vars = array('POST'=>$_POST,'GET'=>$_GET);?>
    <?php foreach ($vars as $kvar=>$var):?>
    <table style="float: left; width: <?=($kvar=='POST')?50:45;?>%;">
      <thead>
        <tr><th colspan="3"><?=$kvar;?></th></tr>
        <tr>
          <th>№</th>
          <th style="width: 1px;">key</th>
          <th>value</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($var)):?><tr><td colspan="3" class="empty">—</td></tr><?php endif;?>
      <?php $i=0; foreach ($var as $k => $v):?>
      <tr>
        <td class="num"><?=++$i;?></td>
        <td><?=$k;?></td>
        <td><?=$v;?></td>
      </tr>
      <?php endforeach;?>
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
      <?php if(empty($_FILES)):?><tr><td colspan="7" class="empty">—</td></tr><?php endif;?>
      <?php $i=0; foreach ($_FILES as $k => $v):?>
      <tr>
        <td class="num"><?=++$i;?></td>
        <td><?=$k;?></td>
        <td><?=$v['name'];?></td>
        <td><?=$v['type'];?></td>
        <td><?=$v['tmp_name'];?></td>
        <td><?=$v['error'];?></td>
        <td><?=ProfilerToolbar::formatMemory($v['size']);?></td>
        
      </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="ptb_tab_cont" id="ptb_tab_cont_varsCS">
    <!-- COOKIE/SESSION -->
    <?php $vars = array('COOKIE'=>$_COOKIE,'SESSION'=>$_SESSION);?>
    <?php foreach ($vars as $kvar=>$var):?>
    <table style="float: left; width: 45%;">
      <thead>
        <tr><th colspan="3"><?=$kvar;?></th></tr>
        <tr>
          <th>№</th>
          <th style="width: 1px;">key</th>
          <th>value</th>
        </tr>
      </thead>
      <tbody>
      <?php $i=0; foreach ($var as $k => $v):?>
      <tr>
        <td class="num"><?=++$i;?></td>
        <td><?=$k;?></td>
        <td><?php if(is_scalar($v)) echo $v; else {echo '<pre>';var_dump($v);echo '</pre>';}?></td>
      </tr>
      <?php endforeach;?>
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
      <?php $i=0; foreach ($_SERVER as $k => $v):?>
      <tr>
        <td class="num"><?=++$i;?></td>
        <td><?=$k;?></td>
        <td><?=$v;?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>