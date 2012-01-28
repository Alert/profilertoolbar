<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author  Aleksey <alertdevelop@gmail.com>
 * @version 0.0.3
 * @see     http://alertdevelop.ru/projects/profilertoolbar
*/
class Kohana_ProfilerToolbar {

  public  static $version = '0.0.3';
  private static $_cfg = null;
  private static $_CACHE = array();
  private static $_SQL = array();
  private static $_CUSTOM = array();

  public static function render($print = false){
    $tpl = View::factory('tpl');

    $data = array(
      '_VARS_APP_TIME'  =>'getAppTime',
      '_VARS_APP_MEMORY'=>'getAppMemory',
      '_VARS_SQL'       =>'getSql',
      '_VARS_CACHE'     =>'getCache',
      '_VARS_POST'      =>'getPost',
      '_VARS_GET'       =>'getGet',
      '_VARS_FILES'     =>'getFiles',
      '_VARS_COOKIE'    =>'getCookie',
      '_VARS_SESSION'   =>'getSession',
      '_VARS_SERVER'    =>'getServer',
      '_VARS_ROUTES'    =>'getRoutes',
      '_VARS_INCFILES'  =>'getIncFiles',
      '_VARS_CUSTOM'    =>'getCustom',
    );

    foreach ($data as $var=>$method) {
      ${$var} = self::$method();
      $tpl->bind_global($var,${$var});
    }

    $html = $tpl->render();
    if($print) echo $html;
    return $html;
  }

  private static function getFiles(){
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

  private static function getIncFiles(){
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

  private static function getPost(){
    return (isset($_POST))?$_POST:array();
  }

  private static function getGet(){
    return (isset($_GET))?$_GET:array();
  }

  private static function getCookie(){
    return (isset($_COOKIE))?$_COOKIE:array();
  }

  private static function getSession(){
    return (isset($_SESSION))?$_SESSION:array();
  }

  private static function getServer(){
    return (isset($_SERVER))?$_SERVER:array();
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
    if(($p = self::cfg('format.memory')) == 'kb') $memory /= 1024;
    else $memory /= 1024*1024;
    return number_format($memory)." $p";
  }

  public static function varDump($var){
    if(is_bool($var)) return ($var)?'true':'false';
    elseif(is_scalar($var)) return (string)$var;
    else{
      ob_start();
      var_dump($var);
      return '<pre>'.preg_replace('/=>\n\s+/', ' => ',ob_get_clean()).'</pre>';
    }
  }

}