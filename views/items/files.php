<div id="ptb_data_cont_files" class="ptb_data_cont" style="display: none;">
  <ul class="ptb_tabs">
    <li id="ptb_tab_files">files <span>(<?=$_VARS_FILES['total']['count'];?>)</span></li>
  </ul>
  <div id="ptb_tab_cont_files" class="ptb_tab_cont">
    <table>
      <thead>
        <tr>
          <th>№</th>
          <th>file</th>
          <th style="width:60px;">size</th>
          <th style="width:50px;">lines</th>
          <th style="width:130px;">last modified</th>
        </tr>
      </thead>
      <tbody>
      <?php $docRoot = strlen(DOCROOT);?>
      <?php foreach($_VARS_FILES['data'] as $i=>$file):?>
        <tr>
          <td class="num"><?=$i+1;?></td>
          <td><span style="color: #4a4a4a;"><?=DOCROOT;?></span><?=substr($file['name'],$docRoot);?></td>
          <td class="tRight"><?=ProfilerToolbar::formatMemory($file['size']);?></td>
          <td class="tRight"><?=number_format($file['lines']);?></td>
          <td class="tCenter" style="color: #4a4a4a;">
            <?=date("Y.m.d",$file['lastModified']);?>
            &nbsp;&nbsp;
            <?=date("H:i:s",$file['lastModified']);?>
          </td>
        </tr>
      <?php endforeach;?>
      <tr class="total">
        <th></th>
        <th>total <?=$_VARS_FILES['total']['count'];?> files</th>
        <th class="tRight"><?=ProfilerToolbar::formatMemory($_VARS_FILES['total']['size']);?></th>
        <th class="tRight"><?=number_format($_VARS_FILES['total']['lines']);?></th>
        <th></th>
      </tr>
      </tbody>
    </table>
  </div>
</div>