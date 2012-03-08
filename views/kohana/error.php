<?php if(Request::initial()->is_ajax()):?>
<?php echo "{$type} [ {$code} ]\n{$message}";?>
<?php else:?>

<?php $error_id = uniqid('error');?>
  <?php echo View::factory('PTB/highlight.css');?>
  <style type="text/css">
    body{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAAAAACMmsGiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAABdJREFUCB1jUlGRkWH6CQRMf//y8oJZAFUaCmUwcfODAAAAAElFTkSuQmCC);}
    #ptb_err{font-size: 10pt; font-family:sans-serif; text-align: left; color: gray; margin-top: 30px;}
    #ptb_err a{color:gray;}
    #ptb_err pre{overflow: auto; white-space: pre-wrap; font-size: 9pt; line-height: 12pt; margin: 4px 0; border-radius: 3px;}
    #ptb_err code{}
    #ptb_err pre span.line { display: block; }
    #ptb_err pre span.highlight { background: #414040; }
    #ptb_err pre span.line span.number { color: #666; }
    #ptb_err .head{margin-bottom: 4px; background: #8C0B0B; color:white; padding: 10px; border-radius: 3px;}
    #ptb_err .head .type{font-weight: bold; margin: 0;}
    #ptb_err .head .message{margin: 3px 0 0 0;}
    #ptb_err .content{padding: 0 10px; margin: 10px 0 0 0;}
    #ptb_err .content .filePath{margin: 0;}
    #ptb_err .content .filePath .lineNum{}
    #ptb_err .content pre.source{}
    #ptb_err .content ol.trace{padding: 0 0 0 10px;}
    #ptb_err .content ol.trace li{margin: 4px 0;}
    #ptb_err .content ol.trace li pre.source{display: none;}
    #ptb_err .content ol.trace li table.arguments{display: none; font-size: 9pt; border-collapse: collapse;padding: 0;width: 100%; margin: 5px 0;}
    #ptb_err .content ol.trace li table.arguments td {border: 1px solid #252424;color: gray;padding: 3px;text-align: left;vertical-align: top;}
    #ptb_err .content ol.trace li table.arguments td.name{text-align: center; width: 30px; font-size: 9pt;}
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
    <?php echo View::factory('PTB/highlight.js');?>

    function init(){
      var ptb_err = document.getElementById('ptb_err');
      var sql_els = ptb_err.getElementsByClassName('sql');
      for(var i=0;i<sql_els.length;i++) hljs.highlightBlock(sql_els[i],'  ');
    }

    if(document.addEventListener){
      window.addEventListener('load',init,false);
    }else if(document.attachEvent){
      window.attachEvent("onload",init);
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
        <pre><code class="sql"><?php echo trim(rtrim($sql),"\n");?></code></pre>
      <?php else:?>
      <?php echo html::chars($message); ?>
      <?php endif;?>

      </div>
    </div>

    <div class="content" id="<?php echo $error_id ?>">
      <p class="filePath"><?php echo Debug::path($file);?> <span class="lineNum">[ <?php echo $line;?> ]</span></p>
      <pre class="source"><!--
      --><code class="php"><!--
        --><?php
            $source = Debug::source($file, $line);
            $source = UTF8::str_ireplace('<pre class="source"><code>','',$source);
            $source = UTF8::str_ireplace('</code></pre>','',$source);
            echo trim($source);
          ?><!--
      --></code><!--
    --></pre>

      <ol class="trace">
        <?php foreach(Debug::trace($trace) as $i => $step): ?>
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
          <pre class="source" id="<?php echo $source_id ?>"><!--
          --><code class="php"><!--
            --><?php
                $source = $step['source'];
                $source = UTF8::str_ireplace('<pre class="source"><code>','',$source);
                $source = UTF8::str_ireplace('</code></pre>','',$source);
                echo trim($source);
              ?><!--
          --></code><!--
        --></pre>
          <?php endif ?>

        </li>
        <?php unset($args_id, $source_id); ?>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>

<?php ProfilerToolbar::render(true);?>
<?php endif;?>