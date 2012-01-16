<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_ProfilerToolbar {

  private static $_instance = null;
  public static $version = '0.0.1 beta';
  private static $_cfg = null;
  private static $_CACHE = array();
  private static $_SQL = array();
  private static $_CUSTOM = array();

  public static function render($print = false){
    $tpl = View::factory('tpl');
    
    $_VARS_FILES = self::getFiles();
    $tpl->bind_global('_VARS_FILES',$_VARS_FILES);

    $_VARS_SQL = self::getSql();
    $tpl->bind_global('_VARS_SQL',$_VARS_SQL);
    
    $_VARS_ROUTES = self::getRoutes();
    $tpl->bind_global('_VARS_ROUTES',$_VARS_ROUTES);
    
    $_VARS_GFILES = self::getGFiles();
    $tpl->bind_global('_VARS_GFILES',$_VARS_GFILES);

    $_VARS_CACHE = self::getCache();
    $tpl->bind_global('_VARS_CACHE',$_VARS_CACHE);
    
    $_VARS_APP_TIME = self::getAppTime();
    $tpl->bind_global('_VARS_APP_TIME',$_VARS_APP_TIME);
    
    $_VARS_APP_MEMORY = self::getAppMemory();
    $tpl->bind_global('_VARS_APP_MEMORY',$_VARS_APP_MEMORY);

    $_VARS_CUSTOM = self::getCustom();
    $tpl->bind_global('_VARS_CUSTOM',$_VARS_CUSTOM);

    $html = $tpl->render();
    if($print) echo $html;
    return $html;
  }

  private static function getGFiles(){
    $all = array();
    foreach ($_FILES as $k=>$file) {
      if(is_array($file['name'])){
        $count = count($file['name']);
        for($i=0;$i<$count;$i++){
          $all[$k." [$i]"] = array(
            'name'=>$file['name'][$i],
            'type'=>$file['type'][$i],
            'tmp_name'=>$file['tmp_name'][$i],
            'error'=>$file['error'][$i],
            'size'=>$file['size'][$i]
          );
        }
      }else{
        $all[$k] = $file;
      }
    }
    return $all;
  }

  private static function getSql(){
    $sql = array();
    $groups = Profiler::groups();
    foreach ($groups as $groupName => $benchmarks) {
      if(strpos($groupName,'database') !== 0) continue;
      $sqlGroup = substr($groupName,strpos($groupName,'(')+1,strpos($groupName,')')-strpos($groupName,'(')-1);
      $sql[$sqlGroup] = array('data'=>array(),'total'=>array('time'=>0,'memory'=>0,'count'=>0));
      foreach ($benchmarks as $benchName => $tokens) {
        foreach ($tokens as $token) {
          $stats = Profiler::stats(array($token));
          $sql[$sqlGroup]['data'][] = array(
            'sql'=>$benchName,
            'time'=>$stats['total']['time'],
            'memory'=>$stats['total']['memory'],
            'rows'=>(isset(self::$_SQL[$sqlGroup][$benchName]))?self::$_SQL[$sqlGroup][$benchName]['rows']:null,
            'explain'=>(isset(self::$_SQL[$sqlGroup][$benchName]))?self::$_SQL[$sqlGroup][$benchName]['explain']:null,
          );
          $sql[$sqlGroup]['total']['time'] += $stats['total']['time'];
          $sql[$sqlGroup]['total']['memory'] += $stats['total']['memory'];
          $sql[$sqlGroup]['total']['count']++;
        }
      }
    }
    return $sql;
  }

  public static function setSqlData($instance,$sql,$rows = null,$explain = null){
    self::$_SQL[$instance][$sql]['rows'] = $rows;
    self::$_SQL[$instance][$sql]['explain'] = $explain;
  }

  private static function getFiles(){
    $files = get_included_files();
    $res = array('data'=>array(),'total'=>array('size'=>0,'lines'=>0,'count'=>0));
    foreach ($files as $file) {
      $size = filesize($file);
      $lines = substr_count(file_get_contents($file),"\n");
      $res['total']['size'] += $size;
      $res['total']['lines'] += $lines;
      $res['total']['count']++;
      $res['data'][] = array(
        'name'=>$file,
        'size'=>$size,
        'lines'=>$lines,
        'lastModified'=>filemtime($file),
      );
    }
    return $res;
  }
  
  private static function getRoutes(){
    $res = array('data'=>array(),'total'=>array('count'=>0));
    $res['data'] = Route::all();
    $res['total']['count'] = count($res['data']);
    return $res;
  }

  private static function getCache(){
    if(!isset(self::$_CACHE['total'])) self::$_CACHE['total'] = array('get'=>0,'set'=>0,'del'=>0);
    if(!isset(self::$_CACHE['data'])) {
      self::$_CACHE['data']['default'] = array(
        'total' =>  array('get'=>0,'set'=>0,'del'=>0),
        'data'  =>  array(),
      );
    }
    return self::$_CACHE;
  }

  public static function cacheLog($action,$instalce,$id,$lifetime = null){
    if(!in_array($action,array('get','set','del'))) return;
    self::$_CACHE['data'][$instalce]['data'][] = array(
      'action'=>$action,
      'id'=>$id,
      'lifetime'=>$lifetime
    );
    if(!isset(self::$_CACHE['total'])) self::$_CACHE['total'] = array('get'=>0,'set'=>0,'del'=>0);
    if(!isset(self::$_CACHE['data'][$instalce]['total'])) self::$_CACHE['data'][$instalce]['total'] = array('get'=>0,'set'=>0,'del'=>0);
    self::$_CACHE['total'][$action]++;
    self::$_CACHE['data'][$instalce]['total'][$action]++;
  }

  private static function getAppTime(){
    $tmp = Profiler::application();
    return $tmp['current']['time'];
  }

  private static function getAppMemory(){
//    $tmp = Profiler::application();
//    return $tmp['current']['memory'];
    return memory_get_peak_usage(true);
  }

  private static function getCustom(){
    return self::$_CUSTOM;
  }

  public static function addData($tabName = 'default',$data){
    $tabName = URL::title($tabName);
    self::$_CUSTOM[$tabName][] = $data;
  }

  public static function cfg($param = '',$default = false){
    if(self::$_cfg === null) self::$_cfg = Kohana::$config->load('profilertoolbar');
    if(empty($param)) return self::$_cfg;
    return Arr::path(self::$_cfg,$param,$default);
  }

  // ============================= help functions ==========================================
  public static function formatTime($time){
    $decimals = 6;
    if(($p = self::cfg('format.time')) == 'ms') {$time *= 1000; $decimals = 3;}
    return number_format($time,$decimals)." $p";
  }

  public static function formatMemory($memory){
    if(($p = self::cfg('format.memory')) == 'kb') {$memory /= 1024;}
    else{$memory /= 1024*1024;}
    return number_format($memory)." $p";
  }

}