<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author  Aleksey Ivanov <alertdevelop@gmail.com>
 * @version 0.1.1 beta
 * @see     http://alertdevelop.ru/projects/profilertoolbar
 * @see     https://github.com/Alert/profilertoolbar
*/
class Kohana_ProfilerToolbar {

  public  static $version = '0.1.2';
  public  static $kohana_version = '3.2';
  private static $_cfg = null;
  /* @var FirePHP */
  private static $_fb = null;
  private static $_CACHE = array();
  private static $_SQL = array();
  private static $_CUSTOM = array();

  private static $_data_collected = false;

  // data for output
  public static $DATA_APP_TIME   = null;
  public static $DATA_APP_MEMORY = null;
  public static $DATA_SQL        = null;
  public static $DATA_CACHE      = null;
  public static $DATA_POST       = null;
  public static $DATA_GET        = null;
  public static $DATA_FILES      = null;
  public static $DATA_COOKIE     = null;
  public static $DATA_SESSION    = null;
  public static $DATA_SERVER     = null;
  public static $DATA_ROUTES     = null;
  public static $DATA_INC_FILES  = null;
  public static $DATA_CUSTOM     = null;

  /**
   * Collect all data
   * @static
   * @return void
   */
  private static function collectData(){
    if(self::$_data_collected) return;
    self::$DATA_APP_TIME    = self::getAppTime();
    self::$DATA_APP_MEMORY  = self::getAppMemory();
    self::$DATA_SQL         = self::getSql();
    self::$DATA_CACHE       = self::getCache();
    self::$DATA_POST        = self::getPost();
    self::$DATA_GET         = self::getGet();
    self::$DATA_FILES       = self::getFiles();
    self::$DATA_COOKIE      = self::getCookie();
    self::$DATA_SESSION     = self::getSession();
    self::$DATA_SERVER      = self::getServer();
    self::$DATA_ROUTES      = self::getRoutes();
    self::$DATA_INC_FILES   = self::getIncFiles();
    self::$DATA_CUSTOM      = self::getCustom();
    self::$_data_collected  = true;
  }

  /**
   * Render data to html
   * @static
   * @param bool $print - echo rendered data
   * @return string
   */
  public static function render($print = false){
    if(!self::cfg('html.enabled')) return '';
    self::collectData();
    $html = View::factory('PTB/tpl')->render();
    if($print) echo $html;
    return $html;
  }

  /**
   * Send data to FireBug
   * @static
   * @return void
   */
  public static function firebug(){
    if(!self::cfg('firebug.enabled')) return;

    self::collectData();
    self::$_fb = FirePHP::getInstance(true);
    // set FireBug settings
    $options = self::$_fb->getOptions();
    self::$_fb->setOption('maxObjectDepth',self::cfg('firebug.maxObjectDepth',8));
    self::$_fb->setOption('maxArrayDepth',self::cfg('firebug.maxArrayDepth',8));
    self::$_fb->setOption('maxDepth',self::cfg('firebug.maxDepth',10));

    // append info about module
    self::$_fb->info('========== ProfilerToolbar v'.self::$version.' for Kohana v'.self::$kohana_version.' ==========');
    // append other data
    if(self::cfg('firebug.showTotalInfo'))  self::appendTotalInfo();
    if(self::cfg('firebug.showSql'))        self::appendSql();
    if(self::cfg('firebug.showCache'))      self::appendCache();
    if(self::cfg('firebug.showVars'))       self::appendVars();
    if(self::cfg('firebug.showRoutes'))     self::appendRoutes();
    if(self::cfg('firebug.showIncFiles'))   self::appendIncFiles();
    if(self::cfg('firebug.showCustom'))     self::appendCustom();
    // end
    self::$_fb->info('============================================================');
  }

  // =============== methods for collect data ======================================

  private static function getAppTime(){
    $tmp = Profiler::application();
    return $tmp['current']['time'];
  }

  private static function getAppMemory(){
//    $tmp = Profiler::application();
//    return $tmp['current']['memory'];
    return memory_get_peak_usage(true);
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

  private static function getPost(){
    return (isset($_POST))?$_POST:array();
  }

  private static function getGet(){
    return (isset($_GET))?$_GET:array();
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

  private static function getCookie(){
    return (isset($_COOKIE))?$_COOKIE:array();
  }

  private static function getSession(){
    return (isset($_SESSION))?$_SESSION:array();
  }

  private static function getServer(){
    return (isset($_SERVER))?$_SERVER:array();
  }

  private static function getRoutes(){
    $res = array('data'=>array(),'total'=>array('count'=>0));
    $res['data'] = Route::all();
    $res['total']['count'] = count($res['data']);
    return $res;
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
  
  private static function getCustom(){
    return self::$_CUSTOM;
  }

  // =============== /methods for collect data ======================================

  // =============== methods for append data to Firebug =============================

  private static function appendTotalInfo(){
    self::$_fb->log('[AppTime: '.self::formatTime(self::$DATA_APP_TIME).'] [AppMemory: '.self::formatMemory(self::$DATA_APP_MEMORY).']');
  }

  private static function appendSql(){
    $sql = array('count'=>0,'time'=>0,'memory'=>0);
    foreach(self::$DATA_SQL as $inst) {
      $sql['count']  += $inst['total']['count'];
      $sql['time']   += $inst['total']['time'];
      $sql['memory'] += $inst['total']['memory'];
    }
    self::$_fb->group('SQL [count: '.$sql['count'].'] [time: '.self::formatTime($sql['time']).'] [memory: '.self::formatMemory($sql['memory']).']',array('Collapsed'=>true));
    $tbl = array(0=>array('№','query','rows','time','memory'));
    $tbl_explain = array();
    $num = 0;
    foreach(self::$DATA_SQL as $inst){
      foreach ($inst['data'] as $q) {
        $tbl[] = array(++$num,$q['sql'],$q['rows'],self::formatTime($q['time'],true,false),self::formatMemory($q['memory']));
        if(!empty($q['explain'])){
          $tbl_explain[$num] = array(0=>array('id','select_type','table','type','possible_keys','key','key_len','ref','rows','Extra'));
          foreach($q['explain'] as $val){
            $tbl_explain[$num][] = array($val['id'],$val['select_type'],$val['table'],$val['type'],$val['possible_keys'],$val['key'],$val['key_len'],$val['ref'],$val['rows'],$val['Extra']);
          }
        }
      }
    }
    self::$_fb->table('SQL queries',$tbl);

    if(self::cfg('firebug.showSqlExplain')){
      self::$_fb->group('Explains',array('Collapsed'=>true));
      foreach($tbl_explain as $num=>$tbl){
        self::$_fb->table('EXPLAIN for query № '.$num,$tbl);
      }
      self::$_fb->groupEnd();
    }

    self::$_fb->groupEnd();
    unset($sql);
  }

  private static function appendCache(){
    self::$_fb->group('Cache [GET: '.self::$DATA_CACHE['total']['get'].'] [SET: '.self::$DATA_CACHE['total']['set'].'] [DEL: '.self::$DATA_CACHE['total']['del'].']',array('Collapsed'=>true));
    $num = 0;
    foreach(self::$DATA_CACHE['data'] as $instance=>$data){
      $tbl = array(0=>array('№','action','id','lifetime'));
      foreach($data['data'] as $val){
        $tbl[] = array(++$num,$val['action'],$val['id'],$val['lifetime']);
      }
      self::$_fb->table($instance,$tbl);
    }
    self::$_fb->groupEnd();
  }

  private static function appendVars(){
    $count = array(
      'post'=>count(self::$DATA_POST),
      'get'=>count(self::$DATA_GET),
      'files'=>count(self::$DATA_FILES),
      'cookie'=>count(self::$DATA_COOKIE),
      'session'=>count(self::$DATA_SESSION),
    );
    self::$_fb->group("Vars [POST: {$count['post']}] [GET: {$count['get']}] [FILES: {$count['files']}] [COOKIE: {$count['cookie']}] [SESSION: {$count['session']}]",array('Collapsed'=>true));
    self::$_fb->log(self::$DATA_POST,'POST ('.$count['post'].')');
    self::$_fb->log(self::$DATA_GET,'GET ('.$count['get'].')');
    self::$_fb->log(self::$DATA_FILES,'FILES ('.$count['files'].')');
    self::$_fb->log(self::$DATA_COOKIE,'COOKIE ('.$count['cookie'].')');
    self::$_fb->log(self::$DATA_SESSION,'SESSION ('.$count['session'].')');
    self::$_fb->log(self::$DATA_SERVER,'SERVER');
    self::$_fb->groupEnd();
    unset($count);
  }

  private static function appendRoutes(){
    self::$_fb->group('Routes ('.self::$DATA_ROUTES['total']['count'].')',array('Collapsed'=>true));
    $tbl = array(0=>array('№','name','controller','action','params'));
    $num = 0;
    foreach(ProfilerToolbar::$DATA_ROUTES['data'] as $name=>$route){
      if(Request::$current->route() == $route){
        $params = '';
        foreach(Request::$current->param() as $k=>$v) $params .= $k.': '.$v.'; ';
        $tbl[] = array(++$num,'✔ '.$name,Request::$current->controller(),Request::$current->action(),$params);
      }else{
        $tbl[] = array(++$num,$name,'','','');
      }
    }
    self::$_fb->table('Routes',$tbl);
    self::$_fb->groupEnd();
  }

  private static function appendIncFiles(){
    self::$_fb->group('Files ('.self::$DATA_INC_FILES['total']['count'].')',array('Collapsed'=>true));
    $tbl = array(0=>array('№','file','size','lines','last modified'));
    $num = 0;
    foreach (self::$DATA_INC_FILES['data'] as $file) {
      $tbl[] = array(++$num,$file['name'],ProfilerToolbar::formatMemory($file['size']),number_format($file['lines']),date("Y.m.d H:i:s",$file['lastModified']));
    }
    self::$_fb->table('Files',$tbl);
    self::$_fb->groupEnd();
  }

  private static function appendCustom(){
    $custom_count = 0;
    foreach(ProfilerToolbar::$DATA_CUSTOM as $v) $custom_count += count($v);
    self::$_fb->group('YOUR ('.$custom_count.')',array('Collapsed'=>true));
    foreach(self::$DATA_CUSTOM as $k=>$data){
      self::$_fb->group($k,array('Collapsed'=>true));
      $num = 0;
      foreach($data as $item){
        self::$_fb->log($item,++$num);
      }
      self::$_fb->groupEnd();
    }
    self::$_fb->groupEnd();
  }

  // =============== /methods for append data to Firebug =============================

  /**
   * Collect sql queries
   * Used in database classes
   * @static
   * @param $instance
   * @param $sql
   * @param null $rows
   * @param null $explain
   * @return void
   */
  public static function setSqlData($instance,$sql,$rows = null,$explain = null){
    self::$_SQL[$instance][$sql]['rows'] = $rows;
    self::$_SQL[$instance][$sql]['explain'] = $explain;
  }

  /**
   * Collect Cache log item
   * Used in Cache classes
   * @static
   * @param $action
   * @param $instalce
   * @param $id
   * @param null $lifetime
   * @return void
   */
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

  /**
   * Add YOUR custom data
   * @static
   * @param string $tabName
   * @param $data mixed
   * @return void
   */
  public static function addData($tabName = 'default',$data){
    $tabName = URL::title($tabName);
    self::$_CUSTOM[$tabName][] = $data;
  }

  /**
   * Get module config param
   * @static
   * @param string $param
   * @param bool $default
   * @return mixed
   */
  public static function cfg($param = '',$default = false){
    if(self::$_cfg === null) self::$_cfg = Kohana::$config->load('profilertoolbar');
    if(empty($param)) return self::$_cfg;
    return Arr::path(self::$_cfg,$param,$default);
  }

  // ============================= help functions ==========================================
  public static function formatTime($time, $addUnit = true, $spaceBeforeUnit = true){
    $decimals = 6;
    if(($p = self::cfg('format.time')) == 'ms') {$time *= 1000; $decimals = 3;}
    $res = number_format($time,$decimals);
    if($addUnit) $res .= ($spaceBeforeUnit)?' '.$p:$p;
    return $res;
  }

  public static function formatMemory($memory, $addUnit = true, $spaceBeforeUnit = true){
    if(($p = self::cfg('format.memory')) == 'kb') $memory /= 1024;
    else $memory /= 1024*1024;
    $res = number_format($memory);
    if($addUnit) $res .= ($spaceBeforeUnit)?' '.$p:$p;
    return $res;
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