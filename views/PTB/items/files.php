<div id="ptb_data_cont_files" class="ptb_data_cont" style="display: none;">
  <ul class="ptb_tabs">
    <li id="ptb_tab_files">files <span>(<?php echo ProfilerToolbar::$DATA_INC_FILES['total']['count'];?>)</span></li>
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
      <?php
        $DOCROOT_sep = strlen(DOCROOT);
        $SYSPATH_sep = strrpos(substr(SYSPATH,0,strlen(SYSPATH)-1),DIRECTORY_SEPARATOR)+1;
        $APPPATH_sep = strrpos(substr(APPPATH,0,strlen(APPPATH)-1),DIRECTORY_SEPARATOR)+1;
        $MODPATH_sep = strrpos(substr(MODPATH,0,strlen(MODPATH)-1),DIRECTORY_SEPARATOR)+1;
      ?>
      <?php foreach(ProfilerToolbar::$DATA_INC_FILES['data'] as $i=>$file):?>
        <tr>
          <td class="num"><?php echo $i+1;?></td>
          <td>
            <?php
              if(strpos($file['name'],SYSPATH) === 0)     $sep = $SYSPATH_sep;
              elseif(strpos($file['name'],MODPATH) === 0) $sep = $MODPATH_sep;
              elseif(strpos($file['name'],APPPATH) === 0) $sep = $APPPATH_sep;
              elseif(strpos($file['name'],DOCROOT) === 0) $sep = $DOCROOT_sep;
              else{$sep = 0;}
            ?>
            <span style="color: #4a4a4a;"><?php echo substr($file['name'],0,$sep);?></span><?php echo substr($file['name'],$sep);?>
          </td>
          <td class="tRight"><?php echo ProfilerToolbar::formatMemory($file['size']);?></td>
          <td class="tRight"><?php echo number_format($file['lines']);?></td>
          <td class="tCenter" style="color: #4a4a4a;">
            <?php echo date("Y.m.d",$file['lastModified']);?>&nbsp;&nbsp;<?php echo date("H:i:s",$file['lastModified']);?>
          </td>
        </tr>
      <?php endforeach;?>
      <tr class="total">
        <th></th>
        <th>total <?php echo ProfilerToolbar::$DATA_INC_FILES['total']['count'];?> files</th>
        <th class="tRight"><?php echo ProfilerToolbar::formatMemory(ProfilerToolbar::$DATA_INC_FILES['total']['size']);?></th>
        <th class="tRight"><?php echo number_format(ProfilerToolbar::$DATA_INC_FILES['total']['lines']);?></th>
        <th></th>
      </tr>
      </tbody>
    </table>
  </div>
</div>