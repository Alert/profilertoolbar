<?php if(isset(Request::$initial) && Request::$initial->is_ajax()):?>
<?php echo "{$type} [ {$code} ]\n{$message}";?>
<?php else:?>

<?php $highlightSQL = ProfilerToolbar::cfg('errorPage.highlightSQL'); ;?>
<?php $highlightPHP = ProfilerToolbar::cfg('errorPage.highlightPHP'); ;?>

<?php $error_id = uniqid('error');?>
  <style type="text/css">
    body{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAAAAACMmsGiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAABdJREFUCB1jUlGRkWH6CQRMf//y8oJZAFUaCmUwcfODAAAAAElFTkSuQmCC);}
    #ptb_err{font-size: 10pt; font-family:sans-serif; text-align: left; color: gray; margin-top: 30px;}
    #ptb_err a{color:gray;}
    #ptb_err pre{}
    #ptb_err pre.source{overflow: auto; white-space: pre-wrap; font-size: 9pt; line-height: 12pt; margin: 4px 0; border-radius: 3px; padding: 4px 5px 4px 8px; background-color: /*#171717*/#242323; color: white;}
    #ptb_err pre.source span.line { display: block; }
    #ptb_err pre.source span.highlight { background: #414040; }
    #ptb_err pre.source span.line span.num { color: #666; }
    #ptb_err .head{margin-bottom: 4px; background: #8C0B0B; color:white; padding: 10px; border-radius: 3px;}
    #ptb_err .head .type{font-weight: bold; margin: 0;}
    #ptb_err .head .message{margin: 3px 0 0 0;}
    #ptb_err .content{padding: 0 10px; margin: 10px 0 0 0;}
    #ptb_err .content .filePath{margin: 0;}
    #ptb_err .content .filePath .lineNum{}
    #ptb_err .content ol.trace{padding: 0 0 0 10px;}
    #ptb_err .content ol.trace li{margin: 4px 0;}
    #ptb_err .content ol.trace li pre.source{display: none;}
    #ptb_err .content ol.trace li table.arguments{display: none; font-size: 9pt; border-collapse: collapse;padding: 0;width: 100%; margin: 5px 0;}
    #ptb_err .content ol.trace li table.arguments td {border: 1px solid #252424;color: gray;padding: 3px;text-align: left;vertical-align: top;}
    #ptb_err .content ol.trace li table.arguments td.name{text-align: center; width: 30px; font-size: 9pt;}
    <!-- highlight -->
    #ptb_err pre.sql .imp {font-weight: bold; color: red;}
    #ptb_err pre.sql .kw1 {color: #388fff;}
    #ptb_err pre.sql .co1 {color: #808080;}
    #ptb_err pre.sql .co2 {color: #808080;}
    #ptb_err pre.sql .coMULTI {color: #808080;}
    #ptb_err pre.sql .es0 {color: #000099; font-weight: bold;}
    #ptb_err pre.sql .br0 {}
    #ptb_err pre.sql .st0 {color: #ff9933;}
    #ptb_err pre.sql .nu0 {color: #66ff00;}

    #ptb_err pre.php .imp {font-weight: bold; color: red;} 
    #ptb_err pre.php .kw1 {color: #388fff;}
    #ptb_err pre.php .kw2 {color: #388fff; font-weight: bold;}
    #ptb_err pre.php .kw3 {color: #388fff;}
    #ptb_err pre.php .co1 {color: #808080;}
    #ptb_err pre.php .co2 {color: #808080;}
    #ptb_err pre.php .coMULTI {color: #808080;}
    #ptb_err pre.php .es0 {color: #ffdf08; font-weight: bold;}
    #ptb_err pre.php .br0 {}
    #ptb_err pre.php .st0 {color: #ff9933;}
    #ptb_err pre.php .nu0 {color: #66ff00;}
    #ptb_err pre.php .me1 {}
    #ptb_err pre.php .me2 {}
    #ptb_err pre.php .re0 {color: #66ff66;}
    #ptb_err pre.php .re1 {color: #ff9933}
    <!-- /highlight -->
  </style>

  <script type="text/javascript">
    function koggle(elem){
      elem = document.getElementById(elem);
      if (elem.style && elem.style['display']) var disp = elem.style['display'];
      else if (elem.currentStyle) var disp = elem.currentStyle['display'];
      else if (window.getComputedStyle) var disp = document.defaultView.getComputedStyle(elem, null).getPropertyValue('display');
      elem.style.display = disp == 'block' ? 'none' : 'block';
      return false;
    }
  </script>

  <div id="ptb_err">
    <div class="head">
      <div class="type"><?php echo $type;?> <span class="typeCode">[ <?php echo $code;?> ]</span></div>
      <div class="message">
      <?php if($type == 'Database_Exception'):?>
      <?php
        $start = UTF8::strpos($message,'[ ');
        $end   = UTF8::strpos($message,' ]');
        $sql   = UTF8::substr($message,$start+2,$end-$start-2);
        $message =  UTF8::substr($message,0,$start);
      ?>
        <?php echo $message;?>
        <?php if($highlightSQL):?>
          <pre class="source sql"><?php echo ProfilerToolbar::highlight($sql,'sql')?></pre>
        <?php else:?>
          <pre class="source"><?php echo $sql;?></pre>
        <?php endif;?>
      <?php else:?>
      <?php echo html::chars($message); ?>
      <?php endif;?>

      </div>
    </div>

    <div class="content" id="<?php echo $error_id ?>">
      <p class="filePath"><?php echo Debug::path($file);?> <span class="lineNum">[ <?php echo $line;?> ]</span></p>
      <?php if($highlightPHP):?>
        <pre class="source php"><?php echo ProfilerToolbar::debugSource($file, $line,5,true,'php');?></pre>
      <?php else:?>
        <pre class="source"><?php echo ProfilerToolbar::debugSource($file, $line);?></pre>
      <?php endif;?>

      <ol class="trace">
        <?php foreach(ProfilerToolbar::debugTrace($trace,$highlightPHP,'php') as $i => $step): ?>
        <li>
          <p class="filePath">
            <?php if($step['file']): $source_id = $error_id.'source'.$i; ?>
            <a href="#<?php echo $source_id ?>" onclick="return koggle('<?php echo $source_id ?>')"><?php echo Debug::path($step['file']) ?> <span class="lineNum">[ <?php echo $step['line'] ?> ]</span></a>
            <?php else: ?>
            {<?php echo __('PHP internal call') ?>}
            <?php endif ?>
            &raquo;
            <?php echo $step['function'] ?>
            (
            <?php if($step['args']): $args_id = $error_id.'args'.$i; ?>
            <a href="#<?php echo $args_id ?>" onclick="return koggle('<?php echo $args_id ?>')"><?php echo __('arguments') ?></a>
            <?php endif ?>
            )
          </p>

          <?php if(isset($args_id)): ?>
          <table id="<?php echo $args_id ?>" class="arguments">
            <?php foreach($step['args'] as $name => $arg): ?>
            <tr>
              <td class="name"><?php echo $name;?></td>
              <td><?php echo ProfilerToolbar::varDump($arg); ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
          <?php endif;?>

          <?php if(isset($source_id)): ?>
            <?php if($highlightPHP):?>
            <pre class="source php" id="<?php echo $source_id ?>"><?php echo $step['source'];?></pre>
            <?php else:?>
            <pre class="source" id="<?php echo $source_id ?>"><?php echo $step['source'];?></pre>
            <?php endif;?>
          <?php endif ?>

        </li>
        <?php unset($args_id, $source_id); ?>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>

<?php ProfilerToolbar::render(true);?>
<?php endif;?>