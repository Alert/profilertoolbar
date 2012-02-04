<?php defined('SYSPATH') or die('No direct script access.');
return array(
  // rendered panel data settings
  'html'=>array(
    'enabled'         => true, // if set FALSE, panel don't be rendered on page

    'showTotalInfo'   => true, // show application time and memory peak usage
    'showSql'         => true, // show sql queries
    'showSqlExplain'  => true, // show EXPLAIN for all SELECT queries
    'showCache'       => true, // show Cache
    'showVars'        => true, // show all global vars
    'showRoutes'      => true, // show routes
    'showIncFiles'    => true, // show all included files
    'showCustom'      => true, // show YOUR custom data
  ),
  // firebug data settings
  'firebug'=>array(
    'enabled'         => true, // if set FALSE, panel don't be shown in firebug
    'showEverywhere'  => true, // if set TRUE you don't need write ProfilerToolbar::firebug(); they will show in all Controllers

    'showTotalInfo'   => true, // show application time and memory peak usage
    'showSql'         => true, // show sql queries
    'showSqlExplain'  => true, // show EXPLAIN for all SELECT queries
    'showCache'       => true, // show Cache
    'showVars'        => true, // show all global vars
    'showRoutes'      => true, // show routes
    'showIncFiles'    => true, // show all included files
    'showCustom'      => true, // show YOUR custom data

    'maxObjectDepth'  => 5,  // Maximum depth to traverse objects
    'maxArrayDepth'   => 5,  // Maximum depth to traverse arrays
    'maxDepth'        => 10, // Maximum depth to traverse mixed arrays/objects
  ),

  // output vars format
  'format'=>array(
    /**
     * possible values:
     *  s - seconds
     *  ms - milliseconds
     */
    'time'=>'s',
    /**
     * possible values:
     *  kb - kilobytes
     *  mb - megabytes
     */
    'memory'=>'kb'
  ),


);