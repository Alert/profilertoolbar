<?php defined('SYSPATH') or die('No direct script access.');

// include vendor FireBug
if(ProfilerToolbar::cfg('firebug.enabled') && !class_exists('FireBug')){
  require_once Kohana::find_file('vendor/FirePHPCore','FirePHP.class','php');
}

